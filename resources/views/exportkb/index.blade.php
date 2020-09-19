@extends('master')
@section('title','Thiết lập CSDL')
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
		<div class="row">
			<div class="col-md-3">
				<div class="form-group row">
					<label class="col-md-6 label-control" for="tkbNo" style="text-align: right;">Thời khóa biểu
						sô:</label>
					<div class="col-md-5" style="padding-left: 0">
						<input type="text" id="tkbNo" class="form-control border-primary input-sm" name="tkbNo">
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group row">
					<label class="col-md-6 label-control" for="dateprocess" style="text-align: right;">Thực hiện từ
						ngày:</label>
					<div class="col-md-6" style="padding-left: 0">
						<input type="text" id="dateprocess" class="form-control border-primary input-sm"
							name="dateprocess">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-content collpase show">
		<div class="card-body">
			<form class="form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-7">

							<div class="card box-shadow-0 border-info bg-transparent" id="khaibao">
								<div class="card-header bg-transparent" style="padding: 10px">
									<div class="form-group">
										<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
											<button type="button" id="btnDownloadTKB" class="btn btn-success">Tải
												thời khóa biểu</button>
											<button type="button" class="btn btn-danger">Gửi tkb cho GV qua
												email</button>
											<button type="button" class="btn btn-primary"> Lưu tkb trực tuyến</button>
											<button type="button" class="btn btn-info"> Xuất tkb để tra cứu</button>
										</div>

									</div>
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
										<hr>
										<div class="form-group">
											<label for="projectinput1">Sheet: TKB trường</label>
											<div class="row" style="padding-left: 10px;padding-right: 10px">
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBSchollMVDuo">
														Môn, GV (riêng 2 cột)
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value=""
															id="chkTKBSchollMV">
														Môn, GV (trong 1 cột)
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value=""
															id="chkTKBSchollMVDuoLine">
														Môn/GV (2 dòng)
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value=""
															id="chkTKBSchollM">
														Môn
													</label>
												</fieldset>
											</div>
											<hr>
											<label for="projectinput1">Sheet: TKB lớp</label>
											<div class="row" style="padding-left: 10px;padding-right: 10px">

												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBLopMGV">
														Môn, GV
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBLopM">
														Môn
													</label>
												</fieldset>
											</div>

											<hr>
											<label for="projectinput1">Sheet: TKB GV</label>
											<div class="row" style="padding-left: 10px;padding-right: 10px">

												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>TKB GV1:</label>
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBGV1ML">
														Môn, lớp
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBGV1M">
														Môn
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBGV1L">
														Lớp
													</label>
												</fieldset>
												<div class="break"></div>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>TKB GV2:</label>
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBGV2ML">
														Môn, lớp
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBGV2M">
														Môn
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBGV2L">
														Lớp
													</label>
												</fieldset>
												<div class="break"></div>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>TKB GV3:</label>
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBGV3ML">
														Môn, lớp
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBGV3M">
														Môn
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="chkTKBGV3L">
														Lớp
													</label>
												</fieldset>
											</div>
											<hr>
											<label for="projectinput1">Sheet: TKB phòng bộ môn</label>
											<div class="row" style="padding-left: 10px;padding-right: 10px">

												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBPBMML">
														Môn, lớp
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value=""
															id="chkTKBPBMMGV">
														Môn, GV
													</label>
												</fieldset>
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value=""
															id="chkTKBPBMGVL">
														GV, lớp
													</label>
												</fieldset>
											</div>
											<hr>
											<label for="projectinput1">Sheet: TKB tổ nhóm</label>
											<div class="row" style="padding-left: 10px;padding-right: 10px">

												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input checked type="checkbox" name="checkbox" value=""
															id="chkTKBTNML">
														Môn, lớp
													</label>
												</fieldset>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="card box-shadow-0 border-info bg-transparent" id="khaibao">
								<div class="card-header bg-transparent" style="padding: 10px">
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
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xl-6"><b>Chủ đề Email</b></div>
											<div class="col-md-6 col-sm-6 col-xl-6 justify-content-end d-flex">Email gửi
												TKB: Email của hệ thống
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<textarea id="emailTitle"
													placeholder="Thời khóa biểu thực hiện từ ngày....">

																																																				</textarea>
											</div>
											<div class="col-md-12 col-sm-12 col-xl-12">
												<b>Nội dung Emall</b>
												<textarea id="emailContent"></textarea>
											</div>
											<div class="col-md-7 col-sm-7 col-xl-7">
												<label><input id="chkSelectTeacher" type="checkbox" />Chọn giáo viên gửi
													email</label>

											</div>
											<div class="col-md-5 col-sm-5 col-xl-5 justify-content-end d-flex">
												<button id="btnSend" class="btn btn-sm btn-info">Sử dụng email riêng để
													gửi</button>
											</div>
											<div class="col-md-12 col-sm-12 col-xl-12" id="listTeacher">
												<table class="table table-bordered">
													<thead class="">
														<tr>
															<th rowspan="2">STT</th>
															<th rowspan="2"><input type="checkbox" /></th>
															<th><label>Chọn giáo
																	viên</label></th>
															<th rowspan="2">Email</th>
														</tr>
														<tr>
															<th><input type="text" /></th>
														</tr>
													</thead>
													<tbody id="listTeacherBody">

													</tbody>
												</table>
											</div>
										</div>
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
<script type="module" src="{{asset('js\xuattkb\xuattkb.js')}}"></script>
<style>
	.break {
		width: 100%;
	}

	textarea {
		width: 100%;
	}

	#listTeacher {
		margin-top: 5px;
	}
</style>
@endsection