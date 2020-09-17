
function reload_monhoc() {
	chon_monhoc();
	var dataGrid = $("#girddanhsach_monhoc").dxDataGrid("instance");
	dataGrid.refresh();
}


function chon_monhoc(){

	var data = axios.get('getdanhsachmonhoc').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	

		$("#girddanhsach_monhoc").dxDataGrid({
			dataSource: datas,
			keyExpr: "id",
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
				allowedPageSizes: [10, 30,50],
				showInfo: true
			},
			/*chon row*/
			selection: {
				mode: "multiple",
				deferred: true,
			},
			/* co dan cot */
			allowColumnResizing: true,
			columnResizingMode: "widget",
			selectionFilter: ["trangthai", "=", "1"],
			columns: [{
				caption: "STT",
				dataField: "stt",
				width: 50,
			}, {
				caption: "Tên môn học",
				dataField: "tenmonhoc",	
			},
			{
				caption: "Tên môn học viết tắt (hiển thị trên TKB)",
				dataField: "monhocviettat",	
			}
			],
			onInitialized: function (e) {
				dataGrid = e.component;
				capnhattrangthai();
			},
			//select data row
			onSelectionChanged: function(data) {
				// document.getElementById("capnhat_monhoc").disabled = false;
			},
		});

		function capnhattrangthai(data){	
			document.getElementById("capnhat_monhoc").disabled = false;
			$("#capnhat_monhoc").click(function(){
				var dataGrid = $("#girddanhsach_monhoc").dxDataGrid("instance");			
				dataGrid.getSelectedRowsData().then(function (rowData) {
					var data1 = [];
					datas.filter(function(itemss) {
						var id = itemss.id;					
						data1.push(id);
					});

					var data2 = [];
					rowData.filter(function(itemss) {
						var id = itemss.id;					
						data2.push(id);
					});

					var data3 = data1.filter(function(item) {
						return !data2.includes(item) ? true : false;
					});

					axios.post('updatechonbuoihoc',{idth0:data3,idth1:data2}).then(function (response) {
						var data = response.data;
						reload_monhoc();
					});	
					Swal.fire({
						title: 'Lưu',
						text: 'Đã cập nhật thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
				});
			});
		}

		
	});

}



