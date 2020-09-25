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
											<label for="projectinput1">Xuất thời khóa biểu</label>
											<fieldset class="checkbox" style="padding-right: 10px;">
												<label>
													<input type="checkbox" name="checkbox" value=""
														id="xuattkbtongquat">
													Xuất thời khóa biểu trường
												</label>
											</fieldset>
											<fieldset class="checkbox" style="padding-right: 10px;">
												<label>
													<input type="checkbox" name="checkbox" value="" id="xuattkblop">
													Xuất thời khóa biểu lớp
												</label>
											</fieldset>
											<fieldset class="checkbox" style="padding-right: 10px;">
												<label>
													<input type="checkbox" name="checkbox" value=""
														id="xuattkbgiaovien">
													Xuất thời khóa biểu giáo viên
												</label>
											</fieldset>
											<fieldset class="checkbox" style="padding-right: 10px;">
												<label>
													<input type="checkbox" name="checkbox" value=""
														id="xuattkbphancongcm">
													Xuất thời khóa biểu phân công chuyên môn
												</label>
											</fieldset>
											<fieldset class="checkbox" style="padding-right: 10px;">
												<label>
													<input type="checkbox" name="checkbox" value="" id="xuattkbphong">
													Xuất thời khóa biểu theo phòng
												</label>
											</fieldset>
											<hr>
											<button type="button" class="btn btn-success" id="xuattkb">Xuất thời khóa
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
												<h6 class="form-section"><i class="ft-user"></i> Thông tin email gửi
												</h6>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<input type="text" id="projectinput1"
																class="form-control input-sm" placeholder="Email"
																name="fname">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<input type="password" id="projectinput2"
																class="form-control input-sm" placeholder="Mật khẩu"
																name="lname">
														</div>
													</div>
												</div>
											</div>
										</form>
										<form class="form">
											<div class="form-body">
												<h6 class="form-section"><i class="ft-calendar"></i> Thời khóa biểu</h6>
												<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<label>Tháng</label>
															<select type="text" id="projectinput1"
																class="form-control input-sm"></select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label>Tuần</label>
															<select type="text" id="projectinput1"
																class="form-control input-sm"></select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label>File đính kèm (Ký số)</label>
															<button type="button"
																class="btn mr-1 mb-1 btn-info btn-sm">File đính
																kèm</button>
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label>Gửi mail</label>
															<button type="button"
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

<script type="text/javascript">
	window.onload = function() {
		danhsachgv();
	};



	function danhsachgv(){
		var data = axios.get('getdanhsachgv').then(function (response) {
			var data1 = response.data;
			var datas = data1.map(function (value, label) {
				let data = value;
				let stt = label + 1;
				var datas = Object.assign(data, {stt: stt.toString()});
				return datas;
			});	
			if(datas == ""){
				Swal.fire({
					title: 'Có lỗi!',
					text: 'Đã có lối xảy ra! Vui lòng kiểm tra và thử lại',
					icon: 'error',
					confirmButtonText: 'OK'
				})
			}
			$("#dsgiaovienguimail").dxDataGrid({
				dataSource: datas,
				showBorders: true,
				// remoteOperations: true,
				scrolling: {
					mode: "virtual",
					rowRenderingMode: "virtual"
				},
				// paging: {
				// 	pageSize: 10
				// },
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
				// pager: {
				// 	showPageSizeSelector: true,
				// 	allowedPageSizes: [5, 10, 20],
				// 	showInfo: true
				// },
				/* headerFilter: {
					visible: true
				}, */
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
	}
</script>
<script type="module" src="js/xuattkb/xuattkb.js"></script>
@endsection