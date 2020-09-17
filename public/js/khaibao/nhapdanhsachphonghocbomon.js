

function reloadphonghoc() {
	nhapdanhsachphonghocbomon();
	var dataGrid = $("#girdnhapdanhsachphonghocbomon").dxDataGrid("instance");
	dataGrid.refresh();
}

function nhapdanhsachphonghocbomon(){
	var data = axios.get('getdanhsachphonghocbomon').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		$("#girdnhapdanhsachphonghocbomon").dxDataGrid({
			dataSource: datas,
			showBorders: true,
			paging: {
				pageSize: 30
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
				allowedPageSizes: [10,30,50],
				showInfo: true
			},
			editing: {
				mode: "batch",
				allowUpdating: true,
				selectTextOnEditStart: true,
				startEditAction: "click",

				allowAdding: true,
			},
				/* headerFilter: {
					visible: true
				}, */
				/*chon row*/
				selection: {
					mode: "single"
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
					caption: "Tên phòng học",
					dataField: "tenphong",	
				}],
				// select data row
				onSelectionChanged: function (selectedItems) {
				},
				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if (e.newData.tenphong === undefined) {
						var phonghocten = e.oldData.tenphong;
					} else {
						var phonghocten = e.newData.tenphong;
					}

					axios.post('updatedanhsachphonghocbomon', {
						id: id,tenphonghoc:phonghocten
					}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã lưu thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloadphonghoc();
					});
				},

				onRowInserting: function(e) {
					if (e.data.tenphong === undefined) {
						var phonghocten = "";
					} else {
						var phonghocten = e.data.tenphong;
					}
					axios.post('adddanhsachphonghocbomon', {
						tenphonghoc: phonghocten,
					}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã thêm mới thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloadphonghoc();
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
								xoaphong(dataxoa);
							}
						});
						data.items.push({
							template: function () {
								return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
							},
							onItemClick: function() {
								var dataxoahet = datas;
								xoatoanphong(dataxoahet);
							}
						});
					} 
				}


			});
	});
}





function xoaphong(id) {
	Swal.fire({
		title: 'Xoá?',
		text: "Bạn có muốn xoá phòng này không!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'OK'
	}).then((result) => {
		if (result.value) {
			axios.post('deldanhsachphonghocbomon',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire(
					'Xoá!',
					'Xoá thành công.',
					'success'
					)			
				reloadphonghoc();
			});			    
		}
	})		
}



function xoatoanphong(id) {
	Swal.fire({
		title: 'Xoá?',
		text: "Bạn có muốn xoá toàn bộ phòng không!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'OK'
	}).then((result) => {
		if (result.value) {
			axios.post('deltoanbodanhsachphonghocbomon',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire(
					'Xoá!',
					'Xoá thành công.',
					'success'
					)			
				reloadphonghoc();
			});			    
		}
	})		
}