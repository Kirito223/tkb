@extends('master')
@section('title','Tài khoản')
@section('content')


<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Danh sách tài khoản</h4>
			<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
			<div class="heading-elements" style="padding-top: 10px">
				<ul class="list-inline mb-0">
					<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
					<li><a data-action="close"><i class="ft-x"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="card-content collpase show">
			<div class="card-body">
				<button type="button" class="btn mr-1 mb-1 btn-info btn-sm" id="addtaikhoan">Thêm mới</button>
				<div id="girdtaikhoan"></div>

			</div>
		</div>
	</div>
</div>



<div class="modal fade text-left" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel18">Thêm tài khoản mới</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="projectinput1">Tên tài khoản</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3" style="padding: 0.4rem 1rem;"><i class="fa fa-user"></i></span>
								</div>
								<input type="text" id="tentaikhoan" class="form-control input-sm" name="tentaikhoan">
							</div>
						</div>
						<div class="form-group">
							<label for="projectinput1">Email</label>
							<div class="input-group">
								<input type="email" id="email" class="form-control input-sm" name="email">
							</div>
						</div>
						<div class="form-group">
							<label for="projectinput1">Huyện</label>
							<div class="input-group">
								<select class="form-control input-sm" id="huyen"></select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="projectinput1">Mật khẩu</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3" style="padding: 0.4rem 1rem;"><i class="fa fa-eye-slash"></i></span>
								</div>
								<input type="password" id="password" class="form-control input-sm" name="password">
							</div>
						</div>
						<div class="form-group">
							<label for="projectinput1">Trường</label>
							<div class="input-group">
								<select class="form-control input-sm" id="truong"></select>
							</div>
						</div>
						<div class="form-group">
							<label for="projectinput1">Xã</label>
							<div class="input-group">
								<select class="form-control input-sm" id="xa"></select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="projectinput1">Quyền</label>
					<div class="input-group">
						<select class="form-control input-sm" id="quyen"></select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="luutk">Lưu</button>
				<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade text-left" id="modalresetpassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="titlehead">Đổi lại mật khẩu tài khoản : </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="projectinput1">Mật khẩu mới</label>
					<div class="input-group" >
						<input type="password" class="form-control" id="passwordreset" >
						<div class="input-group-append" >
							<span class="input-group-text" id="showpass"><i class="fa fa-eye-slash"></i></span>
							<span class="input-group-text" id="hiddenpass" style="display:none;"><i class="fa fa-eye"></i></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn mr-1 mb-1 btn-success btn-sm" id="luumk">Lưu</button>
					<button type="button" class="btn mr-1 mb-1 btn-danger btn-sm" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$('#addtaikhoan').click(function (){
		$('#modaladd').modal('show');
	});


	$('#luutk').click(function (){
		var tentaikhoan = $('#tentaikhoan').val();
		var email = $('#email').val();
		var huyen = $('#huyen').val();
		var password = $('#password').val();
		var truong = $('#truong').val();
		var xa = $('#xa').val();
		var quyen = $('#quyen').val();
		var data = axios.post('addtaikhoan',{tentaikhoan:tentaikhoan,email:email,huyen:huyen,password:password,truong:truong,xa:xa,quyen:quyen}).then(function (response) {
			var data1 = response.data;
			Swal.fire({
				title: 'Lưu',
				text: 'Đã thêm mới thành công',
				icon: 'success',
				confirmButtonText: 'OK'
			});
			loadtaikhoan();
			var dataGrid = $("#getlisttaikhoan").dxDataGrid("instance");
			dataGrid.refresh();			
		});
		$('#modaladd').modal('toggle');
	});


	function loadtaikhoan() {
		var data = axios.get('getlisttaikhoan').then(function (response) {
			var data1 = response.data[0].data;
			var huyen = response.data[0].huyen;
			var xa = response.data[0].xa;
			var truong = response.data[0].truong;
			var quyen = response.data[0].quyen;
			var gvcount = response.data[0].gvcount;
			var lopcount = response.data[0].lopcount;

			var datas = data1.map(function(value, label) {
				let data = value;
				let stt = label + 1;
				var datas = Object.assign(data, {
					stt: stt.toString()
				});
				return datas;
			});
			$("#girdtaikhoan").dxDataGrid({
				dataSource: datas,
				showBorders: true,
				paging: {
					pageSize: 30
				},
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
				// selection: {
				// 	mode: "single"
				// },
				editing: {
					mode: "batch",
					allowUpdating: true,
					selectTextOnEditStart: true,
					startEditAction: "click",

					// allowAdding: true,
				},
				/* co dan cot */
				allowColumnResizing: true,
				columnResizingMode: "widget",
				columns: [{
					caption: "STT",
					dataField: "stt",
					width: 50,
					allowEditing: false,
				},{
					caption: "Tên tài khoản",
					dataField: "tentaikhoan",
				},{
					caption: "Email",
					dataField: "email",
				},{
					caption: "Trường",
					dataField: "matruong",
					lookup: {
						dataSource: truong,
						valueExpr: "matruong",
						displayExpr: "tentruong"
					},
				},{
					caption: "Huyện",
					dataField: "mahuyen",
					lookup: {
						dataSource: huyen,
						valueExpr: "mahuyen",
						displayExpr: "tenhuyen"
					},
				},{
					caption: "Xã",
					dataField: "loaixa",
					lookup: {
						dataSource: xa,
						valueExpr: "id",
						displayExpr: "tenxa"
					},
				},{
					caption: "Quyền",
					dataField: "level",
					lookup: {
						dataSource: quyen,
						valueExpr: "id",
						displayExpr: "name"
					},
				},{
					caption: "Số lớp học",
					cellTemplate: function (container, options) {
						var idlop = options.data.matruong;
						var luckylop = lopcount.filter(function (e){
							if(idlop == ""){
								return e;
							}else if(idlop == e.matruong){
								return e;
							}
						});
						var countlop = luckylop.length;
						$("<div>").html(countlop).appendTo(container);
					},
				},{
					caption: "Số giáo viên",
					cellTemplate: function (container, options) {
						var idgv = options.data.matruong;
						var luckygv = gvcount.filter(function (e){
							if(idgv == ""){
								return e;
							}else if(idgv == e.matruong){
								return e;
							}
						});
						var countgv = luckygv.length;
						$("<div>").html(countgv).appendTo(container);
					},
				}],
				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if (e.newData.tentaikhoan === undefined) {
						var addtentaikhoan = e.oldData.tentaikhoan;
					} else {
						var addtentaikhoan = e.newData.tentaikhoan;
					}

					if (e.newData.email === undefined) {
						var addemail = e.oldData.email;
					} else {
						var addemail = e.newData.email;
					}

					if (e.newData.matruong === undefined) {
						var addmatruong = e.oldData.matruong;
					} else {
						var addmatruong = e.newData.matruong;
					}

					if (e.newData.mahuyen === undefined) {
						var addmahuyen = e.oldData.mahuyen;
					} else {
						var addmahuyen = e.newData.mahuyen;
					}

					if (e.newData.loaixa === undefined) {
						var addloaixa = e.oldData.loaixa;
					} else {
						var addloaixa = e.newData.loaixa;
					}

					if (e.newData.level === undefined) {
						var addlevel = e.oldData.level;
					} else {
						var addlevel = e.newData.level;
					}

					axios.post('updatetaikhoan', {
						id: id,
						tentaikhoan: addtentaikhoan,
						email: addemail,
						matruong: addmatruong,
						mahuyen: addmahuyen,
						loaixa: addloaixa,
						level: addlevel
					}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã lưu thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						var dataGrid = $("#getlisttaikhoan").dxDataGrid("instance");
						dataGrid.refresh();
					});




				},

				onContextMenuPreparing: function(data) { 
					if (data.target == "content") {
						if (!data.items) data.items = [];
						data.items.push({
							template: function () {
								return $("<i class='fa fa-repeat'>").text(" Reset dữ liệu");                  
							},
							onItemClick: function() {
								var datamatruong = data.row.data.matruong;
								resetdata(datamatruong);
							}
						});
						
						data.items.push({
							template: function () {
								return $("<i class='fa fa-remove'>").text(" Xóa");                  
							},
							onItemClick: function() {
								var dataxoa = data.row.data.id;
								var matruong = data.row.data.matruong;
								xoataikhoan(dataxoa,matruong);
							}
						});
						data.items.push({
							template: function () {
								return $("<i class='fa fa-lock'>").text(" Đổi mật khẩu");                  
							},
							onItemClick: function() {
								var doimk = data.row.data.id;
								var tentaikhoan = data.row.data.tentaikhoan;
								doimatkhau(doimk,tentaikhoan);
							}
						});
						data.items.push({
							template: function () {
								return $("<i class='fa fa-lock'>").text(" Đặt lại mật khẩu");                  
							},
							onItemClick: function() {
								var datmk = data.row.data.id;
								Swal.fire({
									title: 'Lưu',
									text: "Bạn có muốn đặt lại mật khẩu tài khoản này không",
									icon: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Lưu'
								}).then((result) => {
									if (result.value == true) {
										axios.post('resetpassword', {id: datmk}).then(function(response) {
											var dataGrid = $("#getlisttaikhoan").dxDataGrid("instance");
											dataGrid.refresh();
										});
										Swal.fire(
											'Lưu',
											'Lưu thành công',
											'success'
											)
									}
								})
							}
						});
					} 
				}



			});

});
};

	function resetdata(datamatruong) {
	var datare = axios.post('resetdata',{matruong:datamatruong}).then(function(response) {
		loadtaikhoan();
		var dataGrid = $("#getlisttaikhoan").dxDataGrid("instance");
		dataGrid.refresh();

	});

}
	
