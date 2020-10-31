function loadlop() {
	axios.get("getdanhsachlophoc").then(function(response) {
		let data = response.data;
		if (data != null) {
			let htmllophoc = data.map(function(item) {
				return ('<option value="' +item.id +'">' +item.tenlop +"</option>");
			});
			$("#lop").html('<option value=""></option>' + htmllophoc);
		}
	});
}

function captietbuocphaixepliennhau() {
	disableitem();
	$('#phamviapdung').change(function (){
		var a = $('#phamviapdung').val();
		if(a == 2){
			document.getElementById("lop").hidden = false;
			loadlop();
		}else{
			document.getElementById("lop").hidden = true;
		}
	});

	$('#addcaptiet').click(function (){
		embeditem();
		clearitem();
		$('#girdrangbuoccaptietxepliennhau').dxDataGrid("instance").option("disabled", true);
		document.getElementById("huycaptiet").hidden = false;
		document.getElementById("addcaptiet").disabled = true;
	});

	$('#huycaptiet').click(function (){
		disableitem();
		clearitem();
		document.getElementById("addcaptiet").disabled = false;
		document.getElementById("huycaptiet").hidden = true;
		$('#girdrangbuoccaptietxepliennhau').dxDataGrid("instance").option("disabled", false);
	})


	var data = axios.get('getlistrangbuoccaptietxepliennhau').then(function(response) {
		var data1 = response.data;
		datachangemon = data1;
		var datas = data1.map(function(value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {
				stt: stt.toString()
			});
			return datas;
		});
		$("#girdrangbuoccaptietxepliennhau").dxDataGrid({
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
			selection: {
				mode: "single"
			},
			pager: {
				showPageSizeSelector: true,
				allowedPageSizes: [10, 30,50],
				showInfo: true
			},
			/* co dan cot */
			allowColumnResizing: true,
			columnResizingMode: "widget",
			columns: [{
				caption: "STT",
				dataField: "stt",
				width: 50,
			},
			{
				caption: "Môn",
				dataField: "monhoc.tenmonhoc",
				width: 100,
			},{
				caption: "Phạm vi áp dụng",
				cellTemplate: function (container, options) {
					var idmon = options.data.phamvi;
					if(idmon == 0){
						$("<div>").html('Toàn trường').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('Toàn khối').appendTo(container);
					}else if(idmon == 2){
						$("<div>").html('Chỉ áp dụng lớp đã chọn').appendTo(container);
					}
				},
			},{
				caption: "Lớp",
				cellTemplate: function (container, options) {
					var idmon = options.data.phamvi;
					if(idmon == 0){
						$("<div>").html('').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('').appendTo(container);
					}else if(idmon == 2){
						if(options.data.lophoc != null){
							$("<div>").html(options.data.lophoc.tenlop).appendTo(container);
						}else{
							$("<div>").html("").appendTo(container);
						}
					}
				},
			},{
				caption: "Khối",
				cellTemplate: function (container, options) {
					var idmon = options.data.phamvi;
					if(idmon == 0){
						$("<div>").html('').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('').appendTo(container);
					}else if(idmon == 2){
						if(options.data.lophoc != null){
							$("<div>").html(options.data.lophoc.khoi).appendTo(container);
						}else{
							$("<div>").html("").appendTo(container);
						}						
					}
				},
			},{
				caption: "Vị trí của cặp tiết trong môn học",
				cellTemplate: function (container, options) {
					var idmon = options.data.vitricaptiet;
					if(idmon == 0){
						$("<div>").html('Cặp tiết bất kì').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('Tiết 1,2').appendTo(container);
					}else if(idmon == 2){
						$("<div>").html('Tiết 2,3').appendTo(container);
					}else if(idmon == 3){
						$("<div>").html('Tiết 3,4').appendTo(container);
					}else if(idmon == 4){
						$("<div>").html('Tiết 4,5').appendTo(container);
					}
				},
			},{
				caption: "Mức ràng buộc",
				cellTemplate: function (container, options) {
					var idmon = options.data.mucrangbuoc;
					if(idmon == 0){
						$("<div>").html('Mức 0').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('Mức 1').appendTo(container);
					}else if(idmon == 2){
						$("<div>").html('Mức 2').appendTo(container);
					}else if(idmon == 3){
						$("<div>").html('Mức 3').appendTo(container);
					}
				},
			},{
				caption: "Tránh cặp tiết trong buổi sáng",
				cellTemplate: function (container, options) {
					var idmon = options.data.tranhcaptietsang;
					if(idmon == 0){
						$("<div>").html('Không tránh cặp tiết nào').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('Tiết 1,2').appendTo(container);
					}else if(idmon == 2){
						$("<div>").html('Tiết 2,3').appendTo(container);
					}else if(idmon == 3){
						$("<div>").html('Tiết 3,4').appendTo(container);
					}else if(idmon == 4){
						$("<div>").html('Tiết 4,5').appendTo(container);
					}
				},
			},{
				caption: "Tránh cặp tiết trong buổi chiều",
				cellTemplate: function (container, options) {
					var idmon = options.data.tranhcaptietchieu;
					if(idmon == 0){
						$("<div>").html('Không tránh cặp tiết nào').appendTo(container);
					}else if(idmon == 1){
						$("<div>").html('Tiết 1,2').appendTo(container);
					}else if(idmon == 2){
						$("<div>").html('Tiết 2,3').appendTo(container);
					}else if(idmon == 3){
						$("<div>").html('Tiết 3,4').appendTo(container);
					}else if(idmon == 4){
						$("<div>").html('Tiết 4,5').appendTo(container);
					}
				},
			}
			],
						onContextMenuPreparing: function(data) { 
				if (data.target == "content") {
					if (!data.items) data.items = [];
					data.items.push({
						template: function () {
							return $("<i class='fa fa-remove'>").text(" Xóa");                  
						},
						onItemClick: function() {
							var dataxoa = data.row.data.id;
							xoadscaptietxepliennhau(dataxoa);
						}
					});
					data.items.push({
						template: function () {
							return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
						},
						onItemClick: function() {
							var dataxoahet = datas;
							xoatoanbodscaptietxepliennhau(dataxoahet);
						}
					});
				} 
			},
			
			onSelectionChanged: function (selectedItems) {
				var item = selectedItems.selectedRowsData[0];
				changeitem(item);
				embeditem();
			}
		});
	});	



