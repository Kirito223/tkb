@extends('master')
@section('title','Xuất thời khóa biểu')
@section('content')

<div class="card">
	<div class="card-header" style="padding: 10px">
		<h4 class="card-title" style="text-align: center;">XUẤT THỜI KHÓA BIỂU ĐỂ SỬ DỤNG</h4>
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
							<div class="card box-shadow-0 border-info bg-transparent" id="khaibao" style="display:none">
								<div class="card-header bg-transparent" style="padding: 10px">
									<div class="heading-elements">
										<ul class="list-inline mb-0">
											<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="card-content collapse show">
									<div class="card-body">
										<!-- <hr> -->
										<div class="form-group">
											<label for="projectinput1">Import thời khóa biểu Excel</label>
											<div class="controls">
												<input type="file" name="file[]" id="importfile"
													class="form-control input-sm" required=""
													style="padding: 0px;height: auto;">
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
											<label>Thời gian</label>
											<div style="z-index: 300">
												<div class="input-daterange input-group" style="width: 100%;">
													<span class="input-group-addon">Tháng</span>
													<input type="text" class="form-control-sm form-control" name="start"
														value="" id="selectmonth" placeholder="Chọn tháng">
													<span class="input-group-addon">Tuần</span>
													<select id="selectweek" name="interested" class="form-control">
														<option value="none" selected="" disabled="">--Chọn tuần--
														</option>
														<option value="1">Tuần 1
														</option>
														<option value="2">Tuần 2
														</option>
														<option value="3">Tuần 3
														</option>
														<option value="4">Tuần 4
														</option>
													</select>
												</div>
											</div>
											<label for="projectinput1">Xuất thời khóa biểu</label>
											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkbtongquat">
													Xuất thời khóa biểu trường
												</label>
												<section class="hidden" id="kieu">
													<label>
														<input type="radio" name="typeRadio" value="" id="tendaydu">
														Tên đầy đủ
													</label>
													<label>
														<input type="radio" name="typeRadio" value="" id="tenviettat">
														Tên viết tắt
													</label>
												</section>
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

											<fieldset class="radio" style="padding-right: 10px;">
												<label>
													<input type="radio" name="radio" value="" id="xuattkbdiemtruong">
													Xuất thời khóa biểu theo điểm trường
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
													<div class="col-md-2">
														<div class="form-group">
															<label>Ds báo cáo gửi lên PGD</label>
															<button type="button"
																class="btn mr-1 mb-1 btn-primary btn-sm"
																id="btndsbaocao">Ds báo cáo</button>
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
														<div id="dsgiaovienguimail" style="display:none"></div>
														<div id="dsgiaovienguimails"></div>
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

<!-- modal danh sách báo cáo -->
<div class="modal fade text-left" id="modaldsbaocao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-success white">
				<h5 class="modal-title" style="color: white;">Danh sách báo cáo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formthemthongbao" method="post" action="" enctype="multipart/form-data">
					<div class="form-body">
						<div id="girddsbaocao"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- modal thêm mới báo cáo  -->
<div class="modal fade text-left" id="modalthembaocao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-success white">
				<h5 class="modal-title" style="color: white;">Thông tin chung</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formthembaocao" method="post" action="" enctype="multipart/form-data">
					<div class="form-body">
						<h4 class="form-section"><i class="fa fa-info-circle"></i> Chi tiết báo cáo</h4>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput5">Loại</label>
									<select id="idloai" name="interested" class="form-control">
										<option value="none" selected="" disabled="">--Chọn loại báo cáo--
										</option>
										<option value="1">Công tác quản lý
										</option>
										<option value="2">Công tác chuyên môn
										</option>
										<option value="3">Lịch kiểm tra
										</option>
										<option value="4">Thông báo khác
										</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput2">Số/ký hiệu</label>
									<input type="text" id="idsohieu" class="form-control" name="lname">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput2">Tiêu đề</label>
									<input type="text" id="idtieude" class="form-control" name="lname">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput2">Ngày tạo</label>
									<input type="text" id="idngaytao" class="form-control" name="lname">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Tập tin đính kèm</label>
									<label id="projectinput7" class="file center-block">
										<input type="file" id="file">
										<span class="file-custom"></span>
										<button type="button" class="btn btn-danger" id="btnSign">Ký văn bản</button>
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput8">Nội dung</label>
									<textarea id="idnoidung" rows="5" class="form-control" name="comment"></textarea>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="btnluu">
					<i class="fa fa-check-square-o"></i> Lưu
				</button>
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>

