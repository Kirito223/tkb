function thututietlockhoi(){
	var data11 = axios.get('getkhoihoc').then(function(response) {
		var datakhoihoc = response.data;
		$("#thututietkhoi").dxSelectBox({
			dataSource: datakhoihoc,
			displayExpr: "tenkhoi",
			valueExpr: "tenkhoi",
			onValueChanged: function(data) {
				var idkhoi = data.value;
				thututiet(idkhoi);
			}
		});
		thututiet();
	});
}

function reloadthututiet() {
	thututietlockhoi();
	var dataGrid = $("#girdthututiet").dxDataGrid("instance");
	dataGrid.refresh();
}


function thututiet(idkhoi) {
	var data = axios.get('getrangbuocthututiet').then(function(response) {
		var khoi = response.data[0];
		var thututiet = response.data[1];
		var monhoc = response.data[2];

		if(idkhoi == undefined){
			var data1 = thututiet;
			var datas = data1.map(function (value, label) {
				let data = value;
				let stt = label + 1;
				var datas = Object.assign(data, {stt: stt.toString()});
				return datas;
			});
		}else{
			var data1 = thututiet.filter(function(items){
				if(items.makhoi == idkhoi){
					return items;
				}
			})
			var datas = data1.map(function (value, label) {
				let data = value;
				let stt = label + 1;
				var datas = Object.assign(data, {stt: stt.toString()});
				return datas;
			});
		}

		$("#girdthututiet").dxDataGrid({
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
						var thutuhienthi = (item.thutu);
						axios.post('updatethututietthutuhienthi',{id:item.id,thutu:thutuhienthi}).then(function (response) {
							var data = response.data;
							datas.splice(fromIndex, 1);
							datas.splice(toIndex, 0, e.itemData);
							e.component.refresh();		
							reloadthututiet();
						});
					}else{
						var item = e.itemData;
						var thutuhienthi = (item.thutu)+toIndex;
						axios.post('updatethututietthutuhienthi',{id:item.id,thutu:thutuhienthi}).then(function (response) {
							var data = response.data;
							datas.splice(fromIndex, 1);
							datas.splice(toIndex, 0, e.itemData);
							e.component.refresh();		
							reloadthututiet();
						});
					}
				}
			},
			paging: {
				pageSize: 10
			},
			height:800,
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
			selection: {
				mode: "single"
			},
			editing: {
				mode: "batch",
				allowUpdating: true,
				selectTextOnEditStart: true,
				startEditAction: "click",
				allowAdding: true,
			},
			allowColumnResizing: true,
			columnResizingMode: "widget",
			columns: [{
				caption: "STT",
				dataField: "stt",
				width: 50,
				allowEditing: false,
			}, {
				caption: "Tên môn học",
				dataField: "mamonhoc",	
				lookup: {
					dataSource: monhoc,
					valueExpr: "id",
					displayExpr: "tenmonhoc"
				},
			},{
				caption: "Khối học",
				dataField: "makhoi",
				lookup: {
					dataSource: khoi,
					valueExpr: "tenkhoi",
					displayExpr: "tenkhoi"
				},
				// allowEditing: false,
			},{
				caption: "Thứ tự hiển thị",
				dataField: "thutu",
			}, 
			],
			onRowUpdating: function(e) {
				var id = e.oldData.id;
				if(e.newData.mamonhoc === undefined){
					var mamonhoc = e.oldData.mamonhoc;
				}else{
					var mamonhoc = e.newData.mamonhoc;
				}	
				if(e.newData.makhoi === undefined){
					var makhoi = e.oldData.makhoi;
				}else{
					var makhoi = e.newData.makhoi;
				}	
				if(e.newData.thutu === undefined){
					var thutu = '1';
				}else{
					var thutu = e.newData.thutu;
				}					
				axios.post('updaterangbuocthututiet', {id:id,mamonhoc:mamonhoc,makhoi:makhoi,thutu:thutu}).then(function(response) {
					var data = response.data;
					Swal.fire({
						title: 'Lưu',
						text: 'Đã lưu thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					reloadthututiet();
				});
			},

			onRowInserting: function(e) {
				if(e.data.mamonhoc === undefined){
					var mamonhoc = ""
				}else{
					var mamonhoc = e.data.mamonhoc;
				}
				if(e.data.makhoi === undefined){
					var makhoi = '';
				}else{
					var makhoi = e.data.makhoi;
				}	
				if(e.data.thutu === undefined){
					var thutu = '1';
				}else{
					var thutu = e.data.thutu;
				}					
				axios.post('addrangbuocthututiet',{mamonhoc:mamonhoc,makhoi:makhoi,thutu:thutu}).then(function (response) {
					var data = response.data;
					Swal.fire({
						title: 'Lưu',
						text: 'Đã thêm mới thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					reloadthututiet();
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
							xoathututiet(dataxoa);
						}
					});
					data.items.push({
						template: function () {
							return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
						},
						onItemClick: function() {
							var dataxoahet = datas;
							xoathututietall(dataxoahet);
						}
					});
				} 
			}


		})





});
}



function xoathututiet(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa thứ tự môn này này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('dellrangbuocthututiet',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloadthututiet();
			});
		}		
	})
}

function xoathututietall(id) {
	var idlop = id;
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa toàn bộ thứ tự môn không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('dellrangbuocthututietall',{id:idlop}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloadthututiet();
			});
		}		
	})
}