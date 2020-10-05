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

		$("#girddiemtruong").dxDataGrid({
			dataSource: datadiemtruong,
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
							return $("<i class='fa fa-remove'>").text(" Xóa");                  
						},
						onItemClick: function() {
							var dataxoa = data.row.data.id;
							xoadiemtruong(dataxoa);
						}
					});
				} 
			},


			masterDetail: {
				enabled: true,
				template: function(container, options) { 
					var lucky = gvdiemtruong;
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
							caption: "Tên giáo viên",
							dataField: "magiaovien",
							lookup: {
								dataSource: datagv,
								valueExpr: "id",
								displayExpr: "hovaten"
							},
						},{
							caption: "Lớp",
							dataField: "malop",
							lookup: {
								dataSource: datalop,
								valueExpr: "id",
								displayExpr: "tenlop"
							},
						},{
							caption: "Môn",
							dataField: "mamonhoc",
							lookup: {
								dataSource: datamon,
								valueExpr: "id",
								displayExpr: "tenmonhoc"
							},
						},{
							caption: "Buổi",
							dataField: 'buoi',
							lookup: {
								dataSource: [{
									id: 0,
									muc: "Sáng"
								}, {
									id: 1,
									muc: "Chiều"
								}],
								valueExpr: "id",
								displayExpr: "muc"
							},
						},{
							caption: "Số tiết thực tế",
							dataField: "sotietthucte",
							dataType: 'number',
						},{
							caption: "Số tiết phân công",
							dataField: "sotietphancong",
							dataType: 'number',
						},
						],
						onRowUpdating: function(e) {
							var id = e.oldData.id;
							var madiemtruong = options.key.id;
							if(e.newData.magiaovien === undefined){
								var magiaovien = e.oldData.magiaovien;
							}else{
								var magiaovien = e.newData.magiaovien;
							}						
							if(e.newData.malop === undefined){
								var malop = e.oldData.malop;
							}else{
								var malop = e.newData.malop;
							}
							if(e.newData.mamonhoc === undefined){
								var mamonhoc = e.oldData.mamonhoc;
							}else{
								var mamonhoc = e.newData.mamonhoc;
							}
							if(e.newData.buoi === undefined){
								var buoi = e.oldData.buoi;
							}else{
								var buoi = e.newData.buoi;
							}
							if(e.newData.sotietthucte === undefined){
								var sotietthucte = e.oldData.sotietthucte;
							}else{
								var sotietthucte = e.newData.sotietthucte;
							}
							if(e.newData.sotietphancong === undefined){
								var sotietphancong = e.oldData.sotietphancong;
							}else{
								var sotietphancong = e.newData.sotietphancong;
							}
							axios.post('updategvdiemtruong', {id:id,madiemtruong:madiemtruong,magiaovien:magiaovien,malop:malop,mamonhoc:mamonhoc,buoi:buoi,sotietthucte:sotietthucte,sotietphancong:sotietphancong}).then(function(response) {
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
							var madiemtruong = options.key.id;
							if(e.data.magiaovien === undefined){
								var magiaovien = "";
							}else{
								var magiaovien = e.data.magiaovien;
							}
							if(e.data.malop === undefined){
								var malop = "";
							}else{
								var malop = e.data.malop;
							}	
							if(e.data.mamonhoc === undefined){
								var mamonhoc = "";
							}else{
								var mamonhoc = e.data.mamonhoc;
							}	
							if(e.data.buoi === undefined){
								var buoi = "";
							}else{
								var buoi = e.data.buoi;
							}	
							if(e.data.sotietthucte === undefined){
								var sotietthucte = "";
							}else{
								var sotietthucte = e.data.sotietthucte;
							}	
							if(e.data.sotietphancong === undefined){
								var sotietphancong = "";
							}else{
								var sotietphancong = e.data.sotietphancong;
							}						
							axios.post('addgvdiemtruong',{madiemtruong:madiemtruong,magiaovien:magiaovien,malop:malop,mamonhoc:mamonhoc,buoi:buoi,sotietthucte:sotietthucte,sotietphancong:sotietphancong}).then(function (response) {
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
										return $("<i class='fa fa-remove'>").text(" Xóa");                  
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
							filter: ["madiemtruong", "=", options.key.id]
						})
					}).appendTo(container);
}
}
});
});
}



function xoadiemtruong(id) {
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
			axios.post('deldiemtruong',{id:id}).then(function (response) {
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