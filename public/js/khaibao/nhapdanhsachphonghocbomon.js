

function reloadphonghoc() {
	nhapdanhsachphonghocbomon();
	var dataGrid = $("#girdnhapdanhsachphonghocbomon").dxDataGrid("instance");
	dataGrid.refresh();
}

function nhapdanhsachphonghocbomon(){
	var data = axios.get('getdanhsachphonghocbomon').then(function (response) {
		var datas= response.data[0];
		var monhoc= response.data[1];

		var datass = [];
		datas.filter(function(items) {
			var i = datass.findIndex(x => x.tenphong == items.tenphong);
			if (i <= -1) {
				datass.push(items);
			}
			return null;
		});
		
		$("#girdnhapdanhsachphonghocbomon").dxDataGrid({
			dataSource: datass,
			showBorders: true,
			scrolling: {
				mode: 'infinite'
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
				caption: "Tên phòng học",
				dataField: "tenphong",	
			}],
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
							var dataxoa = data.row.data.tenphong;
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
			},

			masterDetail: {
				enabled: true,
				template: function(container, options) { 
					var lucky = datas;
					$("<div>").dxDataGrid({
						columnAutoWidth: true,
						showBorders: true,
						editing: {
							mode: "batch",
							allowUpdating: true,
							selectTextOnEditStart: true,
							startEditAction: "click",
							allowAdding: true,
						},
						columns: [{
							caption: "Môn học",
							dataField: "mamonhoc",
							lookup: {
								dataSource: monhoc,
								valueExpr: "id",
								displayExpr: "tenmonhoc"
							},
						}
						],
						onRowUpdating: function(e) {
							var id = e.oldData.id;	
							var tenphong = e.oldData.tenphong;			
							if(e.newData.mamonhoc === undefined){
								var mamonhoc = e.oldData.mamonhoc;
							}else{
								var mamonhoc = e.newData.mamonhoc;
							}
							axios.post('updatemonphonghoc', {id:id,tenphong:tenphong,mamonhoc:mamonhoc}).then(function(response) {
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
							var tenphong = options.key.tenphong;
							
							if(e.data.mamonhoc === undefined){
								var mamonhoc = "";
							}else{
								var mamonhoc = e.data.mamonhoc;
							}	
							
							axios.post('addmonphonghoc',{tenphong:tenphong,mamonhoc:mamonhoc}).then(function (response) {
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
										xoamonphonghoc(dataxoa);
									}
								});
							} 
						},
						dataSource: new DevExpress.data.DataSource({
							store: new DevExpress.data.ArrayStore({
								key: "id",
								data: lucky,
							}),
							filter: ["tenphong", "=", options.key.tenphong]
						})
					}).appendTo(container);
				}
			},
		});
});
}


function xoamonphonghoc(id) {
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
			axios.post('dellmonphonghoc',{id:id}).then(function (response) {
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


function xoaphong(tenphong) {
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
			axios.post('deldanhsachphonghocbomon',{tenphong:tenphong}).then(function (response) {
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