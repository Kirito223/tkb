@extends('master')
@section('title','Import số tiết môn học temp')
@section('content')

<dir class="row" style="padding: 0;margin: 0">
	<dir class="col-md-3" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title"></h4>
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
										<!-- <label>Chọn thời khóa biểu</label>
										<input type="text" id="projectinput1" class="form-control input-xs" placeholder="" name="fname"> -->
									</div>
									<hr>

									<fieldset class="checkbox">
										<label>
											<input type="radio" id="importexcel"> Nạp dữ liệu từ excel
										</label>
									</fieldset>
									<fieldset class="checkbox">
										<label>
											<input type="radio" id="importdata" checked> Nhập dữ liệu trực tiếp
										</label>
									</fieldset>
								</div>						
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</dir>
	<dir class="col-md-9" style="margin: 0;padding: 2px">

		<!-- import excel-->
		<div class="card" id="formimportexcel" style="display: none;">
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
						<div class="col-md-3">
                            <div class="form-group">
                                <label for="projectinput5">Huyện</label>
                                <select id="idhuyen" name="interested" class="form-control">
                                    <!-- <option value="none" selected="" disabled="">--Chọn loại thông báo--
                                    </option><option value="1">Công tác quản lý
                                    </option><option value="2">Công tác chuyên môn
                                    </option><option value="3">Lịch kiểm tra
                                    </option><option value="4">Thông báo khác
                                	</option> -->
                            	</select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="projectinput5">Cấp học</label>
                                <select id="idcaphoc" name="interested" class="form-control">
                                    <option value="none" selected="" disabled="">--Chọn loại cấp học--
                                    </option><option value="1">Tiểu học
                                    </option><option value="2">Trung học cơ sở
                                    </option>
                            	</select>
                            </div>
                        </div>
                        <div class="col-md-3" style="display: none;" id="divKhoihoc">
                            <div class="form-group">
                                <label for="projectinput5">Khối học</label>
                                <select id="idkhoihoc" name="interested" class="form-control">
                                    <!-- <option value="none" selected="" disabled="">--Chọn khổi học--
                                    </option><option value="1">Tiểu học
                                    </option><option value="2">Trung học cơ sở
                                    </option><option value="3">Trung học phổ thông
                                    </option> -->
                            	</select>
                            </div>
                        </div>
					</div>
					<hr>
					<div class="row" id="formExcel" >
						<div class="col-md-6">
							<div class="form-group">
								<h5>Tải lên file excel chứa số tiết môn học temp</h5>
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
								<a id="link" href="excelfilemau/sotietmonhoctemp.xls" download hidden></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- import trực tiếp -->
		<div class="card" id="formimportdata" style="display: none;">
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
						<div class="col-md-3">
                            <div class="form-group">
                                <label for="projectinput5">Huyện</label>
                                <select id="idhuyentt" name="interested" class="form-control">
                            	</select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="projectinput5">Cấp học</label>
                                <select id="idcaphoctt" name="interested" class="form-control">
                                    <option value="none" selected="" disabled="">--Chọn loại cấp học--
                                    </option><option value="1">Tiểu học
                                    </option><option value="2">Trung học cơ sở
                                    </option>
                            	</select>
                            </div>
                        </div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div id="griddssotietmonhoctemp"></div>
							</div>
						</div>
					</div>
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

	</dir>
</dir>
<script type="text/javascript">
	
	$("#importexcel").change(function () {
		if ($(this).is(":checked")) {
			$("#importdata").prop("checked", false);
			document.getElementById("formimportexcel").style.display = "block";
			document.getElementById("formimportdata").style.display = "none";
		}
	});
	$("#importdata").change(function () {
		if ($(this).is(":checked")) {
			$("#importexcel").prop("checked", false);
			document.getElementById("formimportexcel").style.display = "none";
			document.getElementById("formimportdata").style.display = "block";
		}
	});

</script>
<script type="text/javascript" src="js/importsotietmonhoctemp/importsotietmonhoctemp.js"></script>
<script type="text/javascript" src='dx/js/jszip/dist/xlsx.full.min.js'></script>

@endsection






