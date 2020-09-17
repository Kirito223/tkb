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
					<label class="col-md-6 label-control" for="userinput1" style="text-align: right;">Thời khóa biểu sô:</label>
					<div class="col-md-5" style="padding-left: 0">
						<input type="number" id="userinput1" class="form-control border-primary input-sm" name="firstname" >
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group row">
					<label class="col-md-6 label-control" for="userinput1" style="text-align: right;">Thực hiện từ ngày:</label>
					<div class="col-md-6" style="padding-left: 0">
						<input type="text" id="userinput1" class="form-control border-primary input-sm" name="firstname" >
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
											<button type="button" class="btn btn-success">Tải tkb</button>
											<button type="button" class="btn btn-danger">Gửi tkb cho GV qua email</button>
											<button type="button" class="btn btn-primary"> Lưu tkb trực tuyến</button>
											<button type="button" class="btn btn-info"> Xuất tkb để tra cứu</button>
										</div>
									</div>
									<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									<div class="heading-elements" >
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
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">
														Môn, GV (riêng 2 cột)
													</label>
												</fieldset>
												<fieldset class="checkbox"style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">									
														Môn, GV (trong 1 cột)
													</label>
												</fieldset>
												<fieldset class="checkbox"style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">
														Môn/GV (2 dòng)
													</label>
												</fieldset>
												<fieldset class="checkbox"style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">
														Môn
													</label>
												</fieldset>
											</div>
											<hr>
											<label for="projectinput1">Sheet: TKB lớp</label>
											<div class="row" style="padding-left: 10px;padding-right: 10px">
												
												<fieldset class="checkbox" style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">
														Môn, GV (riêng 2 cột)
													</label>
												</fieldset>
												<fieldset class="checkbox"style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">									
														Môn, GV (trong 1 cột)
													</label>
												</fieldset>
												<fieldset class="checkbox"style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">
														Môn/GV (2 dòng)
													</label>
												</fieldset>
												<fieldset class="checkbox"style="padding-right: 10px;">
													<label>
														<input type="checkbox" name="checkbox" value="" id="xemtkbtruong">
														Môn
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
									<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
									<div class="heading-elements" >
										<ul class="list-inline mb-0">
											<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="card-content collapse show" style="">
									<div class="card-body">

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

@endsection

