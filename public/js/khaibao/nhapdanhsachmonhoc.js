
function nhapdanhsachmonhoc(){
	var datatocm = [];
	axios.get('getdanhsachtochuyenmon').then(function(response) {
		var datacm = response.data;
		datatocm.push(datacm);
	});
	
	var data = axios.get('getdanhsachmonhoc').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		$("#girdnhapdanhsachmonhoc").dxDataGrid({
			dataSource: datas,
			showBorders: true,
				paging: {
					pageSize: 10
				},
				sorting: {
					mode: "multiple"
				},
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
				scrolling: {
					mode: 'infinite'
				},
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
                	caption: "Tên môn học",
                	dataField: "tenmonhoc",	
                },{
                	caption: "Tên môn học viết tắt",
                	dataField: "monhocviettat",
                },
                {
                	caption: "Tổ chuyên môn",
                	dataField: "matochuyenmon",
                	lookup: {
                		dataSource: datatocm[0],
                		displayExpr: "tentocm",
                		valueExpr: "id",
                	}
                }],
				// select data row
				onSelectionChanged: function (selectedItems) {
				},

				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if(e.newData.tenmonhoc === undefined){
						var dsmhtenmonhoc = e.oldData.tenmonhoc;
					}else{
						var dsmhtenmonhoc = e.newData.tenmonhoc;
					}	
					if(e.newData.matochuyenmon === undefined){
						var dsmhtochuyemon = e.oldData.matochuyenmon;
					}else{
						var dsmhtochuyemon = e.newData.matochuyenmon;
					}
					if(e.newData.monhocviettat === undefined){
						var dsmhtenviettat = e.oldData.monhocviettat;
					}else{
						var dsmhtenviettat = e.newData.monhocviettat;
					}					
					axios.post('updatedanhsachmonhoc', {id:id,tenmonhoc:dsmhtenmonhoc,matochuyenmon:dsmhtochuyemon,monhocviettat:dsmhtenviettat}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã lưu thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloaddsmonhoc();
					});
				},


				onRowInserting: function(e) {
					if(e.data.tenmonhoc === undefined){
						var dsmhtenmonhoc = "";
					}else{
						var dsmhtenmonhoc = e.data.tenmonhoc;
					}	
					if(e.data.matochuyenmon === undefined){
						var dsmhtochuyemon = "";
					}else{
						var dsmhtochuyemon = e.data.matochuyenmon;
					}
					if(e.data.monhocviettat === undefined){
						var mhviettat = e.data.tenmonhoc;
						var name1 = mhviettat.split(' ');
						var mh = [];
						for (var i = 0; i < name1.length; i++) {
							var el = name1[i];
							var first_name = el.slice(0,1);
							mh.push(first_name);
						}
						var mhstring = mh.toString();
						var name2 = mhstring.replace(/,/g, '');
						var dsmhtenviettat = name2;
					}else{
						var dsmhtenviettat = e.data.monhocviettat;
					}						
					axios.post('adddanhsachmonhoc',{tenmonhoc:dsmhtenmonhoc,matochuyenmon:dsmhtochuyemon,monhocviettat:dsmhtenviettat}).then(function (response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã thêm mới thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloaddsmonhoc();
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
								xoadsmonhoc(dataxoa);
							}
						});
						data.items.push({
							template: function () {
								return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
							},
							onItemClick: function() {
								var dataxoahet = datas;
								xoatoanbodsmonhoc(dataxoahet);
							}
						});
					} 
				}





			});
});
}


function reloaddsmonhoc() {
	nhapdanhsachmonhoc();
	var dataGrid = $("#girdnhapdanhsachmonhoc").dxDataGrid("instance");
	dataGrid.refresh();
}





function xoadsmonhoc(id) {
      Swal.fire({
            title: 'Lưu',
            text: "Bạn có muốn xóa môn học này không",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
      }).then((result) => {
            if (result.value) {
                  axios.post('deldanhsachmonhoc',{id:id}).then(function (response) {
                        var data = response.data;
                        Swal.fire({
                              position: 'center',
                              icon: 'success',
                              text: 'Đã xóa thành công',
                              showConfirmButton: false,
                              timer: 1000
                        });   
                        reloaddsmonhoc();
                  });
            }           
      })
}

function xoatoanbodsmonhoc(id) {
      Swal.fire({
            title: 'Lưu',
            text: "Bạn có muốn xóa toàn bộ các môn không",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
      }).then((result) => {
            if (result.value) {
                  axios.post('deltoanbodanhsachmonhoc',{id:id}).then(function (response) {
                        var data = response.data;
                        Swal.fire({
                              position: 'center',
                              icon: 'success',
                              text: 'Đã xóa thành công',
                              showConfirmButton: false,
                              timer: 1000
                        });   
                        reloaddsmonhoc();
                  });
            }           
      })
}



