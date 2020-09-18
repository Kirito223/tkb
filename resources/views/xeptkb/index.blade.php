@extends('master')
@section('title','Xếp thời khóa biểu')
@section('content')

<div class="row" id="cardxeptkb" style="display:none">
	<div class="col-md-12">
		<div class="card"  >
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">Thời khóa biểu</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
						<li><a id="closexemtkb"><i class="ft-x"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collpase show">
				<div class="card-body">
					<form class="form">
						<div class="form-body">
							<section>
								<div class="container">
									<table id="example" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" width="100%">
									</table>
								</div>
							</section>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<dir class="row" style="padding: 0;margin: 0">
	<dir class="col-md-3" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">Xếp thời khóa biểu</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="top: 10px">
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
										<label>Chọn loại thời khóa biểu</label>
										<div class="row">
											<div class="col-md-9">
												<input type="text" id="projectinput1" class="form-control input-xs" placeholder="" name="fname">
											</div>
											<div class="col-md-3" style="padding-left: 0">
												<button type="button" class="btn mr-1 mb-1 btn-light btn-sm" style="padding: 5px;border-color: #e0e0e0;">Đổi tên</button>
											</div>
										</div>
									</div>
									<hr>

									<fieldset class="checkbox">
										<label>
											<input type="checkbox" id="loadexcel"> Load TKB Excel
										</label>
									</fieldset>

									<hr>

									<fieldset class="checkbox">
										<label>
											<input type="checkbox" id="changegv"> Chọn giáo viên
										</label>
									</fieldset>
									<fieldset class="checkbox">
										<label>
											<input type="checkbox" id="changelophoc"> Chọn lớp học
										</label>
									</fieldset>
									<fieldset class="checkbox">
										<label>
											<input type="checkbox" id="changephonghoc"> Chọn phòng học
										</label>
									</fieldset>
									<hr>

									<div id="girddsgv"></div>
									<div id="girddslophoc" style="display: none;"></div>
									<div id="girddsphonghoc" style="display: none;"></div>

								</div>						
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</dir>


	<div class="col-md-5"  id="rowtcrangbuoc" style="display: none">		
		<div class="modal-dialog" role="document" id="cardtcrangbuoc">
			<div class="modal-content" style="border: 0">
				<div class="modal-header">
					<h6 class="modal-title" id="myModalLabel1">Tùy chọn ràng buộc xếp tkb</h6>
					<button type="button" class="close" id="tcrangbuocclose">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="girdtcrangbuoc"></div>
				</div>
			</div>
		</div>
	</div>



	<div class="col-md-5" id="cardtkb">
		<div class="card" id="cardxeptkbgv" style="display: none;">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title" id="titletkbgv">Thời khóa biểu giáo viên</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="top: 10px">
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
							<section>
								<div class="container">
									<table id="example2" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" width="100%">
										<thead>
											<tr>
												<th>Buổi</th>
												<th>Tiết</th>
												<th>Thứ 2</th>
												<th>Thứ 3</th>
												<th>Thứ 4</th>
												<th>Thứ 5</th>
												<th>Thứ 6</th>
												<th style="border-right: 1px solid #E3EBF3;">Thứ 7</th>

											</tr>
										</thead>
										<tbody id="tkbgv">
											<tr>
												<td rowspan="5">Sáng</td>
												<td>1</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>2</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>3</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>4</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>5</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td rowspan="5">Chiều</td>
												<td>1</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>2</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>3</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>4</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>5</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>

										</tbody>
									</table>
								</div>
							</section>
						</div>
					</form>
				</div>
			</div>
		</div>


		<div class="card" id="cardxeptkblop" style="display: none;">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title" id="titletkblop">Thời khóa biểu lớp</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="top: 10px">
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
							<section>
								<div class="container">
									<table id="example3" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" width="100%">
										<thead>
											<tr>
												<th>Buổi</th>
												<th>Tiết</th>
												<th>Thứ 2</th>
												<th>Thứ 3</th>
												<th>Thứ 4</th>
												<th>Thứ 5</th>
												<th>Thứ 6</th>
												<th style="border-right: 1px solid #E3EBF3;">Thứ 7</th>

											</tr>
										</thead>
										<tbody id="tkblop">
											<tr>
												<td rowspan="5">Sáng</td>
												<td>1</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>2</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>3</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>4</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Sáng</td>
												<td>5</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td rowspan="5">Chiều</td>
												<td>1</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>2</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>3</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>4</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
											<tr>
												<td hidden>Chiều</td>
												<td>5</td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true"></td>
												<td draggable="true" style="border-right: 1px solid #E3EBF3;"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</section>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<div class="col-md-4" style="padding-right: 0;padding-left: 0;">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">THÔNG TIN XẾP TKB</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="top: 10px">
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
									<div class="row">
										<div class="col-md-4" style="padding-right: 0"><p>Số lớp: </p></div>
										<div class="col-md-4" style="padding-right: 0"><p>Số GV: </p></div>
										<div class="col-md-4" style="padding-right: 0"><p>Số b/n: </p></div>
									</div>
									<hr>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="projectinput1">Điểm khởi đầu:</label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="projectinput2">Điểm đạt được:</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="projectinput1">Vòng thứ: <span
													id="lblVongthu"></span></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="projectinput2">Thời gian:<span
														id="lblThoigian"></span></label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<div class="form-group" style="text-align: left;">
														<div class="btn-group btn-group-sm" role="group"
														aria-label="Basic example">
														<button type="button" class="btn btn-info"
														id="tinhchinhrangbuoc">T/c ràng buộc</button>
														<button type="button" id="btnxepthoikhoabieu"
														class="btn btn-success"> Xếp tkb mới</button>
														<button type="button" id="btnTepTucxepTKB" class="btn btn-secondary ">Tiếp
														tục</button>
														<button type="button" id="btnDungxepthoikhoabieu"
														class="btn btn-danger" style="display: none">Dừng xếp TKB</button>
														<button type="button" id="btnxemtkb" class="btn btn-warning">Xem tkb</button>
													</div>
												</div>
											</div>
										</div>


										<hr>
										<div class="demo-container">
											<div id="girddsrangbuoc"></div>
										</div>


										<div id="girddsgv"></div>
										<div id="girddslophoc" style="display: none;"></div>
										<div id="girddsphonghoc" style="display: none;"></div>

									</div>						
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</dir>



	<script type="module" src="js/xeptkb/xeptkb.js"></script>
	@endsection