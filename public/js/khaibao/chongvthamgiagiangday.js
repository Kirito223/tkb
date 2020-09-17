
function reloadgvthamgiagiangday() {
	var dataGrid = $("#girddanhsachgvthamgiagiangday").dxDataGrid("instance");
	dataGrid.refresh();
}


function loaddatadanhsachgvthamgiagiangday() {
	var data = axios.get('getdanhsachgvthamgiagiangday').then(function (response) {
		var data1 = response.data;
		var data3 = [];
		var lucky2 = data1.filter(function(items1){
			var magiaovien = items1.id;
			var data4 = [];
			data3.push({ id:items1.id,hovaten:items1.hovaten,trangthai:items1.trangthai,bidanh:items1.bidanh,thutuhienthi:items1.thutuhienthi,monhoc:data4});
			var datamh = items1.monhoc;
			var lucky3 = datamh.filter(function(items2){
				if(magiaovien == items2.magiaovien){
					var malop = items2.malop;
					var sotiet = items2.sotiet;
					var mamonhoc = items2.mamonhoc;
					var datalop = items2.danhsachlophoc;
					var data5 = [];
					data4.push({id:items2.id,malop:items2.malop,magiaovien:items2.magiaovien,tenmonhoc:items2.tenmonhoc,lop:data5});
					if(malop == datalop.id){
						data5.push({id:datalop.id,mamonhoc:mamonhoc,tenlop:datalop.tenlop,sotiet:sotiet});
					}
				}
			});
		});
		// console.log(data3);
		var datas = data3.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});
		chongvthamgiagiangday(datas);
	});
}

function chongvthamgiagiangday(datas){
	$("#girddanhsachgvthamgiagiangday").dxDataGrid({
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
			placeholder: "Tìm kiếm...",
		},
		pager: {
			showPageSizeSelector: true,
			allowedPageSizes: [10,30,50],
			showInfo: true
		},
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
		onInitialized: function (e) {
			dataGrid = e.component;
			// capnhattrangthai();
		},
		columns: [	
		{
			caption: "STT",
			dataField: "stt",
			width: 50,
			allowEditing: false,
		},
		{
			caption: "Họ và tên",
			dataField: "hovaten",
			width: 150,
			allowEditing: false,
		},
		{
			caption: "Bí danh(Tên hiển thị trên TKB)",
			dataField: "bidanh",
			width: 100,
			allowEditing: false,
		},
		{
			caption: "Thứ tự",
			dataField: "thutuhienthi",
			width: 80,
		},
		{
			caption: "Hiển thị phân công CM",
			dataField: 'monhoc',
			allowEditing: false,
			cellTemplate: function(element, info) {
				var item = info.value;
				var groups = {};
				for (var i = 0; i < item.length; i++) {
					// console.log(tenmonhoc);
					var tenmonhoc = item[i].tenmonhoc;
					if (!groups[tenmonhoc]) {
						groups[tenmonhoc] = [];
					}
					groups[tenmonhoc].push(item[i].lop);
				}
				var data_new = [];
				for (var tenmonhoc in groups ) {
					// console.log(idmonhoc);
					data_new.push({tenmonhoc: tenmonhoc ,lop: groups[tenmonhoc]});

				};
				// console.log(data_new);
				var temp = data_new.map(function(value) {
					var item1 = value.lop;
					// console.log(item1);
					var temp1 = item1.map(function(value1){
						// console.log(value1[0].sotiet);
						return value1[0].tenlop+": "+value1[0].sotiet;
					}).join(", ");
					// console.log(temp1);
					return value.tenmonhoc+" ("+temp1+")";					
				}).join(", ");
				// console.log(temp);
				$("<div>")
				.attr("id","noidungpccmid")
				// .attr("hidden","hidden")
				.appendTo(element)
				.text(temp)
				.css("white-space", "normal")
				.css("overflow-wrap", 'break-word');
			}
		}
		],
			// select data row
			onSelectionChanged: function (data) {	
				capss();
			},

			onRowUpdating: function(e) {
				var id = e.oldData.id;
				if (e.newData.thutuhienthi === undefined) {
					var thutuhienthi = e.oldData.thutuhienthi;
				} else {
					var thutuhienthi = e.newData.thutuhienthi;
				}

				axios.post('updatethutuhienthigvthamgiagiangday', {
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
					reloadgvthamgiagiangday();
				});
			},
		});

	function capss(dataGrid){	
		var dataGrid = $("#girddanhsachgvthamgiagiangday").dxDataGrid("instance");	
		dataGrid.getSelectedRowsData().then(function (rowData) {
			capnhat.option("disabled", !rowData);
			datacapnhat = rowData;
			dataidtong = dataGrid._options.dataSource;
		});
	}
	var datacapnhat;
	var dataidtong;
	var capnhat = $("#capnhat").dxButton({
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

			axios.post('updatetrangthaigvthamgiagiangday', {
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
				var dataGrid = $("#girddanhsachgvthamgiagiangday").dxDataGrid("instance");
				dataGrid.refresh();
			});

		}
	}).dxButton("instance");

}

