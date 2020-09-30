@extends('master')
@section('title','Khai báo')
@section('content')

<dir class="row" style="padding: 0;margin: 0">
	<dir class="col-md-3" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">Khai báo dữ liệu</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements"  style="top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collpase show">
				<div class="card-body">
					<form class="form">
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Chọn thời khóa biểu</label>
										<input type="text" id="projectinput1" class="form-control input-xs" placeholder="" name="fname">
									</div>
									<hr>

									<fieldset class="checkbox">
										<label>
											<input type="checkbox" id="importexcel"> Nạp dữ liệu từ TKB Excel
										</label>
									</fieldset>
									<fieldset class="checkbox">
										<label>
											<input type="checkbox" id="importdata" checked> Nhập dữ liệu trực tiếp
										</label>
									</fieldset>

									<hr>

									<div class="card box-shadow-0 border-info bg-transparent" id="nhapdulieuhethong">
										<div class="card-header bg-transparent" style="padding: 10px">
											<h6 class="card-title" style="font-size: medium;">NHẬP DỮ LIỆU HỆ THỐNG</h6>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
											<div class="heading-elements">
												<ul class="list-inline mb-0">
													<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
												</ul>
											</div>
										</div>
										<div class="card-content collapse show" style="">
											<div class="card-body">
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="nhapdanhsachlophoc">
														Nhập danh sách lớp
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="nhapdanhsachgv">
														Nhập danh sách GV
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="nhapdanhsachtochuyenmon">
														Nhập tổ chuyên môn
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="nhapdanhsachmonhoc">
														Nhập danh sách môn học
													</label>
												</fieldset>

												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="danhsachgvcuatochuyenmon">
														DSGV của tổ CM
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="nhapdanhsachphonghocbomon">
														Nhập DS phòng học bộ môn
													</label>
												</fieldset>
											</div>
										</div>
									</div>
									<div class="card box-shadow-0 border-info bg-transparent" id="khaibao">
										<div class="card-header bg-transparent" style="padding: 10px">
											<h6 class="card-title" style="font-size: medium;">KHAI BÁO: </h6>
											<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
											<div class="heading-elements">
												<ul class="list-inline mb-0">
													<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
												</ul>
											</div>
										</div>
										<div class="card-content collapse show" style="">
											<div class="card-body">
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="chongvthamgiagiangday">
														Chọn GV tham gia giảng dạy
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="chon_monhoc">
														Chọn môn học
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="chon_lophoc">
														Chọn lớp học
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="chon_tochuyenmon">
														Chọn tổ/nhóm chuyên môn
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="chon_phonghoc">
														Chọn phòng học bộ môn (nếu có)
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="sotiet_trongbuoi">
														Số tiết trong buổi của mỗi lớp
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="sotiet_moimon">
														Số tiết ở mỗi môn của mỗi lớp
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="phancong_giaovienday">
														Phân công giáo viên dạy
													</label>
												</fieldset>
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
	</dir>
	<dir class="col-md-9" style="margin: 0;padding: 2px">
		<div class="card" style="margin-bottom: 10px;">
			<div class="card-header" style="padding: 10px">	
				<h4 class="card-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>			
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collpase show">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<h4 class="card-title"  style="text-align: center;">KHAI BÁO DỮ LIỆU XẾP TKB TRƯỜNG THCS TEST 12: TKB CHÍNH KHÓA</h4>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<button type="button" class="btn mr-1 mb-1 btn-light btn-sm">Xem hướng dẫn</button>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="btnimportexcel" style="display: none"><i class="fa fa-file-excel-o"></i> Nhập dữ liệu excel</button>
						</div>

					</div>

				</div>
			</div>
		</div>



		<!-- tải file excel chứa thời khóa biểu -->
		<div class="card" id="formimportexcel" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<h5>Tải lên file excel chứa thời khóa biểu</h5>
								<div class="controls">
									<input type="file" name="file[]" id="importfile" class="form-control input-sm" required="" style="padding: 0px;
									height: auto;">
								</div>	
								<!-- <input id="upload" type=file  name="files[]"  style="display: none;" /> -->
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
								<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="btnimportexcel"  onclick="document.getElementById('link').click()"><i class="fa fa-file-excel-o"></i> Tải file mẫu</button>	
								<a id="link" href="excelfilemau/bangphancongtkb.xls" download hidden></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- nhập danh sách lop hoc -->
		<div class="card" id="formnhapdanhsachlophoc" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="girdnhapdanhsachlophoc"></div>
				</div>
			</div>
		</div>


		<!-- nhập danh sách giáo viên -->
		<div class="card" id="formnhapdanhsachgv" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="girdnhapdanhsachgv"></div>
				</div>
			</div>
		</div>


		<!-- nhập danh sách to chuyen mon -->
		<div class="card" id="formnhapdanhsachtochuyenmon" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">				
					<div id="girdnhapdanhsachtochuyenmon"></div>
				</div>
			</div>
		</div>



		<!-- nhập danh sách mon hoc -->
		<div class="card" id="formnhapdanhsachmonhoc" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="girdnhapdanhsachmonhoc"></div>
				</div>
			</div>
		</div>







		<!-- Danh sách giáo viên tổ chuyên môn -->
		<div class="card" id="formdanhsachgvtochuyenmon" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-md-5 label-control">Chọn tổ chuyên môn</label>
								<div class="col-md-7">
									<div id="dsgvcuatochuyemon"></div>
								</div>
							</div>
						</div>
					</div>
					<div id="girdnhapdanhsachdanhsachgvtochuyenmon"></div>
				</div>
			</div>
		</div>





		<!-- nhập danh sách phòng học bộ môn -->
		<div class="card" id="formnhapdanhsachphonghocbomon" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="girdnhapdanhsachphonghocbomon"></div>
				</div>
			</div>
		</div>





		<!-- Chọn GV tham gia giảng dạy -->
		<div class="card" id="formdanhsachgvthamgiagiangday" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="capnhat"></div>
					<div id="girddanhsachgvthamgiagiangday"></div>
				</div>
			</div>
		</div>




		<!-- Chọn môn học -->
		<div class="card" id="formdanhsach_monhoc" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="capnhat_monhoc" disabled>Cập nhật</button>
					<hr>
					<div id="girddanhsach_monhoc"></div>
				</div>
			</div>
		</div>


		

		<!-- Chọn lớp học -->
		<div class="card" id="formdanhsach_lophoc" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="capnhatthlophoc"></div>
					<div id="girddanhsach_lophoc"></div>
				</div>
			</div>
		</div>






		<!-- Chọn tổ/nhóm chuyên môn -->
		<div class="card" id="formdanhsach_tochuyenmon" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="capnhatthtocm"></div>
					<div id="girddanhsach_tochuyenmon"></div>
				</div>
			</div>
		</div>




		<!-- Chọn phòng học bộ môn  -->
		<div class="card" id="formdanhsach_phonghoc" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div id="capnhatthphonghoc"></div>
					<div id="girddanhsach_phonghoc"></div>
				</div>
			</div>
		</div>




		<!-- Số tiết trong buổi của mỗi lớp-->
		<div class="card" id="formdanhsach_sotiettrongbuoi" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
										<div class="row">
						<div class="col-md-2">
							<select class="form-control input-sm" id="lopsotietbuoi" multiple="multiple"></select>
						</div>
						<div class="col-md-2">
							<select class="form-control input-sm" id="chonbuoisotietbuoi">
								<option selected="">Chọn buổi
								</option><option value="0">Buổi sáng
								</option><option value="1">Buổi chiều
								</option></select>
							</fieldset>
						</div>
						<div class="col-md-2">
							<fieldset class="form-group position-relative">
								<input type="number" class="form-control input-sm" id="sotietsttrongbuoi" placeholder="Số tiết">
							</fieldset>
						</div>
						<div class="col-md-3">
							<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="capnhatsotietbuoi">Cập nhật</button>
						</div>
					</div>

					<!-- <div id="capnhat_sotiettrongbuoi"></div>
						<input type="text" id="sotiettrongbuoiid" class="form-control input-sm" hidden> -->
						<hr>
						<div id="girddanhsach_sotiettrongbuoi"></div>
					</div>
				</div>
			</div>





			<!-- Số tiết ở mỗi môn của mỗi lớp-->
			<div class="card" id="formdanhsach_sotietmoimon" style="display: none">
				<div class="card-header">
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements" style="padding-top: 10px">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
							<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="card-body">
																<div class="row">
						<div class="col-md-4">
							<fieldset class="form-group position-relative">
								<select class="form-control input-sm" id="loaitruongsotietmoimon">
									<option selected="">Chọn loại trường
									</option><option value="1">Tiểu học
									</option><option value="2">THCS
									</option><option value="3">THPT
									</option></select>
								</fieldset>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="khoitaodulieusotietmoimon">Khởi tạo dữ liệu mẫu</button>
							</div>
						</div>
						
						<div id="capnhat_sotietmoimon"></div>
						<input type="text" id="sotietmoimonid" class="form-control input-sm" hidden>
						<hr>
						<div id="girddanhsach_sotietmoimon"></div>
					</div>
				</div>
			</div>






				<!-- Phân công giáo viên dạy-->
				<div class="card" id="formdanhsach_phanconggvday" style="display: none">
					<div class="card-header">
						<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements" style="padding-top: 10px">
							<ul class="list-inline mb-0">
								<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="card-content collapse show">
						<div class="card-body">
							<dir class="row" style="padding: 0;margin: 0">
								<section class="col-md-12 col-xs-12">
									<section>
										<h3>KHAI BÁO DỮ LIỆU XẾP THỜI KHÓA BIỂU</h3>
									</section>
									<section>
										{{-- <button class="btn btn-sm btn-primary">Cập nhật phân công chuyên môn</button> --}}
										<!-- 									<button id="btnTaipccm" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Tải PCCCM</button> -->
										{{-- <button class="btn btn-sm btn-primary">Nhận PCCM từ TKB</button> --}}
										{{-- <select></select> --}}
									</section>
									<section style="margin-top: 10px;">
										<p style="font-weight: bold; color:red;"><i style="cursor: pointer;" id="showchitietchuapc"
											class="fa fa-arrow-circle-right" aria-hidden="true"></i> Tổng số tiết chưa được phân công giáo viên
											dạy: <span id="tongsotietcp"></span></p>
											<section id="tableChuaphancong" class="hidden" style="overflow: scroll; height: 300px;">
												<table class="table table-bordered table-light">
													<thead class="thead-default">
														<tr>
															<th rowspan="2">STT</th>
															<th rowspan="2">Lớp</th>
															<th style="text-align: center;" id="thMonhoc">Môn học</th>
														</tr>
														<tr id="trDanhsachmonhoc">

														</tr>
													</thead>
													<tbody id="bangSotietchuaphancongs">

													</tbody>
												</table>
											</section>
										</section>
										<section>
											<table class="table table-bordered table-light">
												<thead class="thead-default">
													<tr>
														<th rowspan="2">STT</th>
														<th>Họ và tên</th>
														<th>Bí danh</th>
														<th rowspan="2">Số tiết</th>
														<th rowspan="2">Chuyên môn</th>
														<th rowspan="2">PCCM</th>
														<th rowspan="2">Xóa</th>
													</tr>
													<tr>
														<th><input id="timkiemhovaten" class="input-sm form-control" type="text" /></th>
														<th><input id="timkiemBidanh" class="input-sm form-control" type="text" /></th>
													</tr>
												</thead>
												<tbody id="bangdanhsachphancong">

												</tbody>
											</table>
										</section>
									</section>

									<!-- Modal -->
									<div class="modal fade" id="modelPhancong" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
									aria-hidden="true">
									<div class="modal-dialog modal-xl" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Phân công chuyên môn</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="container-fluid">
													<div class="row">
														<section class="col-md-12">
															<section>
																<p id="lblPhacong">Phân công chuyên môn cho giáo viên</p>
																<h5 id="lblTongsotiet">Tổng số tiết:</h5>
															</section>

														</section>
														<section class="col-md-3 col-xl-3" style="overflow-y: scroll; height: 500px;">
															<table class="table table-bordered table-light ">
																<thead class="thead-inverse">
																	<tr>
																		<!-- <th>STT</th> -->
																		<th>Môn</th>										
																		<th>Chọn</th>
																		<th style="width: 10%;">Lớp dạy</th>
																		<th>Số tiết</th>
																	</tr>
																</thead>
																<tbody id="bangdanhsachmonpc">

																</tbody>
															</table>
														</section>
														<section class="col-md-9 col-xl-9" style="overflow-y: scroll; height: 500px;">
															<table class="table table-bordered table-light">
																<thead class="thead-inverse">
																	<tr>
																		<th>STT</th>
																		<th>Lớp</th>
																		<th>Chọn tất cả <input type="checkbox" id="chontatcaphancongmon" /></th>
																		<th>Số tiết của môn</th>
																		<th>Số tiết chưa phân công</th>
																		<th>Giáo viên được phân công</th>
																		<th>Xóa</th>
																	</tr>
																</thead>
																<tbody id="bangdanhsachphancongchomonhoc">

																</tbody>
															</table>
														</section>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<section class="col-md-3">
													<button id="btnXoatatcaPCCMtaimon" data-id="" data-giaovien="" class="btn btn-sm btn-danger">Xóa
														tất cả phân công
													chuyên môn</button>
												</section>
												<section class="col-md-9" style="text-align: right;">
													<button type="button" class="btn btn-sm btn-primary" id="btncapnhatpccmgiaovien">Cập nhật PCCM
														với giáo
													viên:</button>
													{{-- <button type="button" class="btn btn-sm btn-danger" id="btncapnhatpccmtatcagiaovien">Cập nhật
														PCCM tất
														cả
													giáo viên</button> --}}
													<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Đóng</button>
												</section>
											</div>
										</div>
									</div>
								</div>
							</dir>
						</div>
					</div>
				</div>












		</dir>
	</dir>



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
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" id="loading" role="progressbar" aria-valuenow="80" aria-valuemin="80" aria-valuemax="100" style="width:0%"></div>
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
	/*$("#importfile").on("click", function() {
		$("#upload").trigger('click');
	});*/
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
          			str = str.replace(/[!@#$%^&*-;()]/g, "");
          			str = str.replace(/\s+/g, '');
          			str = str.trim();

          			let key = str;
          			obj[key] = element[property]; 
            	// tao object moi chua key  da duoc thay doi cung value mac dinh
            }
            arrResult.push(obj);
        });

					if(arrResult != ""){
						importexcel(arrResult);
					}
				// console.log(JSON.parse(XL_row_object));
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
			var lop = value.Lophocngangcachboidau;
			var loparray = lop.split(";");
			var tcm = value.Tochuyenmon;
			if(tcm != undefined){
				var tochuyenmon = value.Tochuyenmon;
			}else{
				var tochuyenmon = null;
			}
			return {
				tenlop: loparray,
				tengv: value.Hovatengiaovien,
				monhoc: value.Monhoc,
				tochuyenmon:tochuyenmon,
			}
		});
		axios.post('importexcelbangphancongtkb',data).then(function (response) {
			var data =  response.data;
			var status = response.status;
			if(status == 200){
				axios.post('importexcelsotiettrongbuoi',data).then(function (response) {
					var data =  response.data;
				});
			}
		});

	}










	$("#importexcel").change(function () {
		if ($(this).is(":checked")) {
			$("#importdata").prop("checked", false);
			document.getElementById("nhapdulieuhethong").style.display = "none";
			document.getElementById("khaibao").style.display = "none";
			document.getElementById("btnimportexcel").style.display = "block";
			document.getElementById("formnhapdanhsachgv").style.display = "none";
			document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
			document.getElementById("formnhapdanhsachlophoc").style.display = "none";
			document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
			document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
			document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
			document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
			document.getElementById("formdanhsach_monhoc").style.display = "none";
			document.getElementById("formdanhsach_lophoc").style.display = "none";
			document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
			document.getElementById("formdanhsach_phonghoc").style.display = "none";
			document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
			document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
			document.getElementById("formdanhsach_phanconggvday").style.display = "none";
			clearcheckbox();
		}
	});

	$('#btnimportexcel').click(function () {
		document.getElementById("formimportexcel").style.display = "block";
	});



	$("#importdata").change(function () {
		if ($(this).is(":checked")) {
			$("#importexcel").prop("checked", false);
			document.getElementById("nhapdulieuhethong").style.display = "block";
			document.getElementById("khaibao").style.display = "block";
			document.getElementById("btnimportexcel").style.display = "none";
			document.getElementById("formimportexcel").style.display = "none";
			clearcheckbox();
		}
	});

	function clearcheckbox(){
		$("#nhapdanhsachgv").prop( "checked", false);
		$("#nhapdanhsachmonhoc").prop( "checked", false);
		$("#nhapdanhsachlophoc").prop( "checked", false);
		$("#nhapdanhsachtochuyenmon").prop( "checked", false);
		$("#danhsachgvcuatochuyenmon").prop( "checked", false);
		$("#nhapdanhsachphonghocbomon").prop( "checked", false);
		$("#chongvthamgiagiangday").prop( "checked", false);
		$("#chon_monhoc").prop( "checked", false);
		$("#chon_lophoc").prop( "checked", false);
		$("#chon_tochuyenmon").prop( "checked", false);
		$("#chon_phonghoc").prop( "checked", false);
		$("#chon_buoihoc").prop( "checked", false);
		$("#sotiet_trongbuoi").prop( "checked", false);
		$("#sotiet_moimon").prop( "checked", false);
		$("#phancong_giaovienday").prop( "checked", false);
	}


