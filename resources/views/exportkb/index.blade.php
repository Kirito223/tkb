@extends('master')
@section('title','Xuất thời khóa biểu')
@section('content')

<div class="card">
	<div class="card-header" style="padding: 10px">
		<h4 class="card-title" style="text-align: center;">IMPROT & XUẤT THỜI KHÓA BIỂU ĐỂ SỬ DỤNG</h4>
		<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements" style="top: 10px">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
			</ul>
		</div>
		<hr>
	</div>
	<div class="card-content collpase show">
		<div class="card-body">
			<form class="form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-4">
							<div class="card box-shadow-0 border-info bg-transparent" id="khaibao">
								<div class="card-header bg-transparent" style="padding: 10px">
									<div class="heading-elements">
										<ul class="list-inline mb-0">
											<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="card-content collapse show" style="">
									<div class="card-body">
										<!-- <hr> -->
										<div class="form-group">
											<label for="projectinput1">Import thời khóa biểu Excel</label>
											<div class="controls">
												<input type="file" name="file[]" id="importfile"
													class="form-control input-sm" required="" style="padding: 0px;
																														height: auto;">
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card box-shadow-0 border-info bg-transparent" id="khaibao">
								<div class="card-header bg-transparent" style="padding: 10px">
									<div class="heading-elements">
										<ul class="list-inline mb-0">
											<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="card-content collapse show" style="">
									<div class="card-body">
										<!-- <hr> -->
										<div class="form-group">
											<div id="progressExport" class="progress hidden">
												<div class="progress-bar progress-bar-striped progress-bar-animated"
													role="progressbar" aria-valuenow="75" aria-valuemin="0"
													aria-valuemax="100" style="width: 65%">Đang xuất thời khóa biểu vui
													lòng chờ</div>
											</div>
										</div>
										<div class="form-group">
											<label for="projectinput1">Xuất thời khóa biểu</label>
											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkbtongquat">
													Xuất thời khóa biểu trường
												</label>
											</fieldset>
											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkblop">
													Xuất thời khóa biểu lớp
												</label>
											</fieldset>
											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkbgiaovien">
													Xuất thời khóa biểu giáo viên
												</label>
											</fieldset>
											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkbphancongcm">
													Xuất thời khóa biểu phân công chuyên môn
												</label>
											</fieldset>
											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkbphong">
													Xuất thời khóa biểu theo phòng
												</label>
											</fieldset>
											<hr>
											<div style="height: 300px; margin-bottom:3px; overflow: scroll;"
												id="tableList" class="hidden">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th><input type="checkbox" id="selectAll" /></th>
															<th id="titleColumn"></th>
														</tr>
													</thead>
													<tbody id="bodyTableList">

													</tbody>
												</table>

											</div>


											<button type="button" class="btn btn-success btn-sm" id="xuattkb">Xuất thời
												khóa
												biểu</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="card box-shadow-0 border-info bg-transparent" id="khaibao">
								<div class="card-header bg-transparent" style="padding: 10px">
									<h5 class="card-title" id="basic-layout-form">Gửi Email</h5>
									<a class="heading-elements-toggle"><i
											class="fa fa-ellipsis-v font-medium-3"></i></a>
									<div class="heading-elements">
										<ul class="list-inline mb-0">
											<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="card-content collapse show" style="">
									<div class="card-body">
										<form class="form">
											<div class="form-body">
												<h6 class="form-section"><i class="ft-calendar"></i> Thời khóa biểu</h6>
												<div class="row">
													<!-- 									<div class="col-md-3">
														<div class="form-group">
															<label>Tháng</label>
<select type="text" id="projectinput1" class="form-control input-sm"></select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label>Tuần</label>
<select type="text" id="projectinput1" class="form-control input-sm"></select>
														</div>
</div> -->
													<div class="col-md-2">
														<div class="form-group">
															<label>File đính kèm (Ký số)</label>
															<button id="btnAttachFile" type="button"
																class="btn mr-1 mb-1 btn-info btn-sm">File đính
																kèm</button>
														</div>
														<div class="form-group">
															<p>Danh sách file đính kèm:</p>
															<ul id="listFileAttach"></ul>
															<input type="file" id="fileInput" multiple class="hidden" />
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label>Gửi mail</label>
															<button id="sendEmail" type="button"
																class="btn mr-1 mb-1 btn-success btn-sm">Gửi</button>
														</div>
													</div>

												</div>
											</div>
										</form>

										<form class="form">
											<div class="form-body">
												<h6 class="form-section"><i class="ft-calendar"></i> Danh sách giáo viên
													cần gửi</h6>
												<div class="row">
													<div class="col-md-12">
														<div id="dsgiaovienguimail"></div>
													</div>
												</div>
											</div>
										</form>




									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>



</div>

