function danhsachgv(){
	var data = axios.get('getdanhsachgv').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		if(datas == ""){
			Swal.fire({
				title: 'Có lỗi!',
				text: 'Đã có lối xảy ra! Vui lòng kiểm tra và thử lại',
				icon: 'error',
				confirmButtonText: 'OK'
			})
		}
		$("#girddsgv").dxDataGrid({
			dataSource: datas,
			showBorders: true,
				// remoteOperations: true,
				scrolling: {
					mode: "virtual",
					rowRenderingMode: "virtual"
				},
				// paging: {
				// 	pageSize: 10
				// },
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
				// pager: {
				// 	showPageSizeSelector: true,
				// 	allowedPageSizes: [5, 10, 20],
				// 	showInfo: true
				// },
				/* headerFilter: {
					visible: true
				}, */
				/*chon row*/
				selection: {
					mode: "multiple",
					recursive: true
				},
				/* co dan cot */
				allowColumnResizing: true,
				columnResizingMode: "widget",
				columns: [{
					caption: "Tên",
					dataField: "ten",
				}],
				// select data row
				onSelectionChanged: function (selectedItems) {

				},
			});
	});
}



function danhsachlophoc(){
	var data = axios.get('getdanhsachlophoc').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		if(datas == ""){
			Swal.fire({
				title: 'Có lỗi!',
				text: 'Đã có lối xảy ra! Vui lòng kiểm tra và thử lại',
				icon: 'error',
				confirmButtonText: 'OK'
			})
		}
		$("#girddslophoc").dxDataGrid({
			dataSource: datas,
			showBorders: true,
				// remoteOperations: true,
				scrolling: {
					mode: "virtual",
					rowRenderingMode: "virtual"
				},
				// paging: {
				// 	pageSize: 10
				// },
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
				/*chon row*/
				selection: {
					mode: "multiple",
					recursive: true
				},
				/* co dan cot */
				allowColumnResizing: true,
				columnResizingMode: "widget",
				columns: [{
					caption: "Tên lớp",
					dataField: "tenlop",
				}],
				// select data row
				onSelectionChanged: function (selectedItems) {

				},
			});
	});
}



function danhsachphonghoc(){
	var data = axios.get('getdanhsachphonghoc').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});	
		if(datas == ""){
			Swal.fire({
				title: 'Có lỗi!',
				text: 'Đã có lối xảy ra! Vui lòng kiểm tra và thử lại',
				icon: 'error',
				confirmButtonText: 'OK'
			})
		}
		$("#girddsphonghoc").dxDataGrid({
			dataSource: datas,
			showBorders: true,
				// remoteOperations: true,
				scrolling: {
					mode: "virtual",
					rowRenderingMode: "virtual"
				},
				// paging: {
				// 	pageSize: 10
				// },
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
				/*chon row*/
				selection: {
					mode: "multiple",
					recursive: true
				},
				/* co dan cot */
				allowColumnResizing: true,
				columnResizingMode: "widget",
				columns: [{
					caption: "Tên phòng học",
					dataField: "tenphong",
				}],
				// select data row
				onSelectionChanged: function (selectedItems) {

				},
			});
	});
}