//nhập dữ liệu hệ thống
	//nhập danh sach giao vien
	$("#nhapdanhsachgv").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "block";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		nhapdanhsachgv();
	});

	//nhập danh sach mon hoc
	$("#nhapdanhsachmonhoc").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "block";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		nhapdanhsachmonhoc();
	});
	//nhập danh sach lop hoc
	$("#nhapdanhsachlophoc").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "block";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		nhapdanhsachlophoc();
	});
	//nhập danh sach to chuyen mon
	$("#nhapdanhsachtochuyenmon").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "block";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		nhapdanhsachtochuyenmon();
	});

	//nhập danh gv cua to chuyen mon
	$("#danhsachgvcuatochuyenmon").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "block";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		locgvcuamatochuyenmon();
	});


	//nhập danh sách phòng học bộ môn
	$("#nhapdanhsachphonghocbomon").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "block";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		nhapdanhsachphonghocbomon();
	});

	//chọn môn học
	$("#chon_monhoc").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "block";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		chon_monhoc();
	});
	//chọn lớp học
	$("#chon_lophoc").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "block";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		chon_lophoc();
	});

	//chọn tổ/nhóm chuyên môn
	$("#chon_tochuyenmon").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "block";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		chon_tochuyenmon();
	});

	//chọn phòng học bộ môn
	$("#chon_phonghoc").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "block";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		chon_phonghoc();
	});



	//chọn gv tham gia giảng dạy
	$("#chongvthamgiagiangday").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "block";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		loaddatadanhsachgvthamgiagiangday();
	});




		//số tiết trong buổi của mỗi lớp
		$("#sotiet_trongbuoi").change(function () {
			document.getElementById("formnhapdanhsachgv").style.display = "none";
			document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
			document.getElementById("formnhapdanhsachlophoc").style.display = "none";
			document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
			document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
			document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
			document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
			document.getElementById("formdanhsach_monhoc").style.display = "none";
			document.getElementById("formdanhsach_lophoc").style.display = "none";
			document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
			document.getElementById("formdanhsach_phonghoc").style.display = "none";
			document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "block";
			document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
			document.getElementById("formdanhsach_phanconggvday").style.display = "none";
			sotiet_trongbuoi();
		});
	//số tiết ở mỗi môn của mỗi mon
	$("#sotiet_moimon").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "block";
		document.getElementById("formdanhsach_phanconggvday").style.display = "none";
		sotiet_moimon();
	});
	//phân công giáo viên dạy
	$("#phancong_giaovienday").change(function () {
		document.getElementById("formnhapdanhsachgv").style.display = "none";
		document.getElementById("formnhapdanhsachmonhoc").style.display = "none";
		document.getElementById("formnhapdanhsachlophoc").style.display = "none";
		document.getElementById("formdanhsachgvtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachtochuyenmon").style.display = "none";
		document.getElementById("formnhapdanhsachphonghocbomon").style.display = "none";
		document.getElementById("formdanhsachgvthamgiagiangday").style.display = "none";
		document.getElementById("formdanhsach_monhoc").style.display = "none";
		document.getElementById("formdanhsach_lophoc").style.display = "none";
		document.getElementById("formdanhsach_tochuyenmon").style.display = "none";
		document.getElementById("formdanhsach_phonghoc").style.display = "none";
		document.getElementById("formdanhsach_sotiettrongbuoi").style.display = "none";
		document.getElementById("formdanhsach_sotietmoimon").style.display = "none";
		document.getElementById("formdanhsach_phanconggvday").style.display = "block";
		// phancong_giaovienday();
	});



