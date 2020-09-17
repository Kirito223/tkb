
function reloaddslophoc() {
	nhapdanhsachlophoc();
	var dataGrid = $("#girdnhapdanhsachlophoc").dxDataGrid("instance");
	dataGrid.refresh();
}


function nhapdanhsachlophoc(){
	var data = axios.get('getdanhsachlophoc').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		$("#girdnhapdanhsachlophoc").dxDataGrid({
			dataSource: datas,
			showBorders: true,
			remoteOperations: true,
			scrolling: {
				mode: "virtual",
			},
			rowDragging: {
				allowReordering: true,
				onReorder: function(e) {
					var visibleRows = e.component.getVisibleRows(),
					toIndex = datas.indexOf(visibleRows[e.toIndex].data),
					fromIndex = datas.indexOf(e.itemData);
					if(fromIndex > toIndex){
						var item = e.itemData;
						var thutuhienthi = (item.thutuhienthi);
						axios.post('updatethutuhienthi',{id:item.id,thutuhienthi:thutuhienthi}).then(function (response) {
							var data = response.data;
							datas.splice(fromIndex, 1);
							datas.splice(toIndex, 0, e.itemData);
							e.component.refresh();		
							reloaddslophoc();
						});
					}else{
						var item = e.itemData;
						var thutuhienthi = (item.thutuhienthi)+toIndex;
						axios.post('updatethutuhienthi',{id:item.id,thutuhienthi:thutuhienthi}).then(function (response) {
							var data = response.data;
							datas.splice(fromIndex, 1);
							datas.splice(toIndex, 0, e.itemData);
							e.component.refresh();		
							reloaddslophoc();
						});
					}
				}
			},
			paging: {
				pageSize: 10
			},
			height:700,
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
                	caption: "Tên lớp học",
                	dataField: "tenlop",	
                },{
                	caption: "Khối học",
                	dataField: "khoi",
                	allowEditing: false,
                },{
                	caption: "Thứ tự hiển thị",
                	dataField: "thutuhienthi",
                }, 
                ],
				// select data row
				onSelectionChanged: function (selectedItems) {
					// var data  = selectedItems.selectedRowsData[0];
					// document.getElementById("formthemmoilophoc").style.display = "block";
					// document.getElementById("dslhluu").hidden = true;
					// document.getElementById("dslhupdate").hidden = false;
					// loaditemlophoc(data);
				},
				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if(e.newData.tenlop === undefined){
						var dslhtenlophoc = e.oldData.tenlop;
					}else{
						var dslhtenlophoc = e.newData.tenlop;
					}	
					if(e.newData.khoi === undefined){
						var dslhkhoi = e.oldData.khoi;
					}else{
						var dslhkhoi = e.newData.khoi;
					}	
					if(e.newData.thutuhienthi === undefined){
						var dslhthutuhienthi = '1';
					}else{
						var dslhthutuhienthi = e.newData.thutuhienthi;
					}					
					axios.post('updatedanhsachlophoc', {id:id,tenlop:dslhtenlophoc,khoi:dslhkhoi,thutuhienthi:dslhthutuhienthi}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã lưu thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloaddslophoc();
					});
				},

				onRowInserting: function(e) {
					var dslhtenlophoc = e.data.tenlop;
					if(e.data.khoi === undefined){
						var dslhkhoi = dslhtenlophoc.slice(0,1);
					}else{
						var dslhkhoi = e.data.khoi;
					}
					if(e.data.thutuhienthi === undefined){
						var dslhthutuhienthi = '1';
					}else{
						var dslhthutuhienthi = e.data.thutuhienthi;
					}					
					axios.post('adddanhsachlophoc',{tenlop:dslhtenlophoc,khoi:dslhkhoi,thutuhienthi:dslhthutuhienthi}).then(function (response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã thêm mới thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloaddslophoc();
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
								xoalop(dataxoa);
							}
						});
						data.items.push({
							template: function () {
								return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
							},
							onItemClick: function() {
								var dataxoahet = datas;
								xoatoanbolop(dataxoahet);
							}
						});
					} 
				}
			});
});
}




function xoalop(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa lớp này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('deldanhsachlophoc',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloaddslophoc();
			});
		}		
	})
}

function xoatoanbolop(id) {
	var idlop = id;
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa toàn bộ lớp không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('deltoanbodanhsachlophoc',{id:idlop}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloaddslophoc();
			});
		}		
	})
}