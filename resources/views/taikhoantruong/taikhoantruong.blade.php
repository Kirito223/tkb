@extends('master')
@section('title','Thông tin tài khoản')
@section('content')


<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin tài khoản</h4>
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
				<div id="girdtaikhoan"></div>
			</div>
		</div>
	</div>
</div>


<!-- modal đổi mật khẩu trường -->
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

	function loadtaikhoan() {
		var data = axios.get('getlisttaikhoantruong').then(function (response) {
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
				// filterRow: {
				// 	visible: true,
				// 	applyFilter: "auto"
				// },
				// searchPanel: {
				// 	visible: true,
				// 	width: 240,
				// 	placeholder: "Tìm kiếm..."
				// },
				// selection: {
				// 	mode: "single"
				// },
				// editing: {
				// 	mode: "batch",
				// 	allowUpdating: true,
				// 	selectTextOnEditStart: true,
				// 	startEditAction: "click",

				// 	// allowAdding: true,
				// },
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
				}],

				onContextMenuPreparing: function(data) { 
					if (data.target == "content") {
						if (!data.items) data.items = [];
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
					} 
				}



			});

});
};

// function resetdata(datamatruong) {
// 	var datare = axios.post('resetdata',{matruong:datamatruong}).then(function(response) {
// 		loadtaikhoan();
// 		var dataGrid = $("#getlisttaikhoantruong").dxDataGrid("instance");
// 		dataGrid.refresh();

// 	});

// }

function doimatkhau(doimk,tentaikhoan) {
	$('#modalresetpassword').modal('show');
	$('#titlehead').html('Đổi lại mật khẩu tài khoản : '+ tentaikhoan);

	$('#luumk').click(function (){
		var id = doimk;
		var password = $('#passwordreset').val();
		if(password.length < 6){
			Swal.fire({
				icon: 'error',
				title: 'Lỗi...!',
				text: 'Mật khẩu phải chứa ít nhất 6 ký tự',
			});
		}else{
			var data = axios.post('updatepasswordtruong',{id:id,password:password}).then(function (response) {
				var data1 = response.data;
				Swal.fire({
					title: 'Lưu',
					text: 'Đã đổi mật khẩu thành công',
					icon: 'success',
					confirmButtonText: 'OK'
				});
				loadtaikhoan();
				var dataGrid = $("#getlisttaikhoantruong").dxDataGrid("instance");
				dataGrid.refresh();			
			});
			$('#modalresetpassword').modal('toggle');
		}
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


window.onload = function() {
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
	loadtaikhoan();
	
};
</script>

@endsection