</script>



<script type="text/javascript" src="js/khaibao/nhapdanhsachgv.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachmonhoc.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachlophoc.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachtochuyenmon.js"></script>
<script type="text/javascript" src="js/khaibao/danhsachgvcuatochuyenmon.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachphonghocbomon.js"></script>
<script type="text/javascript" src="js/khaibao/chongvthamgiagiangday.js"></script>
<script type="text/javascript" src="js/khaibao/chonmonhoc.js"></script>
<script type="text/javascript" src="js/khaibao/chonlophoc.js"></script>
<script type="text/javascript" src="js/khaibao/chontochuyenmon.js"></script>
<script type="text/javascript" src="js/khaibao/chonphonghoc.js"></script>
<script type="text/javascript" src="js/khaibao/sotiettrongbuoi.js"></script>
<script type="text/javascript" src="js/khaibao/sotietmoimon.js"></script>
<script type="module" src="js/khaibao/js\pccm\index.js"></script>
<script type="text/javascript" src='dx/js/jszip/dist/xlsx.full.min.js'></script>



<!-- 
<script type="text/javascript" src="js/khaibao/nhapdanhsachgv.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachmonhoc.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachlophoc.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachtochuyenmon.js"></script>
<script type="text/javascript" src="js/khaibao/danhsachgvcuatochuyenmon.js"></script>
<script type="text/javascript" src="js/khaibao/nhapdanhsachphonghocbomon.js"></script>
<script type="text/javascript" src="js/khaibao/chongvthamgiagiangday.js"></script>
<script type="text/javascript" src="js/khaibao/chonmonhoc.js"></script>
<script type="text/javascript" src="js/khaibao/chonlophoc.js"></script>
<script type="text/javascript" src="js/khaibao/chontochuyenmon.js"></script>
<script type="text/javascript" src="js/khaibao/chonphonghoc.js"></script>
<script type="text/javascript" src="js/khaibao/chonbuoihoc.js"></script>
<script type="text/javascript" src='dx/js/jszip/dist/xlsx.full.min.js'></script> -->


@endsection






