@extends('master')
@section('title','Đánh giá giáo viên ')
@section('content')

<dir class="row" style="padding: 0;margin: 0">

	<dir class="col-md-12" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title" style="padding-left: 10px"></h4>
				<a class="heading-elements-toggle" ><i class="fa fa-ellipsis-v font-medium-3"></i></a>
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
									<label>Chọn trường xem đánh giá:</label>
											<select id="idselecttruong" data-live-search="true"></select>
								</div>						
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</dir>

	<dir class="col-md-12" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title" style="padding-left: 10px">Đánh giá giáo viên trường: <b><span id="idtentruong" style="color: blue;"></span></b></h4>
				<a class="heading-elements-toggle" ><i class="fa fa-ellipsis-v font-medium-3"></i></a>
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
									<div id="danhgiagiaovien"></div>
								</div>						
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</dir>
</dir>

<script type="text/javascript">
	setTimeout(function() {
		$('#changegv').trigger('click');
	},500);

	$("#changegv").change(function () {
		if ($(this).is(":checked")) {
			$("#changelophoc").prop("checked", false);
			$("#changephonghoc").prop("checked", false);
			danhsachgv();
			document.getElementById("girddsgv").style.display = "block";
			document.getElementById("girddslophoc").style.display = "none";
			document.getElementById("girddsphonghoc").style.display = "none";

		}
	});

	$("#changelophoc").change(function () {
		if ($(this).is(":checked")) {
			$("#changegv").prop("checked", false);
			$("#changephonghoc").prop("checked", false);
			danhsachlophoc();
			document.getElementById("girddsgv").style.display = "none";
			document.getElementById("girddslophoc").style.display = "block";
			document.getElementById("girddsphonghoc").style.display = "none";

		}
	});

	$("#changephonghoc").change(function () {
		if ($(this).is(":checked")) {
			$("#changelophoc").prop("checked", false);
			$("#changegv").prop("checked", false);
			danhsachphonghoc();
			document.getElementById("girddsgv").style.display = "none";
			document.getElementById("girddslophoc").style.display = "none";
			document.getElementById("girddsphonghoc").style.display = "block";

		}
	});


</script>

<script type="text/javascript" src="js/tonghop/theodoidanhgiagiaovien.js"></script>
@endsection