function xoadscaptietxepliennhau(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa cặp tiết xếp liền nhau này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('dellrangbuoccaptietxepliennhau',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});   
				captietbuocphaixepliennhau();
				var dataGrid = $("#girdrangbuoccaptietxepliennhau").dxDataGrid("instance");
				dataGrid.refresh();
			});
		}           
	})
}


function xoatoanbodscaptietxepliennhau(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa toàn bộ cặp tiết xếp liền nhau không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('dellrangbuoccaptietxepliennhauall',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});   
				captietbuocphaixepliennhau();
				var dataGrid = $("#girdrangbuoccaptietxepliennhau").dxDataGrid("instance");
				dataGrid.refresh();
			});
		}           
	})
}
		
var datachangemon;
axios.get("getdanhsachmonhoc").then(function(response) {
	let data = response.data;

	if (data != null) {
		let htmlmonhoc = data.map(function(item) {
			return ('<option value="' +item.id +'">' +item.tenmonhoc +"</option>");
		});
		$("#mon").html('<option value=""></option>' + htmlmonhoc);
	}
});




}

$('#updatecaptiet').click(function (){
	var idss = $("#id").val();
	var mamonhoc = $("#mon").val();
	if(mamonhoc == ""){
		alert("vui lòng chọn môn");
	}else{
		var phamvi = $("#phamviapdung").val();
		if(phamvi == 2){
			var lop = $("#lop").val();
			var khoi = $("#khoi").val();
		}else{
			var lop = null;
			var khoi = null;
		}
		var vitricaptiet = $("#tietthu").val();
		var tranhcaptietsang = $("#tranhtietsang").val();
		var tranhcaptietchieu = $("#tranhtietchieu").val();
		var mucrangbuoc = $("#mucrangbuoc").val();

		axios.post('updaterangbuoccaptietxepliennhau',{id:idss,mamonhoc:mamonhoc,phamvi:phamvi,lop:lop,khoi:khoi,vitricaptiet:vitricaptiet,tranhcaptietsang:tranhcaptietsang,tranhcaptietchieu:tranhcaptietchieu,mucrangbuoc:mucrangbuoc}).then(function(response) {
			var data1 = response.data;
			Swal.fire({
				title: 'Lưu',
				text: 'Đã lưu thành công',
				icon: 'success',
				confirmButtonText: 'OK'
			});
			document.getElementById("addcaptiet").disabled = false;
			document.getElementById("huycaptiet").hidden = true;
			document.getElementById("lop").hidden = true;
			$('#girdrangbuoccaptietxepliennhau').dxDataGrid("instance").option("disabled", false);	
			captietbuocphaixepliennhau();
			var dataGrid = $("#girdrangbuoccaptietxepliennhau").dxDataGrid("instance");
			dataGrid.refresh();
		});
	}
})


window.onload = function() {
	loadlop();
}


function changeitem(data) {	
	$("#id").val(data.id);	
	$("#mon").val(data.mamonhoc);
	$("#phamviapdung").val(data.phamvi);
	if(data.phamvi == 2){		
		document.getElementById("lop").hidden = false;
		$("#lop").val(data.lop);
		$("#khoi").val(data.khoi);
	}else{
		document.getElementById("lop").hidden = true;
	}	
	$("#tietthu").val(data.vitricaptiet);
	$("#mucrangbuoc").val(data.mucrangbuoc);
	$("#tranhtietsang").val(data.tranhcaptietsang);
	$("#tranhtietchieu").val(data.tranhcaptietchieu);	
}


function clearitem() {
	$("#id").val("");
	$("#khoi").val("");
	$("#mon").val("");
	$("#phamviapdung").val(0);
	$("#lop").val("");
	$("#tietthu").val(0);
	$("#mucrangbuoc").val(0);
	$("#tranhtietsang").val(0);
	$("#tranhtietchieu").val(0);
	document.getElementById("lop").hidden = true;
}


function disableitem(){
	document.getElementById("mon").disabled = true;
	document.getElementById("phamviapdung").disabled = true;
	document.getElementById("tietthu").disabled = true;
	document.getElementById("mucrangbuoc").disabled = true;
	document.getElementById("tranhtietsang").disabled = true;
	document.getElementById("tranhtietchieu").disabled = true;
}

function embeditem(){
	document.getElementById("mon").disabled = false;
	document.getElementById("phamviapdung").disabled = false;
	document.getElementById("tietthu").disabled = false;
	document.getElementById("mucrangbuoc").disabled = false;
	document.getElementById("tranhtietsang").disabled = false;
	document.getElementById("tranhtietchieu").disabled = false;
}