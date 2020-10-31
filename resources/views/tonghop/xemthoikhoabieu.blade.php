@extends('master')
@section('title','Xem thời khóa biểu')
@section('content')

<!-- chọn trường xem tkb -->

<dir class="row" style="padding: 0;margin: 0" id="tabletruong">
	<dir class="col-md-12" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">Thời khoá biểu các trường trực thuộc</h4>
				<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements" style="top: 10px">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus" id="hieuungcongtru"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collpase show" id="bangdstruong">
				<div class="card-body">
					<form class="form">
						<div class="form-body">
							<div id="girddstruong"></div>   
						</div>
					</form>
				</div>
			</div>
		</div>
	</dir>

</dir>


<!-- thời khoá biểu -->
<dir class="row" style="padding: 0;margin: 0;display: none;" id="formxemtkb">
	<div class="col-md-12">
		<div class="row">

			<dir class="col-md-3">
				<div class="card">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title">Xem thời khóa biểu</h4>
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
																<input type="radio" name="radio" value="" id="xemtkbtruong">
																Xem TKB trường
															</label>
														</fieldset>
														<fieldset class="radio">
															<label>
																<input type="radio" name="radio" value="" id="xemtkbgiaovien">														
																Xem TKB giáo viên
															</label>
														</fieldset>
														<fieldset class="radio">
															<label>
																<input type="radio" name="radio" value="" id="xemtkblop">														
																Xem TKB lớp
															</label>
														</fieldset>		
													</div>
												</div>							
											</div>

											<div class="card box-shadow-0 border-info bg-transparent" id="cardsangchieu">
												<div class="card-header bg-transparent" style="padding: 10px">
													<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
													<div class="heading-elements">
														<ul class="list-inline mb-0">
															<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="card-content collapse show" style="" >
													<div class="card-body">
														<fieldset class="radio">
															<label>
																<input type="checkbox" name="radio" value="" class="httkbs">													
																Hiển thị TKB buổi sáng
															</label>
														</fieldset>
														<fieldset class="radio">
															<label>
																<input type="checkbox" name="radio" value="" class="httkbc">														
																Hiển thị TKB buổi chiều
															</label>
														</fieldset>
														<fieldset class="radio">
															<label>
																<input type="checkbox" name="radio" value="" class="httkbsc">												
																Hiển thị TKB cả sáng và chiều
															</label>
														</fieldset>		
													</div>
												</div>							
											</div>

											<div class="card box-shadow-0 border-info bg-transparent" id="cardmaugiaovien" style="display: none;">
												<div class="card-header bg-transparent" style="padding: 10px">
													<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
													<div class="heading-elements">
														<ul class="list-inline mb-0">
															<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
														</ul>
													</div>
												</div>
												<div class="card-content collapse show" style="" >
													<div class="card-body">
														<table id="tablemaugiaovien" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" style="overflow-y: auto; height: 300px;width: 100%;">
															<thead class="thead-inverse">
																<tr>
																	<th>STT</th>
																	<th>Tên GV</th>
																	<th>Màu</th>
																</tr>
															</thead>
															<tbody id="banggiaovien"></tbody>
																
														</table>
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

				<!-- xem tkb trường -->
				<div class="card" id="cardxeptkbtruong" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Thời khóa biểu trường: <b><span id="idtentruong" style="color: blue;"></span></b></h4>
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
											<div id="bangsang">
												<table id="tablexemtkbtruongsang" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" style="overflow-y: auto; height: 600px;width: 100%;">
													<thead class="thead-inverse" style="background-color: #28386c;color: white;">
														<tr id="phandautabletruongsang"></tr>
													</thead>
													<tbody id="phanthantabletruongsang"></tbody>
														
												</table>
											</div>
											<div id="bangchieu">
												<table id="tablexemtkbtruongchieu" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" style="overflow-y: auto; height: 600px;width: 100%;">
													<thead class="thead-inverse" style="background-color: #28386c;color: white;">
														<tr id="phandautabletruongchieu"></tr>
													</thead>
													<tbody id="phanthantabletruongchieu"></tbody>
														
												</table>
											</div>
											<div id="bangsangchieu">
												<table id="tablexemtkbtruong" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" style="overflow-y: auto; height: 600px;width: 100%;">
													<thead class="thead-inverse" style="background-color: #28386c;color: white;">
														<tr id="phandautabletruong"></tr>
													</thead>
													<tbody id="phanthantabletruong"></tbody>
														
												</table>
											</div>
										</div>
									</section>
								</div>
							</form>
						</div>
					</div>
				</div>


				<!-- select giáo viên của trường -->
				<div class="card" id="cardselectgv" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Trường: <b><span id="idtentruonggv" style="color: blue;"></span></b></h4>
						<input type="hidden" id="idtruonggv">
					</div>
					<div class="card-content collpase show">
						<div class="card-body">
							<form class="form">
								<div class="form-body">
									<section>
										<div class="container" style="overflow-y: auto; ">
											<label>Chọn giáo viên:</label>
											<select id="idselectgv" data-live-search="true"></select>
										</div>
									</section>

								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- xem tkb giáo viên -->
				<div class="card" id="cardxeptkbgiaovien" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Thời khóa biểu giáo viên: <b><span id="idtengv" style="color: green;"></span></b></h4>
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
											<table id="tablexemtkbgiaovien" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" style="overflow-y: auto; height: 100%;width: 100%;">
												<thead class="thead-inverse" style="background-color: #28386c;color: white;">
													<tr id="phandautablegiaovien">
														<th>Buổi</th>
														<th>Tiết</th>
														<th id="2" class="classthu">Thứ 2</th>
														<th id="3" class="classthu">Thứ 3</th>
														<th id="4" class="classthu">Thứ 4</th>
														<th id="5" class="classthu">Thứ 5</th>
														<th id="6" class="classthu">Thứ 6</th>
														<th id="7" class="classthu">Thứ 7</th>
													</tr>
												</thead>
												<tbody id="phanthantablegiaovien"></tbody>
											</table>
										</div>
									</section>

								</div>
							</form>
						</div>
					</div>
				</div>


				<!-- select lớp của trường -->
				<div class="card" id="cardselectlop" style="display: none;">
					<div class="card-header" style="padding: 10px">
						<h4 class="card-title" id="titletkbgv">Trường: <b><span id="idtentruonglop" style="color: blue;"></span></b></h4>
						<input type="hidden" id="idtruonglop">
					</div>
					<div class="card-content collpase show">
						<div class="card-body">
							<form class="form">
								<div class="form-body">
									<section>
										<div class="container" style="overflow-y: auto; ">
											<div>
												<label>Chọn khối:</label>
												<select id="idselectkhoi" data-live-search="true"></select>
											</div>
											<br>
											<div>
												<label>Chọn lớp:</label>
												<select id="idselectlop" data-live-search="true"></select>
											</div>
										</div>
									</section>

								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- xem tkb lớp -->
				<div class="card" id="cardxeptkblop" style="display: none;">
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
											<table id="tablexemtkblop" class="table table-striped table-bordered dataex-key-basic table-responsive display nowrap" style="overflow-y: auto; height: 100%;width: 100%;">
												<thead class="thead-inverse" style="background-color: #28386c;color: white;">
													<tr id="phandautablelop">
														<th>Buổi</th>
														<th>Tiết</th>
														<th id="2" class="classthu">Thứ 2</th>
														<th id="3" class="classthu">Thứ 3</th>
														<th id="4" class="classthu">Thứ 4</th>
														<th id="5" class="classthu">Thứ 5</th>
														<th id="6" class="classthu">Thứ 6</th>
														<th id="7" class="classthu">Thứ 7</th>
													</tr>
												</thead>
												<tbody id="phanthantablelop"></tbody>
											</table>
										</div>
									</section>
								</div>
							</form>
						</div>
					</div>
				</div>


			</dir>
		</div>
	</div>	
