
function reload_lophoc() {
	chon_lophoc();
	var dataGrid = $("#girddanhsach_lophoc").dxDataGrid("instance");
	dataGrid.refresh();
}

function chon_lophoc(){
	var data = axios.get('getdanhsachlophoc').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		$("#girddanhsach_lophoc").dxDataGrid({
			dataSource: datas,
			showBorders: true,
			keyExpr: "id",
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
				allowedPageSizes: [10,20,30],
				showInfo: true
			},
			/*chon row*/
			selection: {
				mode: "multiple",
				deferred: true,
			},
			selectionFilter: ["trangthai", "=", "1"],
			editing: {
				mode: "cell",
				allowUpdating: true,
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
				allowEditing: false,	
			},
			{
				caption: "Khối",
				dataField: "khoi",	
				allowEditing: false,
			},
			{
				caption: "Thứ tự hiển thị trên TKB",
				dataField: "thutuhienthi",
				width: 100,	
			}],
				// select data row
				onSelectionChanged: function (selectedItems) {
					cap();
				},

				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if (e.newData.thutuhienthi === undefined) {
						var thutuhienthi = e.oldData.thutuhienthi;
					} else {
						var thutuhienthi = e.newData.thutuhienthi;
					}

					axios.post('updatethutuhienthi', {
						id:id,
						thutuhienthi: thutuhienthi,
					}).then(function(response) {
						var data = response.data;
						// Swal.fire({
						// 	title: 'Lưu',
						// 	text: 'Đã lưu thành công',
						// 	icon: 'success',
						// 	confirmButtonText: 'OK'
						// });
						reload_lophoc();
					});
				},
			});
		function cap(){	
			var dataGrid = $("#girddanhsach_lophoc").dxDataGrid("instance");	
			dataGrid.getSelectedRowsData().then(function (rowData) {
				capnhat.option("disabled", !rowData);
				datacapnhat = rowData;
				dataidtong = dataGrid._options.dataSource;
			});
		}
	});

	var datacapnhat;
	var dataidtong;
	var capnhat = $("#capnhatthlophoc").dxButton({
		text: "Cập nhật trạng thái",
		height: 25,
		disabled: false,
		onClick: function () {
			var data1 = [];
			datacapnhat.filter(function(itemss) {
				var id = itemss.id;					
				data1.push(id);
			});

			var data2 = [];
			dataidtong.filter(function(itemss) {
				var id = itemss.id;					
				data2.push(id);
			});

			var data3 = data2.filter(function(item) {
				return !data1.includes(item) ? true : false;
			});

			axios.post('updatechonthlophoc', {
				idth0:data3,
				idth1:data1,
			}).then(function(response) {
				var data = response.data;
				Swal.fire({
					title: 'Lưu',
					text: 'Đã lưu thành công',
					icon: 'success',
					confirmButtonText: 'OK'
				});
				var dataGrid = $("#girddanhsach_lophoc").dxDataGrid("instance");
				dataGrid.refresh();
			});

		}
	}).dxButton("instance");


}


