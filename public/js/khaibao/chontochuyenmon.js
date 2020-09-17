
function reload_tochuyenmon() {
	chon_tochuyenmon();
	var dataGrid = $("#girddanhsach_tochuyenmon").dxDataGrid("instance");
	dataGrid.refresh();
}

function chon_tochuyenmon(){
	var data = axios.get('getdanhsachtochuyenmon').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		$("#girddanhsach_tochuyenmon").dxDataGrid({
			dataSource: datas,
			keyExpr: "id",
			showBorders: true,
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
				caption: "Tên tổ chuyên môn",
				dataField: "tentocm",
				allowEditing: false,	
			},
			],
				// select data row
				onSelectionChanged: function (selectedItems) {
					cap();
				},
			});

		function cap(){	
			var dataGrid = $("#girddanhsach_tochuyenmon").dxDataGrid("instance");	
			dataGrid.getSelectedRowsData().then(function (rowData) {
				capnhat.option("disabled", !rowData);
				datacapnhat = rowData;
				dataidtong = dataGrid._options.dataSource;
			});
		}
		var datacapnhat;
		var dataidtong;
		var capnhat = $("#capnhatthtocm").dxButton({
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

				axios.post('updatechonthtocm', {
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
					var dataGrid = $("#girddanhsach_tochuyenmon").dxDataGrid("instance");
					dataGrid.refresh();
				});

			}
		}).dxButton("instance");


	});
}