</dir>

<script type="text/javascript">
	// setTimeout(function() {
	// 	$('#changegv').trigger('click');
	// },500);

	$("#xemtkbtruong").change(function () {

		$("#xemtkbgiaovien").prop("checked", false);
		$("#xemtkblop").prop("checked", false);
		document.getElementById("cardxeptkbtruong").style.display = "block";
		document.getElementById("cardxeptkbgiaovien").style.display = "none";
		document.getElementById("cardxeptkblop").style.display = "none";
		document.getElementById("cardselectgv").style.display = "none";
		document.getElementById("cardselectlop").style.display = "none";
		document.getElementById("cardsangchieu").style.display = "block";
		// document.getElementById("cardmaugiaovien").style.display = "block";
	});

	$("#xemtkbgiaovien").change(function () {

		$("#xemtkbtruong").prop("checked", false);
		$("#xemtkblop").prop("checked", false);
		document.getElementById("cardxeptkbtruong").style.display = "none";
		document.getElementById("cardsangchieu").style.display = "none";		
		document.getElementById("cardxeptkblop").style.display = "none";
		document.getElementById("cardselectgv").style.display = "block";
		document.getElementById("cardselectlop").style.display = "none";
		document.getElementById("cardmaugiaovien").style.display = "none";
	});

	$("#xemtkblop").change(function () {

		$("#xemtkbgiaovien").prop("checked", false);
		$("#xemtkbtruong").prop("checked", false);
		document.getElementById("cardxeptkbtruong").style.display = "none";
		document.getElementById("cardxeptkbgiaovien").style.display = "none";
		// document.getElementById("cardxeptkblop").style.display = "block";
		document.getElementById("cardselectgv").style.display = "none";
		document.getElementById("cardselectlop").style.display = "block";
		document.getElementById("cardsangchieu").style.display = "none";
		document.getElementById("cardmaugiaovien").style.display = "none";
	});

	// $("#changegv").change(function () {
	// 	$("#changelophoc").prop("checked", false);
	// 	$("#changephonghoc").prop("checked", false);
	// 	$("#changemon").prop("checked", false);
	// 	// danhsachgv();
	// 	document.getElementById("girddsgv").style.display = "block";
	// 	document.getElementById("girddslophoc").style.display = "none";
	// 	document.getElementById("girddsphonghoc").style.display = "none";
	// 	document.getElementById("girddsmon").style.display = "none";
	// });

	// $("#changelophoc").change(function () {
	// 	$("#changegv").prop("checked", false);
	// 	$("#changephonghoc").prop("checked", false);
	// 	$("#changemon").prop("checked", false);
	// 	// danhsachlophoc();
	// 	document.getElementById("girddslophoc").style.display = "block";
	// 	document.getElementById("girddsgv").style.display = "none";
	// 	document.getElementById("girddsphonghoc").style.display = "none";
	// 	document.getElementById("girddsmon").style.display = "none";
	// });

	// $("#changephonghoc").change(function () {
	// 	$("#changegv").prop("checked", false);
	// 	$("#changelophoc").prop("checked", false);
	// 	$("#changemon").prop("checked", false);
	// 	// danhsachphonghoc();
	// 	document.getElementById("girddsphonghoc").style.display = "block";
	// 	document.getElementById("girddsgv").style.display = "none";
	// 	document.getElementById("girddslophoc").style.display = "none";
	// 	document.getElementById("girddsmon").style.display = "none";
	// });
	// $("#changemon").change(function () {
	// 	$("#changegv").prop("checked", false);
	// 	$("#changephonghoc").prop("checked", false);
	// 	$("#changelophoc").prop("checked", false);
	// 	// danhsachmonhoc();
	// 	document.getElementById("girddsmon").style.display = "block";
	// 	document.getElementById("girddsgv").style.display = "none";
	// 	document.getElementById("girddsphonghoc").style.display = "none";
	// 	document.getElementById("girddslophoc").style.display = "none";
	// });


</script>



<script type="text/javascript" src="js/tonghop/xemthoikhoabieu.js"></script>
<link rel="stylesheet" href="css/xemtkb/styleXemtkb.css">
@endsection