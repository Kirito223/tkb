@extends('master')
@section('title','Ràng buộc')
@section('content')

<dir class="row" style="padding: 0;margin: 0">
	<dir class="col-md-3" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">Khai báo ràng buộc</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 10px">
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
									<hr>
									<div class="card box-shadow-0 border-info bg-transparent" id="rangbuoc">
										<div class="card-content collapse show" style="">
											<div class="card-body">
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="rangbuoctietcodinh">
														Ràng buộc tiết cố định
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="tiethopcuato">
														Tiết họp của tổ(nhóm)
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="dangkybuoitietnghicuagv">
														Đăng ký buổi/tiết nghỉ của GV
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="tietgiaovienbuocphaico">
														Tiết giáo viên buộc phải có
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="rangbuocsotiet5sang">
														Ràng buộc số tiết 5 sáng (tiết 1 chiều)
													</label>
												</fieldset>
												<hr>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="rangbuoctiettranhcuamon">
														Ràng buộc tiết tránh của môn
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="tranhhaimonxepcungbuoi">
														Tránh hai môn xếp cùng buổi
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="captietbuocphaixepliennhau">
														Cặp tiết buộc phải xếp liền nhau
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="sotiettoidatrongbuoicuamon">
														Số tiết tối đa trong buổi của môn
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="sotiettoidatrongngaycuamon">
														Số tiết tối đa trong ngày của môn
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="rangbuocthututiet">
														Ràng buộc thứ tự tiết
													</label>
												</fieldset>
												<fieldset class="radio">
													<label>
														<input type="radio" name="radio" value="" id="rangbuoctietnghilop">
														Ràng buộc tiết nghỉ lớp
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
	<!-- rang buoc thu tu tiet	 -->
		<div class="card" id="formthututiet" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 20px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<div class="col-md-4">
						<div class="form-group">
							<label for="projectinput1">Khối : </label>
							<div id="thututietkhoi"></div>
						</div>
					</div>

					<div id="girdthututiet"></div>
				</div>
			</div>
		</div> 
		<!-- dang ky tiet nghi lop	 -->
		<div class="card" id="formtietnghilop" style="display: none">
			<div class="card-header">
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="padding-top: 20px">
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
							<select class="form-control input-sm" id="tietnghilopds" multiple="multiple"></select>
						</div>
						<div class="col-md-2">
							<select class="form-control input-sm" id="chonbuoitietnghilop">
								<option selected="">Chọn buổi
								</option><option value="0">Buổi sáng
								</option><option value="1">Buổi chiều
								</option></select>
							</div>
							<div class="col-md-2">
								<select class="form-control input-sm" id="chonthutietnghilop">
									<option selected="">Chọn thứ</option>
									<option value="2">Thứ 2</option>
									<option value="3">Thứ 3</option>
									<option value="4">Thứ 4</option>
									<option value="5">Thứ 5</option>
									<option value="6">Thứ 6</option>
									<option value="7">Thứ 7</option>
								</select>
							</div>
							<div class="col-md-2">
								<select class="form-control input-sm" id="chontiettietnghilop">
									<option selected="">Chọn tiết</option>
									<option value="1">Tiết 1</option>
									<option value="2">Tiết 2</option>
									<option value="3">Tiết 3</option>
									<option value="4">Tiết 4</option>
									<option value="5">Tiết 5</option>
								</select>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="capnhattietnghilop">Cập nhật</button>
							</div>
						</div>
						<div id="girdtietnghilop"></div>
					</div>
				</div>
			</div> 

		<!-- ràng buộc tiết cố định -->
		<div class="card" id="formrangbuoctietcodinh" style="display: none">
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
						<!-- <div class="col-md-2">
							<fieldset class="radio">
								<label>
									<input type="radio" name="radio" value="" id="rangbuoctietcodinhtiettrong">
									Tiết trống
								</label>
							</fieldset>						
						</div> -->
						<!-- <div class="col-md-2">
							<fieldset class="radio">
								<label>
									<input type="radio" name="radio" value="" id="rangbuoctietcodinhtiethoc">
									Tiết học
								</label>
							</fieldset>						
						</div> -->
					</div>

					<div class="row">
						<div class="col-md-2">
							<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="btnthemmoitiethoc" >Thêm mới</button>
							<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="btnthemmoitiettrong" >Thêm mới</button>
						</div>
					</div>

					<!-- form thêm mới ràng buộc tiết cố định loại tiết trống -->
					<!-- <form class="form" id="formthemmoirangbuoctietcodinhtiettrong" style="display: none;">
						<div class="form-body">
							<h6 class="form-section">Thêm & sửa ràng buộc tiết cố định tiết trống</h6>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="projectinput1">Thứ</label>
										<select class="select2 form-control">
											<option value="CA" />California
											<option value="NV" />Nevada
											<option value="OR" />Oregon
											<option value="WA" />Washington
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="projectinput2">Tiết thứ</label>
										<select class="select2 form-control">
											<option value="CA" />California
											<option value="NV" />Nevada
											<option value="OR" />Oregon
											<option value="WA" />Washington
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="projectinput3">Mức ràng buộc</label>
										<select class="select2 form-control">
											<option value="CA" />California
											<option value="NV" />Nevada
											<option value="OR" />Oregon
											<option value="WA" />Washington
										</select>
									</div>
								</div>
								<div class="col-md-3">
									
								</div>
							</div>
						</div>
						<div class="form-actions right">
							<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="btnthemtiettrong" >Lưu</button>
							<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="btncapnhattiettrong" hidden>Lưu</button>		
							<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" id="btnhuytiettrong" >Hủy</button>
						</div>						
					</form> -->

					
					<hr>
					<div id="girdrangbuoctietcodinh"></div>
					
				</div>
			</div>

		</div>

		<!-- tiết họp của tổ(nhóm)	 -->
		<div class="card" id="formtiethopcuato" style="display: none">
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
					<div id="girdtiethopcuato"></div>
				</div>
			</div>
		</div> 

		<!-- đăng ký buổi/tiết nghỉ của gv	 -->
		<div class="card" id="formdangkybuoitietnghicuagv" style="display: none">
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
										<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" id="dkbuoinghiall">Đăng ký buổi nghỉ</button>					
					<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="dktietnghiall">Đăng ký tiết nghỉ</button>
					<div id="girddangkybuoitietnghicuagv"></div>
				</div>
			</div>
		</div>

		<!-- tiết gv buộc phải có	 -->
		<div class="card" id="formtietgvbuocphaico" style="display: none">
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
					<div id="girdtietgiaovienbuocphaico"></div>
				</div>
			</div>
		</div>

		<!-- ràng buộc số tiết 5 sáng(tiết 1 chiều)	 -->
		<div class="card" id="formrangbuocsotiet5sang" style="display: none">
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
					<div id="girdrangbuocsotiet5sang"></div>
				</div>
			</div>
		</div>

		<!-- Ràng buộc tiết tránh của môn	 -->
		<div class="card" id="formrangbuoctiettranh" style="display: none">
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
					<div id="girdrangbuoctiettranh"></div>
				</div>
			</div>
		</div>
		<!-- chọn tiêt -->
		<div class="modal fade text-left show" id="chontiet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div id="tiettranhcuamon"></div>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">	
						<div id="girdchontiet"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="luuchontiet">Lưu</button>
						<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>

		<!-- chọn lop sang -->
		<div class="modal fade text-left show" id="chonlopsang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div id="lopstranhcuamon"></div>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">	
						<table class="table table-bordered table-light" id="tablelopsang">
							<thead class="thead-inverse">
								<tr id="headTable"></tr>
							</thead>
							<tbody id="lophocsang"></tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="luuchonlops">Lưu</button>
						<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>

		<!-- chọn lop chieu -->
		<div class="modal fade text-left show" id="chonlopchieu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div id="lopctranhcuamon"></div>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">	
						<table class="table table-bordered table-light" id="tablelopchieu">
							<thead class="thead-inverse">
								<tr id="headTablechieu"></tr>
							</thead>
							<tbody id="lophocchieu"></tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="luuchonlopc">Lưu</button>
						<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Ràng buộc tránh 2 môn xếp cùng buổi	 -->
		<div class="card" id="formrangbuoctranh2monxepcungbuoi" style="display: none">
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
					<div id="girdrangbuoctranh2monxepcungbuoi"></div>
				</div>
			</div>
		</div>

		<!-- chọn môn -->
		<div class="modal fade text-left show" id="chonmontranh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div id="montranh"></div>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">	
						<div id="girdchonmon"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="luuchonmon">Lưu</button>
						<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Ràng buộc cặp tiết xếp liền nhau-->
		<div class="card" id="formrangbuoccaptietxepliennhau" style="display: none">
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
					<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="addcaptiet" >Tạo mới</button>
					<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" id="huycaptiet" hidden>Hủy</button>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label for="projectinput1">Môn:</label>
								<select type="text" id="mon" class="form-control input-sm" required="true"></select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="projectinput1">Phạm vi áp dụng:</label>
								<select type="text" id="phamviapdung" class="form-control input-sm">
									<option value="0">Toàn trường</option>
									<option value="1">Toàn khối</option>
									<option value="2">Chỉ áp dụng lớp đã chọn</option>
								</select>
								<select type="text" id="lop" class="form-control input-sm" hidden></select>
								<input type="text" class="form-control" id="id" hidden>
								<input type="text" class="form-control" id="khoi" hidden>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="projectinput1">Tiết thứ (của môn học):</label>
								<select type="text" id="tietthu" class="form-control input-sm">
									<option value="0">Cặp tiết bất kì</option>
									<option value="1">Tiết 1,2</option>
									<option value="2">Tiết 2,3</option>
									<option value="3">Tiết 3,4</option>
									<option value="4">Tiết 4,5</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="projectinput1">Mức ràng buộc:</label>
								<select type="text" id="mucrangbuoc" class="form-control input-sm">
									<option value="0">Mức 0</option>
									<option value="1">Mức 1</option>
									<option value="2">Mức 2</option>
									<option value="3">Mức 3</option>
								</select>
							</div>
						</div>						
					</div>
					<br>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="projectinput1">Tránh cặp tiết trong buổi sáng:</label>
								<select type="text" id="tranhtietsang" class="form-control input-sm">
									<option value="0">Không tránh cặp tiết nào</option>
									<option value="1">Tiết 1,2</option>
									<option value="2">Tiết 2,3</option>
									<option value="3">Tiết 3,4</option>
									<option value="4">Tiết 4,5</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="projectinput1">Tránh cặp tiết trong buổi chiều:</label>
								<select type="text" id="tranhtietchieu" class="form-control input-sm">
									<option value="0">Không tránh cặp tiết nào</option>
									<option value="1">Tiết 1,2</option>
									<option value="2">Tiết 2,3</option>
									<option value="3">Tiết 3,4</option>
									<option value="4">Tiết 4,5</option>
								</select>
							</div>
						</div>					
					</div>
					<br>
					<div class="form-group row">
						<div class="col-md-2">
							<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="updatecaptiet" >Cập nhật</button>
						</div>
						<label class="col-md-10 label-control" style="text-align:left;color: #f44336;">Lưu ý: Mức ràng buộc càng cao thì ràng buộc càng được ưu tiên khi xếp TKB</label>
					</div>

					
					<br>
					<div class="row">
						<div class="col-md-12">
							<div id="girdrangbuoccaptietxepliennhau"></div>
						</div>
					</div>					
				</div>
			</div>
		</div>


		<!-- a đức -->
		<!-- SO tiet toi da ngay -->
		<div class="card" id="formsotiettoidatrongngay" style="display: none">
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
							<section style="margin-top: 10px;">
								<section>
									<span>Chọn môn học:</span>
									<select id="chonmonhocNgay">

									</select>
									<span>số tiết tối đa trong mỗi buổi học:</span>
									<input id="sotiettoidaNgay" type="number" />
									<span><input id="apdungtoantruongNgay" type="checkbox" />Áp dụng toàn trường</span>
									<button id="dongy" class="btn btn-primary btn-sm">Đồng ý</button>
								</section>

								<p style="font-weight: bold; color:red;"><i style="cursor: pointer;" id="showLopApDungNgay"
									class="fas fa-arrow-circle-right" aria-hidden="true"></i> Chọn khối, lớp áp dụng:<span
									id="chonkhoilopNgay"></span></p>
									<section id="tableChuaphancong" class="hidden" style="overflow: scroll; height: 300px;">
										<table class="table table-bordered table-light">
											<thead class="thead-default">
												<tr id="headDanhSachLopNgay"></tr>
											</thead>
											<tbody id="bodyDanhSachLopNgay">

											</tbody>
										</table>
									</section>
								</section>
								<section>
									<section>
										<button class="btn btn-sm btn-danger" id="capnhat">Cập nhật</button>
										<span style="color: brown"><b>Lưu ý:</b> Với môn học có tiết đôi (cặp tiết buộc phải liền nhau), nếu các tiết còn lại không
										được phép liền nhau thì số tiết tối đa trong buổi là 1</span>
									</section>
									<section style="overflow: scroll">
										<table class="table table-bordered table-light">
											<thead class="thead-default">
												<tr>
													<th rowspan="2">STT</th>
													<th rowspan="2">Tên lớp học</th>
													<th id="tongsotiet">Số tiết tối đa của môn học trong ngày (tổng cả sáng và chiều)
													</th>
												</tr>
												<tr id="monhoc">
												</tr>
											</thead>
											<tbody id="tableDanhsachPhanTiet">
											</tbody>
										</table>
									</section>
								</section>
							</section>
						</dir>
					</div>
				</div>
			</div> 


			<div class="card" id="formsotiettoidatrongmoibuoi" style="display: none">
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
								<section style="margin-top: 10px;">
									<section>
										<span>Chọn môn học:</span>
										<select id="chonmonhocBuoi">

										</select>
										<span>số tiết tối đa trong mỗi buổi học:</span>
										<input id="sotiettoidaBuoi" type="number" />
										<span><input id="apdungtoantruongBuoi" type="checkbox" />Áp dụng toàn trường</span>
										<button id="dongyBuoi" class="btn btn-primary btn-sm">Đồng ý</button>
									</section>

									<p style="font-weight: bold; color:red;"><i style="cursor: pointer;" id="showLopApDungBuoi"
										class="fas fa-arrow-circle-right" aria-hidden="true"></i> Chọn khối, lớp áp dụng:<span
										id="chonkhoilop"></span></p>
										<section id="tableChuaphancongBuoi" class="hidden" style="overflow: scroll; height: 300px;">
											<table class="table table-bordered table-light">
												<thead class="thead-default">
													<tr id="headDanhSachLopBuoi"></tr>
												</thead>
												<tbody id="bodyDanhSachLopBuoi">

												</tbody>
											</table>
										</section>
									</section>
									<section>
										<section>
											<button class="btn btn-sm btn-danger" id="capnhatBuoi">Cập nhật</button>
											<span style="color: brown"><b>Lưu ý:</b> Với môn học có tiết đôi (cặp tiết buộc phải liền nhau), nếu các
												tiết còn lại không
											được phép liền nhau thì số tiết tối đa trong buổi là 1</span>
										</section>
										<section style="overflow: scroll">
											<table class="table table-bordered table-light">
												<thead class="thead-default">
													<tr>
														<th rowspan="2">STT</th>
														<th rowspan="2">Tên lớp học</th>
														<th id="tongsotietBuoi">Số tiết tối đa của môn học trong ngày (tổng cả sáng và chiều)
														</th>

													</tr>
													<tr id="monhocBuoi">

													</tr>
												</thead>
												<tbody id="tableDanhsachPhanTietBuoi">

												</tbody>
											</table>
										</section>
									</section>
								</section>
							</dir>
						</div>
					</div>
				</div> 



			


			<!-- modal thêm tiết học -->
			<div class="modal fade text-left" id="modaltiethoc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" style="display: none;" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-success white">
							<h4 class="modal-title white" id="myModalLabel16">Thêm ràng buộc tiết cố định tiết học</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongtiethoc">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- form thêm mới ràng buộc tiết cố định loại tiết học-->
							<form class="form" id="formthemmoirangbuoctietcodinhtiethoc" >
								<div class="form-body">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput1">Môn</label>
												<select class="select2 form-control" id="monSelect2">
													<option value="" />
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput2">Buổi</label>
												<select class="select2 form-control" id="buoiSelect2">
													<option value="0" />Sáng
													<option value="1" />Chiều
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput2">Thứ</label>
												<select class="select2 form-control" id="thuSelect2">
													<option value="2" />Thứ 2
													<option value="3" />Thứ 3
													<option value="4" />Thứ 4
													<option value="5" />Thứ 5
													<option value="6" />Thứ 6
													<option value="7" />Thứ 7
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput3">Tiết thứ</label>
												<select class="select2 form-control" id="tietthuSelect2">
													<option value="1" />1
													<option value="2" />2
													<option value="3" />3
													<option value="4" />4
													<option value="5" />5
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput4">Mức ràng buộc</label>
												<select class="select2 form-control" id="mucrangbuocSelect2">
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<fieldset class="radio">
												<label>
													<input type="radio" name="radio" value="1" id="apdungtoantruongrbtcd">
													Áp dụng toàn trường
												</label>
											</fieldset>
											<fieldset class="radio">
												<label>
													<input type="radio" name="radio" value="" id="chonkhoilopapdungrbtcd">
													Chọn khối, lớp áp dụng
												</label>
											</fieldset>
										</div>
									</div>
									<hr>
									<input type="text" id="apdungtoantruongid" class="form-control input-sm" hidden>
									<div class="row" id="formchonkhoilopapdung" style="display: none;">
										<table class="table table-bordered table-light" id="table">
											<thead class="thead-inverse">
												<tr id="headTablerbtcd"></tr>
											</thead>
											<tbody id="lophocsangrbtcd"></tbody>
										</table>
									</div>
								</div>							
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuytiethoc">Huỷ</button>
							<button type="button" class="btn btn-outline-danger" id="btnthemtiethoc">Lưu</button>
						</div>
					</div>
				</div>
			</div>


			<!-- modal sửa tiết học -->
			<div class="modal fade text-left" id="modalsuatiethoc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" style="display: none;" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-success white">
							<h4 class="modal-title white" id="myModalLabel16">Sửa ràng buộc tiết cố định tiết học</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongsuatiethoc">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- form thêm mới ràng buộc tiết cố định loại tiết học-->
							<form class="form" id="formsuarangbuoctietcodinhtiethoc" >
								<div class="form-body">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput1">Môn</label>
												<select class="select2 form-control" id="monSelect2s">
													<option value="" />
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput2">Buổi</label>
												<select class="select2 form-control" id="buoiSelect2s">
													<option value="0" />Sáng
													<option value="1" />Chiều
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput2">Thứ</label>
												<select class="select2 form-control" id="thuSelect2s">
													<option value="2" />Thứ 2
													<option value="3" />Thứ 3
													<option value="4" />Thứ 4
													<option value="5" />Thứ 5
													<option value="6" />Thứ 6
													<option value="7" />Thứ 7
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput3">Tiết thứ</label>
												<select class="select2 form-control" id="tietthuSelect2s">
													<option value="1" />1
													<option value="2" />2
													<option value="3" />3
													<option value="4" />4
													<option value="5" />5
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="projectinput4">Mức ràng buộc</label>
												<select class="select2 form-control" id="mucrangbuocSelect2s">
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<fieldset class="radio">
												<label>
													<input type="radio" name="radio" value="1" id="apdungtoantruongrbtcds">
													Áp dụng toàn trường
												</label>
											</fieldset>
											<fieldset class="radio">
												<label>
													<input type="radio" name="radio" value="" id="chonkhoilopapdungrbtcds">
													Chọn khối, lớp áp dụng
												</label>
											</fieldset>
										</div>
									</div>
									<hr>
									<input type="text" id="apdungtoantruongids" class="form-control input-sm" hidden>
									<div class="row" id="formchonkhoilopapdungs" style="display: none;">
										<table class="table table-bordered table-light" id="tables">
											<thead class="thead-inverse">
												<tr id="headTablerbtcds"></tr>
											</thead>
											<tbody id="lophocsangrbtcds"></tbody>
										</table>
									</div>
								</div>							
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuytiethoc">Huỷ</button>
							<button type="button" class="btn btn-outline-danger" id="btncapnhattiethoc">Cập nhật</button>
						</div>
					</div>
				</div>
			</div>


			<!-- modal đăng ký tiết gv buộc phải có-->
			<div class="modal fade text-left" id="modaldangkytietbuocphaicogv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" style="display: none;" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document" style="min-width: auto;max-width: fit-content;">
					<div class="modal-content">
						<div class="modal-header bg-success white">
							<h4 class="modal-title white" id="myModalLabel15" >Đăng ký tiết buộc phải có cho GV <b><span id="idbidanhgv" style="color: yellow;"></span></b></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongdangkytietbuocphaicogv">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- form thêm mới tiết giáo viên buộc phải có-->
							<form class="form" id="formthemmoitietgvbuocphaico" >
								<div class="form-body">
									<input type="text" id="idgv" class="form-control input-sm" hidden>
									<input type="text" id="iddatarbtgvbpc" class="form-control input-sm" hidden>
									<input type="text" id="iddktgvbpc" class="form-control input-sm" hidden>
									<div class="flex-container" style=" display: flex;">
										<div>
											<table class="classTableEdit table table-bordered table-striped table-hover" id="tablechontietgvbuocphaico" style="width: 98%;">
												<thead class="thead-inverse">
													<tr>
														<th scope="col">Tiết</th>
														<th scope="col">Mức ràng buộc</th>
														<th scope="col">Danh sách buổi học được áp dụng</th>
														<th scope="col">Chọn tiết gv buộc phải có</th>
													</tr>
												</thead>
												<tbody id="tietgvbuocphaico"></tbody>
											</table>									
										</div>
									</div>
								</div>							
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuy">Huỷ</button>
							<button type="button" class="btn btn-outline-danger" id="btnluutietgvbuocphaico">Lưu</button>
						</div>
					</div>
				</div>
			</div>


			<!-- modal đăng ký buổi nghỉ gv-->
			<div class="modal fade text-left" id="modaldangkybuoinghicuagv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" style="display: none;" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-success white">
							<h4 class="modal-title white" id="myModalLabel15" >Đăng ký buổi nghỉ cho GV <b><span id="idbidanhgv2" style="color: yellow;"></span></b></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongdangkybuoinghicuagv">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- form thêm mới tiết giáo viên buộc phải có-->
							<form class="form" id="formthemmoibuoinghicuagv" >
								<div class="form-body">
									<input type="text" id="idgv2" class="form-control input-sm" hidden>
									<input type="text" id="iddatarbdkbngv" class="form-control input-sm" hidden>
									<input type="text" id="iddkbn" class="form-control input-sm" hidden>
									<div id="girddangkybuoinghicuagv"></div>
								</div>							
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuy">Huỷ</button>
							<button type="button" class="btn btn-outline-danger" id="btnluudangkybuoinghicuagv">Lưu</button>
						</div>
					</div>
				</div>
			</div>


			<!-- modal đăng ký tiết nghỉ gv-->
			<div class="modal fade text-left" id="modaldangkytietnghicuagv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" style="display: none;" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document" style="min-width: auto;max-width: fit-content;">
					<div class="modal-content">
						<div class="modal-header bg-success white">
							<h4 class="modal-title white" id="myModalLabel15" >Đăng ký tiết nghỉ cho GV <b><span id="idbidanhgv1" style="color: yellow;"></span></b></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongdangkytietnghicuagv">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- form thêm mới tiết giáo viên buộc phải có-->
							<form class="form" id="formthemmoitietnghicuagv" >
								<div class="form-body">
									<input type="text" id="idgv1" class="form-control input-sm" hidden>
									<input type="text" id="iddatarbdktngv" class="form-control input-sm" hidden>
									<input type="text" id="iddktn" class="form-control input-sm" hidden>
									<div class="flex-container" style=" display: flex;">
										<div>
											<table class="classTableEdit table table-bordered table-striped table-hover" id="tablechontietdangkynghi" style="width: 98%;">
												<thead class="thead-inverse">
													<tr>
														<th scope="col">Tiết</th>
														<th scope="col">Mức ràng buộc</th>
														<th scope="col">Danh sách buổi học được áp dụng</th>
														<th scope="col">Chọn tiết cho nghỉ</th>
													</tr>
												</thead>
												<tbody id="tietdangkynghi"></tbody>
											</table>									
										</div>
									</div>

								</div>							
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuy">Huỷ</button>
							<button type="button" class="btn btn-outline-danger" id="btnluudangkytietnghicuagv">Lưu</button>
						</div>
					</div>
				</div>
			</div>




			<!-- modal đăng ký buổi nghỉ all-->
				<div class="modal fade text-left" id="modaldangkybuoinghiall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" style="display: none;" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header bg-success white">
								<h4 class="modal-title white" id="myModalLabel15" >Đăng ký buổi nghỉ cho GV</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongdangkybuoinghicuagv">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="girddangkybuoinghiall"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuybuoinghiall">Huỷ</button>
								<button type="button" class="btn btn-outline-danger" id="btnluudangkybuoinghiall">Lưu</button>
							</div>
						</div>
					</div>
				</div>


				<!-- modal đăng ký tiet nghỉ all-->
				<div class="modal fade text-left" id="modaldangkytietnghiall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15" style="display: none;" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header bg-success white">
								<h4 class="modal-title white" id="myModalLabel15" >Đăng ký tiết nghỉ cho GV</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btndongdangkytietnghicuagv">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="girddangkytietnghiall"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal" id="btnhuytietnghiall">Huỷ</button>
								<button type="button" class="btn btn-outline-danger" id="btnluudangkytietnghiall">Lưu</button>
							</div>
						</div>
					</div>
				</div>














			<script type="text/javascript">

					function clearcheckbox(){
						$("#rangbuoctietcodinh").prop( "checked", false);
						$("#tiethopcuato").prop( "checked", false);
						$("#dangkybuoitietnghicuagv").prop( "checked", false);
						$("#tietgiaovienbuocphaico").prop( "checked", false);
						$("#rangbuocsotiet5sang").prop( "checked", false);
						$("#rangbuoctiettranhcuamon").prop( "checked", false);
						$("#tranhhaimonxepcungbuoi").prop( "checked", false);
						$("#captietbuocphaixepliennhau").prop( "checked", false);
						$("#sotiettoidatrongbuoicuamon").prop( "checked", false);
						$("#sotiettoidatrongngaycuamon").prop( "checked", false);
						$("#rangbuocthututiet").prop( "checked", false);
						$("#rangbuoctietnghilop").prop( "checked", false);
					}
					//ràng buộc tiết cố định
					$("#rangbuoctietcodinh").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "block";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						$("#rangbuoctietcodinhtiettrong").prop( "checked", false);
						$("#rangbuoctietcodinhtiethoc").prop( "checked", false);
						$("#apdungtoantruongrbtcd").prop( "checked", false);
						$("#chonkhoilopapdungrbtcd").prop( "checked", false);
						rangbuoctietcodinh();
						loaddatarangbuoctietcodinh();
					});
					$(document).ready(function() {
						document.getElementById("btnthemmoitiethoc").style.display = "block";
						document.getElementById("btnthemmoitiettrong").style.display = "none";
					});

					//tiết họp của tổ(nhóm)
					$("#tiethopcuato").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "block";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						tiethopcuato();
					});

					// đăng ký buổi/tiết nghỉ của gv
					$("#dangkybuoitietnghicuagv").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "block";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						loaddatadanhsachgvthamgiagiangday1();
					});
					// tiết giáo viên buộc phải có
					$("#tietgiaovienbuocphaico").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "block";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						loaddatadanhsachgvthamgiagiangday();
					});
					// ràng buộc số tiết 5 sáng(tiết 1 chiều)
					$("#rangbuocsotiet5sang").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "block";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						rangbuocsotiet5sangtiet1chieu();
					});
					//rang buoc tiet tranh cua mon
					$("#rangbuoctiettranhcuamon").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "block";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						rangbuoctiettranh();
						loadchonlopsang(); 
						loadchonlopchieu(); 
					});
					//tranh 2 mon xep cung buoi
					$("#tranhhaimonxepcungbuoi").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "block";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						rangbuoctranh2monxepcungbuoi();
					});
					//ràng buộc cặp tiết xếp liền nhau
					$("#captietbuocphaixepliennhau").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "block";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
						captietbuocphaixepliennhau();
					});


					$("#sotiettoidatrongngaycuamon").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "block";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
					});
					$("#sotiettoidatrongbuoicuamon").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "block";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "none";
					});

					$("#rangbuocthututiet").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "block";
						document.getElementById("formtietnghilop").style.display = "none";
						thututietlockhoi();
					});

					$("#rangbuoctietnghilop").change(function () {
						document.getElementById("formrangbuoctietcodinh").style.display = "none";
						document.getElementById("formtiethopcuato").style.display = "none";
						document.getElementById("formdangkybuoitietnghicuagv").style.display = "none";
						document.getElementById("formtietgvbuocphaico").style.display = "none";
						document.getElementById("formrangbuocsotiet5sang").style.display = "none";
						document.getElementById("formrangbuoctiettranh").style.display = "none";
						document.getElementById("formrangbuoctranh2monxepcungbuoi").style.display = "none";
						document.getElementById("formrangbuoccaptietxepliennhau").style.display = "none";
						document.getElementById("formsotiettoidatrongmoibuoi").style.display = "none";
						document.getElementById("formsotiettoidatrongngay").style.display = "none";
						document.getElementById("formthututiet").style.display = "none";
						document.getElementById("formtietnghilop").style.display = "block";
						tietnghilop();
					});


</script>

<script type="text/javascript" src="js/rangbuoc/rangbuoctietcodinh.js"></script>
<script type="text/javascript" src="js/rangbuoc/tiethopcuato.js"></script>
<script type="text/javascript" src="js/rangbuoc/rangbuoctiettranhcuamon.js"></script>
<script type="text/javascript" src="js/rangbuoc/rangbuoctiettranh2moncungbuoi.js"></script>
<script type="text/javascript" src="js/rangbuoc/rangbuoccaptietxepliennhau.js"></script>

<script type="text/javascript" src="js/rangbuoc/dangkybuoitietnghicuagv.js"></script>
<script type="text/javascript" src="js/rangbuoc/tietgvbuocphaico.js"></script>
<script type="text/javascript" src="js/rangbuoc/rangbuocsotiet5sangtiet1chieu.js"></script>
		
<script type="text/javascript" src="js/rangbuoc/thututiet.js"></script>
<script type="text/javascript" src="js/rangbuoc/rangbuocdangkytietnghilop.js"></script>

<!-- a duc -->
<!-- <script type="module" src="js\rangbuoc\toidabuoi.js"></script> -->
<script type="module" src="js\rangbuoc\toidangay.js"></script>

@endsection