function xoataikhoan(id,matruong) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa tài khoản này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Lưu'
	}).then((result) => {
		if (result.value == true) {
			axios.post('deltaikhoan', {id: id,matruong:matruong}).then(function(response) {
				loadtaikhoan();
				var dataGrid = $("#getlisttaikhoan").dxDataGrid("instance");
				dataGrid.refresh();
			});
			Swal.fire(
				'Lưu',
				'Lưu thành công',
				'success'
				)
		}
	})
}

function doimatkhau(doimk,tentaikhoan) {
	$('#modalresetpassword').modal('show');
	$('#titlehead').html('Đổi lại mật khẩu tài khoản : '+ tentaikhoan);

	$('#luumk').click(function (){
		var id = doimk;
		var password = $('#passwordreset').val();
		var data = axios.post('updatepassword',{id:id,password:password}).then(function (response) {
			var data1 = response.data;
			Swal.fire({
				title: 'Lưu',
				text: 'Đã đổi mật khẩu thành công',
				icon: 'success',
				confirmButtonText: 'OK'
			});
			loadtaikhoan();
			var dataGrid = $("#getlisttaikhoan").dxDataGrid("instance");
			dataGrid.refresh();			
		});
		$('#modalresetpassword').modal('toggle');
	});
	
}


$("#showpass").click(function(){
	document.getElementById("showpass").style.display = "none";
	document.getElementById("hiddenpass").style.display = "block";
	$("#passwordreset").attr('type','text');
});
$("#hiddenpass").click(function(){
	document.getElementById("showpass").style.display = "block";
	document.getElementById("hiddenpass").style.display = "none";
	$("#passwordreset").attr('type','password');
});






