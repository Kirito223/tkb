@extends('master')
@section('title','Thống kê')
@section('content')

<!-- thời khoá biểu -->
<dir class="row" style="padding: 0;margin: 0;" >
	<div class="col-md-12">
		<div class="row">

			<dir class="col-md-3">
				<div class="card">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title">Thống kê</h4>
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
											<div class="card box-shadow-0 border-info bg-transparent" id="nhapdulieuhethong">
												<div class="card-header bg-transparent" style="padding: 10px">
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
																<input type="radio" name="radio" value="" id="thongkesoluongtietday">

																Số lượng tiết dạy
															</label>
														</fieldset>
														<fieldset class="radio">
															<label>
																<input type="radio" name="radio" value="" id="thongkesoluongphonghoc">														
																Số lượng phòng học
															</label>
														</fieldset>
														<!-- <fieldset class="radio">
															<label>
																<input type="radio" name="radio" value="" id="thongkesoluonghocsinh">														
																Số lượng học sinh
															</label>
														</fieldset> -->
<!-- 														<fieldset class="radio">
															<label>
																<input type="radio" name="radio" value="" id="thongkesoluonggvgiangday">														
																Thống kê số lượng giáo viên giảng dạy
															</label>
														</fieldset>	 -->	
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

			<dir class="col-md-9">

				<!-- select trường -->
				<div class="card" id="cardselecttruong" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<!-- <h4 class="card-title" id="titletkbgv">Trường: <b><span id="idtentruonggv" style="color: blue;"></span></b></h4> -->
					</div>
					<div class="card-content collpase show">
						<div class="card-body">
							<form class="form">
								<div class="form-body">
									<section>
										<div class="container" style="overflow-y: auto; ">
											<label>Chọn trường:</label>
											<select id="idselecttruong" data-live-search="true"></select>
										</div>
									</section>

								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- thống kê số lượng tiết dạy của trường -->
				<div class="card" id="cardthongkesoluongtietday" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Trường: <b><span id="idtentruong" style="color: blue;"></span></b></h4>
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
											<table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" id="tablesotietday">
												<thead class="thead-inverse">
													<tr >
														<th scope="col">STT</th>
														<th scope="col">Họ và tên</th>
														<th scope="col">Tổng số tiết</th>
														<th scope="col">Số tiết mỗi môn lớp</th>
													</tr>
												</thead>
												<tbody id="phanthantablesotietday"></tbody>
											</table>
										</div>
									</section>
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- thống kê số lượng phòng học-->
				<div class="card" id="cardthongkesoluongphonghoc" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Trường: <b><span id="idtentruongphonghoc" style="color: green;"></span></b></h4>
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
										<div class="container" style="overflow-y: auto; ">
											<table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" id="tablesophonghoc">
												<thead class="thead-inverse">
													<tr >
														<th scope="col">STT</th>
														<th scope="col">Tổng số phòng học</th>
														<th scope="col">Tên phòng học</th>
													</tr>
												</thead>
												<tbody id="phanthantablesophonghoc"></tbody>
											</table>
										</div>
									</section>

								</div>
							</form>
						</div>
					</div>
				</div>

				<!--  thống kê số lượng học sinh -->
				<!-- <div class="card" id="cardthongkesoluonghocsinh" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Thời khóa biểu lớp: <b><span id="idtenlop" style="color: green;"></span></b></h4>
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
														<td rowspan="5" style="color: red;">Sáng</td>
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
														<td rowspan="5" style="color: red;">Chiều</td>
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
				</div> -->


			</dir>
		</div>
	</div>	
</dir>

<script type="text/javascript">
	$("#thongkesoluongtietday").change(function () {

		$("#thongkesoluongphonghoc").prop("checked", false);
		$("#thongkesoluonghocsinh").prop("checked", false);
		document.getElementById("cardthongkesoluongtietday").style.display = "block";
		document.getElementById("cardthongkesoluongphonghoc").style.display = "none";
		// document.getElementById("cardthongkesoluonghocsinh").style.display = "none";
		document.getElementById("cardselecttruong").style.display = "block";
	});

	$("#thongkesoluongphonghoc").change(function () {

		$("#thongkesoluongtietday").prop("checked", false);
		$("#thongkesoluonghocsinh").prop("checked", false);
		document.getElementById("cardthongkesoluongtietday").style.display = "none";
		document.getElementById("cardthongkesoluongphonghoc").style.display = "block";
		// document.getElementById("cardthongkesoluonghocsinh").style.display = "none";
		document.getElementById("cardselecttruong").style.display = "block";
	});

	// $("#thongkesoluonghocsinh").change(function () {

	// 	$("#thongkesoluongtietday").prop("checked", false);
	// 	$("#thongkesoluongphonghoc").prop("checked", false);
	// 	document.getElementById("cardthongkesoluongtietday").style.display = "none";
	// 	document.getElementById("cardthongkesoluongphonghoc").style.display = "none";
	// 	document.getElementById("cardthongkesoluonghocsinh").style.display = "block";
	// });


</script>
<script type="text/javascript" src="js/tonghop/thongke.js"></script>
@endsection