function raloadtocm() {
	nhapdanhsachtochuyenmon();
	var dataGrid = $("#girdnhapdanhsachtochuyenmon").dxDataGrid("instance");
	dataGrid.refresh();
}

function nhapdanhsachtochuyenmon(){
	var data = axios.get('getdanhsachtochuyenmon').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	

		$("#girdnhapdanhsachtochuyenmon").dxDataGrid({
			dataSource: datas,
			showBorders: true,
				// remoteOperations: true,
				// scrolling: {
				// 	mode: "virtual",
				// 	rowRenderingMode: "virtual"
				// },
				paging: {
					pageSize: 10
				},
				/* xap xep */
				sorting: {
					mode: "multiple"
				},
				/* loc du lieu */
				filterRow: {
					visible: true,
					applyFilter: "auto"
				},
				searchPanel: {
					visible: true,
					width: 240,
					placeholder: "Tìm kiếm..."
				},
				pager: {
					showPageSizeSelector: true,
					allowedPageSizes: [5, 10, 20],
					showInfo: true
				},
				/* headerFilter: {
					visible: true
				}, */
				/*chon row*/
				selection: {
					mode: "single"
				},
				editing: {
					mode: "batch",
					allowUpdating: true,
					selectTextOnEditStart: true,
					startEditAction: "click",
                    // allowDeleting: true,
                    allowAdding: true,
                },
                /* co dan cot */
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columns: [{
                	caption: "STT",
                	dataField: "stt",
                	width: 50,
                	allowEditing: false,
                }, {
                	caption: "Tên tổ chuyên môn",
                	dataField: "tentocm",	
                },{
                	caption: "Tên viết tắt",
                	dataField: "tenviettat",
                }],
				// select data row
				onSelectionChanged: function (selectedItems) {
				},

				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if(e.newData.tentocm === undefined){
						var tocmten = e.oldData.tentocm;
					}else{
						var tocmten = e.newData.tentocm;
					}	
					if(e.newData.tenviettat === undefined){
						var tocmtenviettat = e.oldData.tenviettat;
					}else{
						var tocmtenviettat = e.newData.tenviettat;
					}					
					axios.post('updatedanhsachtochuyenmon', {id:id,tentocm:tocmten,tenviettat:tocmtenviettat}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã lưu thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						raloadtocm();
					});
				},


				onRowInserting: function(e) {
					if(e.data.tentocm === undefined){
						var tocmten = "";
					}else{
						var tocmten = e.data.tentocm;
					}
					if(e.data.tenviettat === undefined){
						var tocmtenviettat = '';
					}else{
						var tocmtenviettat = e.data.tenviettat;
					}					
					axios.post('adddanhsachtochuyenmon',{tentocm:tocmten,tenviettat:tocmtenviettat}).then(function (response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã thêm mới thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						raloadtocm();
					});
				},



				onContextMenuPreparing: function(data) { 
					if (data.target == "content") {
						if (!data.items) data.items = [];
						data.items.push({
							template: function () {
								return $("<i class='fa fa-remove'>").text(" Xóa");                  
							},
							onItemClick: function() {
								var dataxoa = data.row.data.id;
								xoatocm(dataxoa);
							}
						});
						data.items.push({
							template: function () {
								return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
							},
							onItemClick: function() {
								var dataxoahet = datas;
								xoatoantocm(dataxoahet);
							}
						});
					} 
				}



			});
	});
}




function xoatocm(id) {
      Swal.fire({
            title: 'Lưu',
            text: "Bạn có muốn xóa tổ chuyên môn này không",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
      }).then((result) => {
            if (result.value) {
                  axios.post('deldanhsachtochuyenmon',{id:id}).then(function (response) {
                        var data = response.data;
                        Swal.fire({
                              position: 'center',
                              icon: 'success',
                              text: 'Đã xóa thành công',
                              showConfirmButton: false,
                              timer: 1000
                        });   
                        raloadtocm();
                  });
            }           
      })
}

function xoatoantocm(id) {
      Swal.fire({
            title: 'Lưu',
            text: "Bạn có muốn xóa toàn bộ tổ chuyên môn không",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
      }).then((result) => {
            if (result.value) {
                  axios.post('deltoanbodanhsachtochuyenmon',{id:id}).then(function (response) {
                        var data = response.data;
                        Swal.fire({
                              position: 'center',
                              icon: 'success',
                              text: 'Đã xóa thành công',
                              showConfirmButton: false,
                              timer: 1000
                        });   
                        raloadtocm();
                  });
            }           
      })
}