<!-- modal sửa báo cáo -->
<div class="modal fade text-left" id="modalsuabaocao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-success white">
				<h5 class="modal-title" style="color: white;">Thông tin chung</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="formsuathongbao" method="post" action="" enctype="multipart/form-data">
					<div class="form-body">
						<h4 class="form-section"><i class="fa fa-info-circle"></i> Chi tiết thông báo</h4>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput5">Loại</label>
									<select id="idloaisua" name="interested" class="form-control">
										<option value="none" selected="" disabled="">--Chọn loại thông báo--
										</option>
										<option value="1">Công tác quản lý
										</option>
										<option value="2">Công tác chuyên môn
										</option>
										<option value="3">Lịch kiểm tra
										</option>
										<option value="4">Thông báo khác
										</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput2">Số/ký hiệu</label>
									<input type="text" id="idsohieusua" class="form-control" name="lname">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput2">Tiêu đề</label>
									<input type="text" id="idtieudesua" class="form-control" name="lname">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput2">Ngày tạo</label>
									<input type="text" id="idngaytaosua" class="form-control" name="lname">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Tập tin đính kèm</label>
									<br>
									<label id="projectinput7" class="file center-block">
										<input type="file" id="filesua">
										<div id="filedinhkemsua"></div>
										<button type="button" class="btn btn-danger">Ký văn bản</button>
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="projectinput8">Nội dung</label>
									<textarea id="idnoidungsua" rows="5" class="form-control" name="comment"></textarea>
								</div>
							</div>
						</div>
						<input type="hidden" name="" id="idbaocao">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="btnsua">
					<i class="fa fa-check-square-o"></i> Cập nhật
				</button>
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>

