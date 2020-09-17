@extends('master')
@section('title','Phân quyền')
@section('content')



<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Danh sách phân quyền</h4>
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
				<div id="girdphanquyen"></div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function loadphanquyen() {
		var data = axios.get('getlistquyen').then(function (response) {
			var data1 = response.data;
			var datas = data1.map(function(value, label) {
				let data = value;
				let stt = label + 1;
				var datas = Object.assign(data, {
					stt: stt.toString()
				});
				return datas;
			});
			$("#girdphanquyen").dxDataGrid({
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
					allowAdding: true,
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
					caption: "Tên quyền",
					dataField: "name",
				},{
					caption: "Mô tả",
					dataField: "description",	
				}],
				onRowInserting: function(e) {
					if (e.data.name === undefined) {
						var addname = "";
					} else {
						var addname = e.data.name;
					}
					if (e.data.description === undefined) {
						var adddescription = "";
					} else {
						var adddescription = e.data.description;
					}
					axios.post('addphanquyen', {
						name: addname,
						description: adddescription
					}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã thêm mới thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloadphanquyen();
					});
				},

				onRowUpdating: function(e) {
					var id = e.oldData.id;
					if (e.newData.name === undefined) {
						var addname = e.oldData.name;
					} else {
						var addname = e.newData.name;
					}

					if (e.newData.description === undefined) {
						var adddescription = e.oldData.description;
					} else {
						var adddescription = e.newData.description;
					}
					axios.post('updatephanquyen', {
						id:id,
						name: addname,
						description: adddescription
					}).then(function(response) {
						var data = response.data;
						Swal.fire({
							title: 'Lưu',
							text: 'Đã cập nhật thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						});
						reloadphanquyen();
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
								xoaphanquyen(dataxoa);
							}
						});
					} 
				}
			});
		});
	}


function reloadphanquyen(){
  loadphanquyen();
  var dataGrid = $("#girdphanquyen").dxDataGrid("instance");
  dataGrid.refresh();
}

	function xoaphanquyen(dataxoa) {
		Swal.fire({
			title: 'Lưu',
			text: "Bạn có muốn xóa phân quyền này không",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Lưu'
		}).then((result) => {
			if (result.value == true) {
				axios.post('delphanquyen', {id: dataxoa}).then(function(response) {
					loadphanquyen();
					var dataGrid = $("#girdphanquyen").dxDataGrid("instance");
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


	window.onload = function() {
		loadphanquyen();
	}
</script>
@endsection