<!-- modal loading -->
<div class="modal fade text-left show" id="modalloading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20">
	<div class="modal-dialog modal-xs" role="document">
		<div class="modal-content">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Đang cập nhât! Vui lòng đợi trong giây lát</h4>

						</div>
						<div class="card-content">
							<div class="card-body text-center">
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
										id="loading" role="progressbar" aria-valuenow="80" aria-valuemin="80"
										aria-valuemax="100" style="width:0%"></div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	document.getElementById('importfile').addEventListener('change', handleFileSelect, false);
	var ExcelToJSON = function() {
	this.parseExcel = function(file) {
	var reader = new FileReader();
	reader.onload = function(e) {
	var data = e.target.result;
	var workbook = XLSX.read(data, {
	type: 'binary'
	});
	workbook.SheetNames.forEach(function(sheetName) {
	
	var xlsx = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
	
	var arrResult = [];
	xlsx.forEach(function(element){
	let obj = {};
	// Lap qua tung phan tu va tao obj moi chua cac key value nhu minh muon
	for (const property in element) {
	var str = property;
	str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
	str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
	str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
	str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
	str = str.replace(/đ/g,"d",);
	// str = str.replace(/[!@#$%^&*-;()]/g, "");
	str = str.replace(/\s+/g, '');
	str = str.trim();
	
	let key = str;
	let keynumber = parseInt(key.slice(0,1));
	var ii = Number.isInteger(keynumber);
	obj[key] = element[property];
	if(Number.isInteger(keynumber) == true){
	obj['lop'] = key;
	obj['mon'] = element[property];
	}
	
	
	}
	arrResult.push(obj);
	});
	var dataResult = arrResult.filter(function(number,key) {
	if(key >= 1 ){
	return number;
	}
	});
	if(dataResult != ""){
	importexcel(dataResult);
	}
	})
	};
	reader.onerror = function(ex) {
	console.log(ex);
	};
	reader.readAsBinaryString(file);
	};
	};

function handleFileSelect(evt) {
Swal.fire({
title: 'Lưu',
text: "Bạn có muốn import file excel này không",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Lưu'
}).then((result) => {
if (result.value) {
var files = evt.target.files;
var xl2json = new ExcelToJSON();
xl2json.parseExcel(files[0]);
$('#modalloading').modal('show');
var i = 0;
if (i == 0) {
i = 1;
var elem = document.getElementById("loading");
var width = 1;
var id = setInterval(frame, 80);
function frame() {
if (width >= 200) {
clearInterval(id);
i = 0;

} else {
width++;
elem.style.width = width + "%";
if(width == 200){
$('#modalloading').modal('toggle');
}
}
}

}

}
$('#importfile').val('');
})
}

function importexcel(datas){
var data = datas.map(function (value, key){
var monhoc = value.mon;
var tengv = value.undefined;
var tiet = value.Tiet;
var thubuoi = value.Thu;
var lop = value.lop;
if(thubuoi != undefined){
var thu = thubuoi.slice(4,6);
var buois = thubuoi.slice(6,15);
if(buois == "Sáng"){
var buoi = "0";
}else if(buois == "Chiều"){
var buoi = "1";
}
}
if(key == 1,2,3,4){
var buoi = "0";
var thu = "2";
}else if(key == 6,7,8,9){
var buoi = "1";
var thu = "2";
}else if(key == 11,12,13,14){
var buoi = "0";
var thu = "3";
}else if(key == 16,17,18,19){
var buoi = "1";
var thu = "3";
}else if(key == 21,22,23,24){
var buoi = "0";
var thu = "4";
}else if(key == 26,27,28,29){
var buoi = "1";
var thu = "4";
}else if(key == 31,32,33,34){
var buoi = "0";
var thu = "5";
}else if(key == 36,37,38,39){
var buoi = "1";
var thu = "5";
}else if(key == 41,42,43,44){
var buoi = "0";
var thu = "6";
}else if(key == 46,47,48,49){
var buoi = "1";
var thu = "6";
}else if(key == 51,52,53,54){
var buoi = "0";
var thu = "7";
}else if(key == 56,57,58,59){
var buoi = "1";
var thu = "7";
}
return {
monhoc: monhoc,
tengv: tengv,
tiet: tiet,
thu:thu,
buoi:buoi,
lop:lop,
}
});
var datalucky = data.filter(function(number) {
if(number != undefined){
if (number.monhoc != undefined && number.tengv != undefined) {
return number;
}
}
});

// $.ajaxSetup({
// headers: {
// 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// }
// });

// $.ajax({
// type: "POST",
// url: "importexceltkb",
// dataType: 'json',
// data:{datalucky},
// success: function (data) {
// set_data(data);
// }
// });


axios.post('importexceltkb',datalucky).then(function (response) {
var data = response.data;
});
}


$( document ).ready(function() {
		var data = axios.get('getdanhsachgv').then(function (response) {
			var data1 = response.data;
			var datas = data1.map(function (value, label) {
				let data = value;
				let stt = label + 1;
				var datas = Object.assign(data, {stt: stt.toString()});
				return datas;
});
			$("#dsgiaovienguimail").dxDataGrid({
				dataSource: datas,
				showBorders: true,
				// remoteOperations: true,
				scrolling: {
					mode: "virtual",
					rowRenderingMode: "virtual"
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
					dataField: "hovaten",
				},{
					caption: "Email",
					dataField: "email",
				}],
				// select data row
				onSelectionChanged: function (selectedItems) {

				},
			});
		});
});
</script>
<script type="module" src="js/xuattkb/xuattkb.js"></script>
<script type="text/javascript" src='dx/js/jszip/dist/xlsx.full.min.js'></script>
@endsection