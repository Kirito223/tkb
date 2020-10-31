function reloadtietnghilop() {
	tietnghilop();
	var dataGrid = $("#girdtietnghilop").dxDataGrid("instance");
	dataGrid.refresh();
}

function tietnghilop() {
	var data = axios.get('getrangbuoctietnghilop').then(function(response) {
		var tietnghilop = response.data[0];
		var lophoc = response.data[1];
		var datas = tietnghilop.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});

		$("#tietnghilopds").select2({
			placeholder : "Chọn lớp",
			allowHtml: true,
			allowClear: true,
			tags: true,
			width: '100%'});
		let htmllop = lophoc.map(function(item) {
			return ('<option value="' +item.id +'">' +item.tenlop +"</option>");
		});
		$("#tietnghilopds").html('<option value=""></option>' + htmllop);


		$("#girdtietnghilop").dxDataGrid({
			dataSource: datas,
			showBorders: true,
			sorting: {
				mode: "multiple"
			},
			scrolling: {
				mode: 'infinite'
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
				caption: "Tên lớp",
				dataField: "malop",	
				lookup: {
					dataSource: lophoc,
					displayExpr: "tenlop",
					valueExpr: "id",
				}
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
				caption: "Thứ",
				dataField: 'thu',
				lookup: {
					dataSource: [{
						id: 2,
						muc: "Thứ 2"
					}, {
						id: 3,
						muc: "Thứ 3"
					}, {
						id: 4,
						muc: "Thứ 4"
					}, {
						id: 5,
						muc: "Thứ 5"
					}, {
						id: 6,
						muc: "Thứ 6"
					}, {
						id: 7,
						muc: "Thứ 7"
					}],
					valueExpr: "id",
					displayExpr: "muc"
				},
			},{
				caption: "Tiết",
				dataField: 'tiet',
				lookup: {
					dataSource: [{
						id: 1,
						muc: "Tiết 1"
					}, {
						id: 2,
						muc: "Tiết 2"
					}, {
						id: 3,
						muc: "Tiết 3"
					}, {
						id: 4,
						muc: "Tiết 4"
					}, {
						id: 5,
						muc: "Tiết 5"
					}],
					valueExpr: "id",
					displayExpr: "muc"
				},
			}],

			onRowUpdating: function(e) {
				var id = e.oldData.id;
				if(e.newData.malop === undefined){
					var malop = e.oldData.malop;
				}else{
					var malop = e.newData.malop;
				}	
				if(e.newData.buoi === undefined){
					var buoi = e.oldData.buoi;
				}else{
					var buoi = e.newData.buoi;
				}	
				if(e.newData.thu === undefined){
					var thu = e.oldData.thu;
				}else{
					var thu = e.newData.thu;
				}	
				if(e.newData.tiet === undefined){
					var tiet = e.oldData.tiet;
				}else{
					var tiet = e.newData.tiet;
				}					
				axios.post('updaterangbuoctietnghilop', {id:id,malop:malop,buoi:buoi,thu:thu,tiet:tiet}).then(function(response) {
					var data = response.data;
					Swal.fire({
						title: 'Lưu',
						text: 'Đã lưu thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					reloadtietnghilop();
				});
			},

			onRowInserting: function(e) {
				if(e.data.malop === undefined){
					var malop = ""
				}else{
					var malop = e.data.malop;
				}
				if(e.data.buoi === undefined){
					var buoi = '';
				}else{
					var buoi = e.data.buoi;
				}	
				if(e.data.thu === undefined){
					var thu = '';
				}else{
					var thu = e.data.thu;
				}		
				if(e.data.tiet === undefined){
					var tiet = '';
				}else{
					var tiet = e.data.tiet;
				}				
				axios.post('addrangbuoctietnghilop',{malop:malop,buoi:buoi,thu:thu,tiet:tiet}).then(function (response) {
					var data = response.data;
					Swal.fire({
						title: 'Lưu',
						text: 'Đã thêm mới thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					reloadtietnghilop();
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
							xoatietnghilop(dataxoa);
						}
					});
					data.items.push({
						template: function () {
							return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
						},
						onItemClick: function() {
							var dataxoahet = datas;
							xoatietnghilopall(dataxoahet);
						}
					});
				} 
			}



		});
});
}

$('#capnhattietnghilop').click(function() {
	var lop = $('#tietnghilopds').val();
	var thu = $('#chonthutietnghilop').val();
	var buoi = $('#chonbuoitietnghilop').val();
	var tiet = $('#chontiettietnghilop').val();
	axios.post('addtietnghilopmulti',{lop:lop,thu:thu,buoi:buoi,tiet:tiet}).then(function (response) {
		var data = response.data;
		Swal.fire({
			position: 'center',
			icon: 'success',
			text: 'Đã thêm thành công',
			showConfirmButton: false,
			timer: 1000
		});	
		reloadtietnghilop();
	})
});


function xoatietnghilop(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa tiết nghỉ lớp này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('dellrangbuoctietnghilop',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloadtietnghilop();
			});
		}		
	})
}

function xoatietnghilopall(id) {
	var idlop = id;
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa toàn bộ tiết nghỉ lớp không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('dellrangbuoctietnghilopall',{id:idlop}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloadtietnghilop();
			});
		}		
	})
}