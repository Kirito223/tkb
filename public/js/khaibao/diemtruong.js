function reloaddiemtruong() {
	danhsachdiemtruong();
	var dataGrid = $("#girddiemtruong").dxDataGrid("instance");
	dataGrid.refresh();
}





function danhsachdiemtruong(){
	var data = axios.get('getdanhsachdiemtruong').then(function (response) {
		var datadiemtruong = response.data[0];
		var gvdiemtruong = response.data[1];
		var datagv = response.data[2];
		var datalop = response.data[3];
		var datamon = response.data[4];

		var datass = [];
		datadiemtruong.filter(function(items) {
			var i = datass.findIndex(x => x.tendiemtruong == items.tendiemtruong);
			if (i <= -1) {
				datass.push(items);
			}
			return null;
		});

		$("#girddiemtruong").dxDataGrid({
			dataSource: datass,
			allowColumnReordering: true,
			showBorders: true,
			searchPanel: {
				visible: true
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
				caption: "Điểm trường",
				dataField: "tendiemtruong",
			}],

			onRowUpdating: function(e) {
				var id = e.oldData.id;
				if(e.newData.tendiemtruong === undefined){
					var tendiemtruong = e.oldData.tendiemtruong;
				}else{
					var tendiemtruong = e.newData.tendiemtruong;
				}						
				axios.post('updatediemtruong', {id:id,tendiemtruong:tendiemtruong}).then(function(response) {
					var data = response.data;
					Swal.fire({
						title: 'Lưu',
						text: 'Đã lưu thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					reloaddiemtruong();
				});
			},
			onRowInserting: function(e) {
				var tendiemtruong = e.data.tendiemtruong;				
				axios.post('adddiemtruong',{tendiemtruong:tendiemtruong}).then(function (response) {
					var data = response.data;
					Swal.fire({
						title: 'Lưu',
						text: 'Đã thêm mới thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					reloaddiemtruong();
				});
			},
			onContextMenuPreparing: function(data) { 
				if (data.target == "content") {
					if (!data.items) data.items = [];
					data.items.push({
						template: function () {
							return $("<i class='fa fa-remove'>").text(" Xóa điểm trường");                  
						},
						onItemClick: function() {
							var dataxoa = data.row.data.tendiemtruong;
							xoadiemtruong(dataxoa);
						}
					});
				} 
			},


			masterDetail: {
				enabled: true,
				template: function(container, options) { 
					var lucky = datadiemtruong;
					var tendiemtruongs = options.data.tendiemtruong;
					$("<div>").dxDataGrid({
						columnAutoWidth: true,
						showBorders: true,
						editing: {
							mode: "batch",
							allowUpdating: true,
							selectTextOnEditStart: true,
							startEditAction: "click",
							// allowAdding: true,
						},
						columns: [{
							caption: "Tên lớp",
							dataField: "malop",
							lookup: {
								dataSource: datalop,
								valueExpr: "id",
								displayExpr: "tenlop"
							},
						}
						],

						onToolbarPreparing: function(e) {
							var dataGrid = e.component;
							var itemlop;
							e.toolbarOptions.items.unshift({
								location: "before",
								template: function(){
									return $("<div>").dxTagBox({
										items: datalop,
										placeholder: "Chọn lớp",
										showSelectionControls: true,
										displayExpr: "tenlop",
										valueExpr: "id",
										width: 600,
										applyValueMode: "useButtons",
										onValueChanged: function(data) {
											var itlop = data.value;
											itemlop = itlop;
										}
									}).appendTo(container);
								},
							},{
								location: "after",
								widget: "dxButton",
								options: {
									text: "Cập nhật",
									icon: "refresh",
									onClick: function() {
										axios.post('addgvdiemtruong',{tendiemtruong:tendiemtruongs,malop:itemlop}).then(function (response) {
											var data = response.data;
											Swal.fire({
												title: 'Lưu',
												text: 'Đã thêm mới thành công',
												icon: 'success',
												confirmButtonText: 'OK'
											});
											reloaddiemtruong();
										});
									}
								}
							});
						},
						onRowUpdating: function(e) {
							var id = e.oldData.id;	
							var tendiemtruong = e.oldData.tendiemtruong;			
							if(e.newData.malop === undefined){
								var malop = e.oldData.malop;
							}else{
								var malop = e.newData.malop;
							}
							axios.post('updategvdiemtruong', {id:id,tendiemtruong:tendiemtruong,malop:malop}).then(function(response) {
								var data = response.data;
								Swal.fire({
									title: 'Lưu',
									text: 'Đã lưu thành công',
									icon: 'success',
									confirmButtonText: 'OK'
								});
								reloaddiemtruong();
							});
						},
						onRowInserting: function(e) {
							var tendiemtruong = options.key.tendiemtruong;
							
							if(e.data.malop === undefined){
								var malop = "";
							}else{
								var malop = e.data.malop;
							}	
							
							axios.post('addgvdiemtruong',{tendiemtruong:tendiemtruong,malop:malop}).then(function (response) {
								var data = response.data;
								Swal.fire({
									title: 'Lưu',
									text: 'Đã thêm mới thành công',
									icon: 'success',
									confirmButtonText: 'OK'
								});
								reloaddiemtruong();
							});
						},
						onContextMenuPreparing: function(data) { 
							if (data.target == "content") {
								if (!data.items) data.items = [];
								data.items.push({
									template: function () {
										return $("<i class='fa fa-remove'>").text(" Xóa lớp");                  
									},
									onItemClick: function() {
										var dataxoa = data.row.data.id;
										xoagvdiemtruong(dataxoa);
									}
								});
							} 
						},
						dataSource: new DevExpress.data.DataSource({
							store: new DevExpress.data.ArrayStore({
								key: "id",
								data: lucky,
							}),
							filter: ["tendiemtruong", "=", options.key.tendiemtruong]
						})
					}).appendTo(container);
				}
			}
		});
});
}



function xoadiemtruong(tendiemtruong) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa điểm trường này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('deldiemtruong',{tendiemtruong:tendiemtruong}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloaddiemtruong();
			});
		}		
	})
}

function xoagvdiemtruong(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa giáo viên điểm trường này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('delgvdiemtruong',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloaddiemtruong();
			});
		}		
	})
}