<!-- modal thông tin chung báo cáo -->
<div class="modal fade text-left" id="modalthongtinchung" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-success white">
				<h5 class="modal-title" style="color: white;">Thông tin chung</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form form-horizontal form-bordered">
					<div class="form-body">
						<h4 class="form-section"><i class="fa fa-info-circle"></i> Chi tiết báo cáo</h4>
						<div class="form-group row">
							<label class="col-md-3 label-control" for="projectinput1">Loại</label>
							<div class="col-md-9">
								<input type="text" id="idloaixem" class="form-control" name="fname" disabled="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 label-control" for="projectinput2">Số/ký hiệu</label>
							<div class="col-md-9">
								<input type="text" id="idsohieuxem" class="form-control" name="lname" disabled="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 label-control" for="projectinput3">Tiêu đề</label>
							<div class="col-md-9">
								<input type="text" id="idtieudexem" class="form-control" name="email" disabled="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 label-control" for="projectinput4">Ngày tạo</label>
							<div class="col-md-9">
								<input type="text" id="idngaytaoxem" class="form-control" name="phone" disabled="">
							</div>
						</div>

						<div class="form-group row" id="formngaygui">
							<label class="col-md-3 label-control" for="projectinput4">Ngày gửi</label>
							<div class="col-md-9">
								<input type="text" id="idngayguixem" class="form-control" name="phone" disabled="">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 label-control">Tập tin đính kèm</label>
							<div class="col-md-9">
								<label id="projectinput8" class="file center-block">
									<!-- <input type="file" id="file"> -->
									<div id="filedinhkem"></div>
									<!-- <span class="file-custom"><a href="http://www.africau.edu/images/default/sample.pdf" target="_blank">File1</a></span>
                                    <br>
                                    <span class="file-custom"><a href="http://www.africau.edu/images/default/sample.pdf" target="_blank">File2</a></span> -->
								</label>
							</div>
						</div>

						<div class="form-group row last">
							<label class="col-md-3 label-control" for="projectinput4">Nội dung</label>
							<div class="col-md-9">
								<textarea id="idnoidungxem" rows="5" class="form-control" name="comment"
									disabled=""></textarea>
							</div>
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Đóng</button>
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
					var id = setInterval(frame, 50);
					function frame() {
						if (width >= 60) {
							clearInterval(id);
							i = 0;
							
						} else {
							width++;
							elem.style.width = width + "%";
							if(width == 60){
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


		axios.post('importexceltkb',datalucky).then(function (response) {
			var data =  response.data;
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
			$("#dsgiaovienguimails").dxDataGrid({
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




	//js gửi báo cáo PGD


	function reloadbaocao() {
		loaddanhsachbaocao();
		var dataGrid = $("#girddsbaocao").dxDataGrid("instance");
		dataGrid.clearSelection();
		dataGrid.refresh();
		    // dataGrid.reload();
		}

		function loaddanhsachbaocao() {
			axios.get('getdsbaocao').then(function(response) {
				var data1 = response.data;
				var datas = data1.map(function(value, label) {
					let data = value;
					let stt = label + 1;
					var datas = Object.assign(data, {
						stt: stt.toString()
					});
					return datas;
				});
				$("#girddsbaocao").dxDataGrid({
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
		            // filterRow: {
		            //  visible: true,
		            //  applyFilter: "auto"
		            // },
		            searchPanel: {
		            	visible: true,
		            	width: 240,
		            	placeholder: "Tìm kiếm..."
		            },
		            pager: {
		            	showPageSizeSelector: true,
		            	allowedPageSizes: [10, 20, 30],
		            	showInfo: true
		            },
		            /* co dan cot */
		            allowColumnResizing: true,
		            columnResizingMode: "widget",
		            selection: {
		            	mode: "single",
		            },
		            columns: [{
		            	caption: "STT",
		            	dataField: "stt",
		            	width: 50,
		            }, {
		            	caption: "Số hiệu",
		            	dataField: "sohieu",
		            }, {
		            	caption: "Tiêu đề",
		            	dataField: "tieude",
		            }, {
		            	caption: "Loại",
		            	dataField: "loai",
		            	cellTemplate: function (container, options) {
		            		if (options.data.loai == 1) {
		            			$(
		            				"<span>Công tác quản lý</span>"
		            				).appendTo(container);
		            		}
		            		if (options.data.loai == 2) {
		            			$(
		            				"<span>Công tác chuyên môn</span>"
		            				).appendTo(container);
		            		}
		            		if (options.data.loai == 3) {
		            			$(
		            				"<span>Lịch kiểm tra</span>"
		            				).appendTo(container);
		            		}
		            		if (options.data.loai == 4) {
		            			$(
		            				"<span>Thông báo khác</span>"
		            				).appendTo(container);
		            		}
		            	},
		            }, {
		            	caption: "Người cập nhật",
		            	dataField: "tentaikhoan"
		            }, {
		            	caption: "Gửi",
		            	dataField: "gui",
		            	cellTemplate: function (container, options) {
		            		if (options.data.gui == 0) {
		            			$(
		            				"<span style='color:red'>Chưa gửi</span>"
		            				).appendTo(container);
		            		}
		            		if (options.data.gui == 1) {
		            			$(
		            				"<span style='color:blue'>Đã gửi</span>"
		            				).appendTo(container);
		            		}
		            	},
		            }, {
		            	caption: "Tình trạng",
		            	dataField: "trangthai",
		            	cellTemplate: function (container, options) {
		            		if (options.data.trangthai == 0) {
		            			$(
		            				"<span style='color:red'>Chưa xem</span>"
		            				).appendTo(container);
		            		}
		            		if (options.data.trangthai == 1) {
		            			$(
		            				"<span style='color:blue'>Đã xem</span>"
		            				).appendTo(container);
		            		}
		            	},
		            }, {
		            	fixed: true,
		            	fixedPosition: "right",
		            	caption: "Xem",
		            	cellTemplate: function(container, options) {
		            		container.addClass("center");
		            		$("<div>")
		            		.dxButton({
		            			template: function(e) {
		            				return $('<i class="fa fa-eye"></i>');
		            			},
		            			onClick: function(e) {
		            				var data = options.data;
		            				$('#filedinhkem a').empty();
		            				loaddatamodalthongtinchung(data);
		            				$('#modalthongtinchung').modal('show');

		            			},
		            		})
		            		.css('background-color', '#008CBA')
		            		.appendTo(container);
		            	},
		            	width: 50,
		            }, {
		            	fixed: true,
		            	fixedPosition: "right",
		            	caption: "Sửa",
		            	cellTemplate: function(container, options) {
		            		container.addClass("center");
		            		$("<div>")
		            		.dxButton({
		            			template: function(e) {
		            				return $('<i class="fa fa-pencil-square-o"></i>');
		            			},
		            			onClick: function(e) {
		            				var data = options.data;
		            				if(data.gui == 1){
		            					Swal.fire(
		            						"Báo cáo đã được gửi đi",
		            						"Báo cáo đã được gửi không thể sửa",
		            						"info"
		            						);
		            				}else{
		            					$('#filedinhkemsua a').empty();
		            					loadmodalsua(data);
		            					$('#modalsuabaocao').modal('show');
		            				}
		            			},
		            		})
		            		.css('background-color', '#4CAF50')
		            		.appendTo(container);
		            	},
		            	width: 50,
		            }, {
		            	fixed: true,
		            	fixedPosition: "right",
		            	caption: "Xoá",
		            	cellTemplate: function(container, options) {
		            		container.addClass("center");
		            		$("<div>")
		            		.dxButton({
		            			template: function(e) {
		            				return $('<i class="fa fa-trash-o"></i>');
		            			},
		            			onClick: function(e) {
		            				var data = options.data;
		            				if(data.gui == 1){
		            					Swal.fire(
		            						"Báo cáo đã được gửi đi",
		            						"Báo cáo đã được gửi không thể xoá",
		            						"info"
		            						);
		            				}else{
		            					Swal.fire({
		            						title: 'Xoá?',
		            						text: "Bạn có muốn xoá!",
		            						icon: 'warning',
		            						showCancelButton: true,
		            						confirmButtonColor: '#3085d6',
		            						cancelButtonColor: '#d33',
		            						confirmButtonText: 'OK'
		            					}).then((result) => {
		            						if (result.value) {
		            							axios.post('delbaocao', {
		            								idbaocao: data.id
		            							}).then(function(response) {
		            								var data = response.data;
		            								if(data == 1){
		            									Swal.fire(
		            										'Xoá!',
		            										'Xoá thành công.',
		            										'success'
		            										)
		            									reloadbaocao();
		            								}
		            							});
		            						}
		            					}) 
		            				}
		            				
		            			},
		            		})
		            		.css('background-color', '#f44336')
		            		.appendTo(container);
		            	},
		            	width: 50,
		            }, {
		            	fixed: true,
		            	fixedPosition: "right",
		            	caption: "Gửi",
		            	cellTemplate: function(container, options) {
		            		container.addClass("center");
		            		$("<div>")
		            		.dxButton({
		            			template: function(e) {
		            				return $('<i class="fa fa-share-square-o"></i>');
		            			},
		            			onClick: function(e) {
		            				var data = options.data;
		            				if(data.gui == 1){
		            					Swal.fire(
		            						"Báo cáo đã được gửi không thể gửi lại",
		            						"Báo cáo đã được gửi đi",
		            						"info"
		            						);
		            				}else{
		            					axios.post('sendbaocao',{
		            						idbaocao: data.id
		            					}).then(function(response) {
		            						var data = response.data;
		            						if (data == 1) {
		            							Swal.fire(
		            								"Đã gửi",
		            								"Bạn đã gửi thành công",
		            								"success"
		            								)
		            							reloadbaocao();
		            						}
		            					});
		            				}
		            			},
		            		})
		            		.css('background-color', '#C71585')
		            		.appendTo(container);
		            	},
		            	width: 50,
		            },{
		            	fixed: true,
		            	fixedPosition: "right",
		            	caption: "Thu hồi",
		            	cellTemplate: function(container, options) {
		            		container.addClass("center");
		            		$("<div>")
		            		.dxButton({
		            			template: function(e) {
		            				return $('<i class="fa fa-ban"></i>');
		            			},
		            			onClick: function(e) {
		            				var data = options.data;
		            				if(data.gui != 1 ){
		            					Swal.fire(
		            						"Báo cáo chưa được gửi không thể thu hồi",
		            						"Báo cáo chưa được gửi",
		            						"info"
		            						);
		            				}else if(data.trangthai == 1){
		            					Swal.fire(
		            						"Báo cáo đã được xem không thể thu hồi",
		            						"Báo cáo đã được xem",
		            						"info"
		            						);
		            				}else if(data.gui == 1 && data.trangthai != 1){
		            					Swal.fire({
		            						title: 'Thu hồi báo cáo?',
		            						text: "Bạn có muốn thu hồi báo cáo!",
		            						icon: 'warning',
		            						showCancelButton: true,
		            						confirmButtonColor: '#3085d6',
		            						cancelButtonColor: '#d33',
		            						confirmButtonText: 'OK'
		            					}).then((result) => {
		            						if (result.value) {
		            							axios.post('thuhoibaocao', {
		            								idbaocao: data.id
		            							}).then(function(response) {
		            								var data = response.data;
		            								if(data == 1){
		            									Swal.fire(
		            										'Thu hồi báo cáo!',
		            										'Thu hồi báo cáo thành công.',
		            										'success'
		            										)
		            									reloadbaocao();
		            								}
		            							});
		            						}
		            					});
		            				}
		            			},
		            		})
		            		.css('background-color', '#B8860B')
		            		.appendTo(container);
		            	},
		            	width: 65,
		            }],
		            onToolbarPreparing: function(e) {
		            	var dataGrid = e.component;
		            	e.toolbarOptions.items.unshift({
		            		location: "after",
		            		widget: "dxButton",
		            		options: {
		            			text: "Thêm mới",
		            			icon: "fa fa-plus-square",
		            			onClick: function() {
		            				$('#modalthembaocao').modal('show');
		            			},
		            		},

		            	}, );
		            },
		        });
});

}
		//load thông tin xem báo cáo
		function loaddatamodalthongtinchung(data){
			var datattc = data;
			var tenloai;
			if(datattc.loai == 1){
				tenloai = "Công tác quản lý";
			}else if(datattc.loai == 2){
				tenloai = "Công tác chuyên môn";
			}else if(datattc.loai == 3){
				tenloai = "Lịch kiểm tra";
			}else if(datattc.loai == 4){
				tenloai = "Thông báo khác";
			}
			var ngaytao = datattc.ngaytao;
			var formatngaytao = moment(ngaytao).format('DD/MM/YYYY');
			var ngaygui = datattc.ngaygui;
			if(ngaygui != null){
				$('#formngaygui').show();
			}else{
				$('#formngaygui').hide();
			}
			var formatngaygui = moment(ngaygui).format('DD/MM/YYYY');
			$('#idloaixem').val(tenloai);
			$('#idsohieuxem').val(datattc.sohieu);
			$('#idtieudexem').val(datattc.tieude);
			$('#idngaytaoxem').val(formatngaytao);
			$('#idngayguixem').val(formatngaygui);
			$('#idnoidungxem').text(datattc.noidung);
			var tenfile = datattc.file;
	      	// var url = url('uploads/thongbao/'+tenfile);
	      	var divfile = document.getElementById("filedinhkem");
	      	var a = document.createElement('a');
	      	a.textContent= tenfile;
	      	a.href = "uploads/baocao/"+tenfile+"";
	      	// a.target = '_blank';
	      	divfile.appendChild(a);
	      }

		//load modal sửa báo cáo
		function loadmodalsua(data){
			var datatts = data;
			$('#idbaocao').val(datatts.id);
			$('#idloaisua option').each(function(value) {
				if (datatts.loai == $(this).val()) {
					$(this).attr('selected', 'selected');
				}else{
					$(this).removeAttr('selected','selected');
				}
			});
			$('#idsohieusua').val(datatts.sohieu);
			$('#idtieudesua').val(datatts.tieude);
			var ngaytaosua = datatts.ngaytao;
			var formatngaytaosua = moment(ngaytaosua).format('DD/MM/YYYY');
			$('#idngaytaosua').val(formatngaytaosua);
			$('#idnoidungsua').text(datatts.noidung);
			var tenfilesua = datatts.file;
			var divfile = document.getElementById("filedinhkemsua");
			var a = document.createElement('a');
			a.textContent= tenfilesua;
			a.href = "uploads/baocao/"+tenfilesua+"";
		      // a.target = '_blank';
		      divfile.appendChild(a);
		  }
		//thêm mới báo cáo
		$('#btnluu').click(function() {
			var idloai = $('#idloai').val();
			var idsohieu = $('#idsohieu').val();
			var idtieude = $('#idtieude').val();
			var idngaytao = $('#idngaytao').val();
			var idnoidung = $('#idnoidung').val();
			var formData = new FormData();
			var imagefile = document.querySelector('#file');
			formData.append("file", imagefile.files[0]);
			formData.append("idloai", idloai);
			formData.append("idsohieu", idsohieu);
			formData.append("idtieude", idtieude);
			formData.append("idngaytao", idngaytao);
			formData.append("idnoidung", idnoidung);
			axios.post('addbaocao', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(function(response) {
				var data = response.data;
				if (data == 1) {
					Swal.fire({
						title: 'Lưu',
						text: 'Đã lưu thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					$('#modalthembaocao').modal("hide");
					$('#modalthembaocao').on('hidden.bs.modal', function() {
						$(this).find('#formthembaocao')[0].reset();
		                // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
		            });
					reloadbaocao();
				}
			});
		});
		//sửa báo cáo
		$('#btnsua').click(function() {
			var idbaocao = $('#idbaocao').val();
			var idloai = $('#idloaisua').val();
			var idsohieu = $('#idsohieusua').val();
			var idtieude = $('#idtieudesua').val();
			var idngaytao = $('#idngaytaosua').val();
			var idnoidung = $('#idnoidungsua').val();
			var formData = new FormData();
			var imagefile = document.querySelector('#filesua');
			formData.append("file", imagefile.files[0]);
			formData.append("idbaocao", idbaocao);
			formData.append("idloai", idloai);
			formData.append("idsohieu", idsohieu);
			formData.append("idtieude", idtieude);
			formData.append("idngaytao", idngaytao);
			formData.append("idnoidung", idnoidung);
			axios.post('updatebaocao', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(function(response) {
				var data = response.data;
				if (data == 1) {
					Swal.fire({
						title: 'Cập nhật',
						text: 'Đã cập nhật thành công',
						icon: 'success',
						confirmButtonText: 'OK'
					});
					$('#modalsuabaocao').modal("hide");
					$('#modalsuabaocao').on('hidden.bs.modal', function() {
						$(this).find('#formsuabaocao')[0].reset();
		                // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
		            });
					reloadbaocao();
				}
			});
		});
		$('#btndsbaocao').on('click',function(){
			loaddanhsachbaocao();
			$('#idngaytao').datepicker({
				autoclose: true,
				language: "vi",

			});
			$('#idngaytaosua').datepicker({
				autoclose: true,
				language: "vi",

			});
		    // danh sách báo cáo
		    $('#modaldsbaocao').modal('show');
		    

		});

	});


	



/*********************************************************
 * Ký số văn bản *
 ********************************************************/
	var urlFile="";
	$('#btnSign').click(function(){
 exc_sign_approved();
});
function SignFileCallBack1(rv) {
    var received_msg = JSON.parse(rv);
    console.log(received_msg);
    if (received_msg.Status == 0) {
        Swal.fire(
            received_msg.FileName +
                ":" +
                received_msg.FileServer +
                ":" +
                received_msg.DocumentNumber +
                ":" +
                received_msg.DocumentDate,
            "Thông báo",
            "info"
        );
        //them code luu tru file ky so va tai ve thu muc lucu tru file
        console.log(received_msg.FileServer);
        // document.getElementById("file1").value = received_msg.FileServer;
        // document.getElementById("file2").value = received_msg.FileServer;
    } else {
        Swal.fire(received_msg.Message, "Không thành công", "error");
    }
}

// Đóng dấu phát hành
function exc_sign_issued() {
    var prms = {};

    prms["FileUploadHandler"] =
        "https://api.lihanet.com/FileUploadHandler.aspx";
    prms["SessionId"] = "";
    prms["FileName"] = urlFile;
    prms["DocNumber"] = $("#docNumber");
    prms["IssuedDate"] = new Date();

    var json_prms = JSON.stringify(prms);
    vgca_sign_issued(json_prms, SignFileCallBack1);
}
// Ham ky phe duyet
function exc_sign_approved() {
    var prms = {};

    prms["FileUploadHandler"] =
        "https://api.lihanet.com/FileUploadHandler.aspx";
    prms["SessionId"] = "";
    prms["FileName"] = urlFile; //"http://localhost:16227/files/test1.pdf";

    var json_prms = JSON.stringify(prms);
    vgca_sign_approved(json_prms, SignFileCallBack1);
}
///Ký số công văn đến
function exc_sign_income() {
    var prms = {};
    var scv = [{ Key: "abc", Value: "abc" }];

    prms["FileUploadHandler"] =
        "https://api.lihanet.com/FileUploadHandler.aspx";
    prms["SessionId"] = "";
    prms["FileName"] = urlFile;
    prms["MetaData"] = scv;

    var json_prms = JSON.stringify(prms);
    vgca_sign_income(json_prms, SignFileCallBack1);
}
function exc_appendix(url) {
    var prms = {};
    var scv = [{ Key: "abc", Value: "abc" }];

    prms["FileUploadHandler"] =
        "https://api.lihanet.com/FileUploadHandler.aspx";
    prms["SessionId"] = "";
    prms["FileName"] = url;
    prms["DocNumber"] = "123/BCY-CTSBMTT";
    prms["MetaData"] = scv;

    var json_prms = JSON.stringify(prms);
    vgca_sign_appendix(json_prms, SignFileCallBack1);
}

function exc_sign_copy(url) {
    var prms = {};
    var scv = [{ Key: "abc", Value: "abc" }];

    prms["FileUploadHandler"] =
        "https://api.lihanet.com/FileUploadHandler.aspx";
    prms["SessionId"] = "";
    prms["FileName"] = url;
    prms["DocNumber"] = "123/BCY-CTSBMTT";
    prms["MetaData"] = scv;

    var json_prms = JSON.stringify(prms);
    vgca_sign_copy(json_prms, SignFileCallBack1);
}
</script>
<script src="js/vgcaplugin.js"></script>
<script type="module" src="js/xuattkb/xuattkb.js"></script>
<script type="text/javascript" src='dx/js/jszip/dist/xlsx.full.min.js'></script>
@endsection