function datlaimatkhau(id) {
	
}


window.onload = function() {
	loadtaikhoan();
	$('#truong').select2({width: '100%'});
	axios.get("getlisttruong").then(function(response) {
		let data = response.data;
		if (data != null) {
			let htmltruong = data.map(function(item) {
				return ('<option value="' +item.matruong +'">' +item.tentruong +"</option>");
			});
			$("#truong").html('<option value=""></option>' + htmltruong);
		}
	});
	$('#huyen').select2({width: '100%'});
	axios.get("getlisthuyen").then(function(response) {
		let data = response.data;
		if (data != null) {
			let htmlhuyen = data.map(function(item) {
				return ('<option value="' +item.mahuyen +'">' +item.tenhuyen +"</option>");
			});
			$("#huyen").html('<option value=""></option>' + htmlhuyen);
		}
	});
	$('#quyen').select2({width: '100%'});
	axios.get("getlistquyen").then(function(response) {
		let data = response.data;
		if (data != null) {
			let htmlquyen = data.map(function(item) {
				return ('<option value="' +item.id +'">' +item.name +"</option>");
			});
			$("#quyen").html('<option value=""></option>' + htmlquyen);
		}
	});
	$('#xa').select2({width: '100%'});
	axios.get("getlistxa").then(function(response) {
		let data = response.data;
		if (data != null) {
			let htmlxa = data.map(function(item) {
				return ('<option value="' +item.id +'">' +item.tenxa +"</option>");
			});
			$("#xa").html('<option value=""></option>' + htmlxa);
		}
	});
};
</script>

<script src="theme/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

@endsection