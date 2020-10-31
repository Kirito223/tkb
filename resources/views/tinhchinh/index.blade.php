@extends('master')
@section('title','Tinh chỉnh ')
@section('content')

<dir class="row" style="padding: 0;margin: 0">
<!-- 	<dir class="col-md-3" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title">Tinh chỉnh</h4>
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
	</dir> -->

	<dir class="col-md-12" style="margin: 0;padding: 2px">
		<div class="card">
			<div class="card-header" style="padding: 10px">
				<h4 class="card-title" style="padding-left: 10px">Đánh giá giáo viên</h4>
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





	window.onload = function() {
		danhgiagiaovien();
	};

	function reloaddanhgiagv() {
		danhgiagiaovien();
		var dataGrid = $("#danhgiagiaovien").dxDataGrid("instance");
		dataGrid.refresh();
	}

	function danhgiagiaovien(){
		var data = axios.get('getdanhgiagvtruong').then(function (response) {
			var data1 = response.data[0];
			var tengv = response.data[1];
			var gvchuyenmon = response.data[2];
			var danhgiagv = response.data[3];
			$("#danhgiagiaovien").dxDataGrid({
				dataSource: data1,
				allowColumnReordering: true,
				showBorders: true,
				searchPanel: {
					visible: true
				},
				allowColumnResizing: true,
				columnResizingMode: "widget",
				columns: [{
					caption: "Tổ chuyên môn",
					dataField: "tentocm",

				}],
				masterDetail: {
					enabled: true,
					template: function(container, options) { 
						var currentEmployeeData = options.data.id;
						var datagvchuyenmon = [];
						gvchuyenmon.filter(function(items) {
							if(items.matochuyenmon == currentEmployeeData){
								var i = datagvchuyenmon.findIndex(x => x.magiaovien == items.magiaovien);
								if (i <= -1) {
									datagvchuyenmon.push(items);
								}
								return null;
							}
						});
						$("<div>").dxDataGrid({
							columnAutoWidth: true,
							showBorders: true,
							editing: {
								mode: "batch",
								allowUpdating: true,
								selectTextOnEditStart: true,
								startEditAction: "click",
								// allowAdding: true,
							},
							columns: [{
								caption: "Tên giáo viên",
								dataField: "magiaovien",
								lookup: {
									dataSource: tengv,
									valueExpr: "id",
									displayExpr: "hovaten"
								},
							},{
								caption: "Thời điểm đánh giá",
								dataField: "danhgiagv.created_at",
								dataType: "date",
								format: 'dd/MM/yyyy',
							},{
								caption: "Hình thức",
								dataField: "danhgiagv.hinhthuc",
								lookup: {
									dataSource: [{
										id: 1,
										muc: "Chuyên đề"
									}, {
										id: 2,
										muc: "Toàn diện"
									}, {
										id: 3,
										muc: "Đột xuất"
									}, {
										id: 4,
										muc: "Chưa đánh giá"
									}],
									valueExpr: "id",
									displayExpr: "muc"
								},
							},{
								caption: "Xếp loại",
								dataField: 'danhgiagv.xeploai',
								lookup: {
									dataSource: [{
										id: 1,
										muc: "Tốt"
									}, {
										id: 2,
										muc: "Khá"
									}, {
										id: 3,
										muc: "Trung bình"
									}, {
										id: 4,
										muc: "Chưa đạt yêu cầu"
									}, {
										id: null,
										muc: "Chưa đánh giá"
									},],
									valueExpr: "id",
									displayExpr: "muc"
								},
							}],

							onRowUpdating: function(e) {
								var danhgiagvid = e.oldData.danhgiagv;
								if(danhgiagvid == null){
									var id = null;
								}else{
									var id = e.oldData.danhgiagv.id;
								}
								var tochuyenmon = currentEmployeeData;
								if(e.newData.magiaovien === undefined){
									var magiaovien = e.oldData.magiaovien;
								}else{
									var magiaovien = e.newData.magiaovien;
								}
								if(e.newData.danhgiagv.hinhthuc === undefined){
									var hinhthuc = e.oldData.danhgiagv.hinhthuc;
								}else{
									var hinhthuc = e.newData.danhgiagv.hinhthuc;
								}	
								if(e.newData.danhgiagv.xeploai === undefined){
									var xeploai = e.oldData.danhgiagv.xeploai;
								}else{
									var xeploai = e.newData.danhgiagv.xeploai;
								}							
								if(e.newData.danhgiagv.created_at === undefined){
									var created_at = e.oldData.danhgiagv.created_at;
								}else{
									var created_at = e.newData.danhgiagv.created_at;
								}	
								axios.post('updatedanhgiagv', {id:id,tochuyenmon:tochuyenmon,magiaovien:magiaovien,hinhthuc:hinhthuc,xeploai:xeploai,created_at:created_at}).then(function(response) {
									var data = response.data;
									Swal.fire({
										title: 'Lưu',
										text: 'Đã lưu thành công',
										icon: 'success',
										confirmButtonText: 'OK'
									});
									reloaddanhgiagv();
								});
							},
							onRowInserting: function(e) {
								var tochuyenmon = currentEmployeeData;
								if(e.data.magiaovien === undefined){
									var magiaovien = "";
								}else{
									var magiaovien = e.data.magiaovien;
								}
								if(e.data.hinhthuc === undefined){
									var hinhthuc = "";
								}else{
									var hinhthuc = e.data.hinhthuc;
								}
								if(e.data.xeploai === undefined){
									var xeploai = "";
								}else{
									var xeploai = e.data.xeploai;
								}
								if(e.data.created_at === undefined){
									var created_at = "";
								}else{
									var created_at = e.data.created_at;
								}					
								axios.post('adddanhgiagv',{tochuyenmon:tochuyenmon,magiaovien:magiaovien,hinhthuc:hinhthuc,xeploai:xeploai,created_at:created_at}).then(function (response) {
									var data = response.data;
									Swal.fire({
										title: 'Lưu',
										text: 'Đã thêm mới thành công',
										icon: 'success',
										confirmButtonText: 'OK'
									});
									reloaddanhgiagv();
								});
							},
							onContextMenuPreparing: function(data) { 
								if (data.target == "content") {
									if (!data.items) data.items = [];
									data.items.push({
										template: function () {
											return $("<i class='fa fa-remove'>").text(" Xóa");                  
										},
										onItemClick: function() {
											var dataxoa = data.row.data.id;
											xoadanhgiagv(dataxoa);
										}
									});
								} 
							},


							dataSource: new DevExpress.data.DataSource({
								store: new DevExpress.data.ArrayStore({
									key: "matochuyenmon",
									data: datagvchuyenmon
								}),
								filter: ["matochuyenmon", "=", options.key.id]
							})
						}).appendTo(container);
}
}

});
});
}


function xoadanhgiagv(id) {
	Swal.fire({
		title: 'Lưu',
		text: "Bạn có muốn xóa đánh giá giáo viên này không",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			axios.post('delldanhgiagv',{id:id}).then(function (response) {
				var data = response.data;
				Swal.fire({
					position: 'center',
					icon: 'success',
					text: 'Đã xóa thành công',
					showConfirmButton: false,
					timer: 1000
				});	
				reloaddanhgiagv();
			});
		}		
	})
}
</script>


@endsection