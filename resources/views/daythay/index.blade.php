@extends('master')
@section('title','Giáo viên dạy thay')
@section('content')

<div class="card">
	<div class="card-header" style="padding: 10px">
		<h4 class="card-title" style="text-align: center;">Giáo viên dạy thay</h4>
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
			<div class="row">
				<div class="col-2">
					<div class="form-group">
						<label for="tuan">Tuần</label>
						<select class="form-control" id="tuan">
							<option value="none" selected="" disabled="">--Chọn tuần--
							</option>
							<option value="1">Tuần 1
							</option>
							<option value="2">Tuần 2
							</option>
							<option value="3">Tuần 3
							</option>
							<option value="4">Tuần 4
							</option>
						</select>
					</div>
					<div class="form-group">
						<label for="thang">Tháng</label>
						<input class="form-control" id="thang" />
					</div>
					<div class="form-group">
						<label for="lop">Lớp học</label>
						<select class="form-control" id="lop"></select>
					</div>
					<div class="form-group">
						<label for="buoihoc">Buổi học</label>
						<select class="form-control" id="buoihoc">
							<option value="0">Sáng</option>
							<option value="1">Chiều</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tiet">Tiết học</label>
						<select class="form-control" id="tiet">
							<option value="1">Tiết 1</option>
							<option value="2">Tiết 2</option>
							<option value="3">Tiết 3</option>
							<option value="4">Tiết 4</option>
							<option value="5">Tiết 5</option>
						</select>
					</div>
					<div class="d-flex justify-content-center mt-1">
						<button id="btnLoc" class="btn btn-sm btn-success">Lọc</button>
					</div>
				</div>
				<div class="col-md-10">
					<table class="table table-light table-bordered">
						<thead>
							<tr>
								<th>Họ và tên</th>
								<th>Môn học</th>
								<th>Thứ</th>
								<th>Phân giáo viên dạy thay</th>
							</tr>
						</thead>
						<tbody id="bodyTable">

						</tbody>
					</table>

					<div class="d-flex justify-content-end">
						<button id="btnPhanGiaovien" class="btn btn-sm btn-success">Phân giáo viên</button>
					</div>
				</div>
			</div>
		</div>
	</div>



</div>
<script>
	var danhsachGiaovien;
	window.onload = function(){
		loadData();
		initEvent();
	}

	function loadTKB(){
		axios.post("getTKB", {tuan:$('#tuan').val(), thang: $('#thang').val(), lop: $('#lop').val(), buoi: $('#buoihoc').val(), tiet: $('#tiet').val()}).then(res=>{
				let data = res.data;
				let html = '';
				data.forEach(item =>{
					html += `<tr>
								<td>${item.giaovien.hovaten}</td>
								<td>${item.monhoc.tenmonhoc}</td>
								<td>${item.thu}</td>
								<td><select class="form-control sltGiaoVienDayThay">${danhsachGiaovien.map(gv =>{
	
			return	`<option ${gv.id == item.giaovien.id? "selected":""} class="optGiaoVienDayThay" data-tuan="${$('#tuan').val()}" data-buoi="${$('#buoihoc').val()}"
									data-tiet="${$('#tiet').val()}"
									data-thang="${item.created_at}" data-lop="${item.malop}" data-mon="${item.mamonhoc}" data-tkb="${item.id}" data-giaovienhientai="${item.giaovien.id}" data-thu="${item.thu}" value="${gv.id}">${gv.hovaten}</option>`
			})}</select></td>
							</tr>`;
				})
				document.getElementById('bodyTable').innerHTML = html;
			})
	}

	function initEvent(){
		$('#btnLoc').click((e)=>{
			loadTKB();
		})

		$('#btnPhanGiaovien').click(()=>{
			let sltGiaoVienDayThay = document.getElementsByClassName('sltGiaoVienDayThay');
			let danhsach =[];
			for (const slt of sltGiaoVienDayThay) {
				let opt  = slt.options[slt.selectedIndex];
				if(slt.value != opt.dataset.giaovienhientai){
					danhsach.push({
						tuan: opt.dataset.tuan,
						buoi: opt.dataset.buoi,
						tiet: opt.dataset.tiet,
						thang: opt.dataset.thang,
						lop: opt.dataset.lop,
						mon: opt.dataset.mon,
						tkb: opt.dataset.tkb,
						giaovienhientai: opt.dataset.giaovienhientai,
						giaovienthaythe: slt.value,
						thu: opt.dataset.thu,
					})
				}
			}
			axios.post("phanCongDayThay", {danhsach: JSON.stringify(danhsach)}).then(res=>{
				if(res.data== "OK"){
					Swal.fire('Đã phân công dạy thay thành công', "Đã phân công", "success").then(isConfirm=>{
						if(isConfirm){
							loadTKB();
						}
					})
				}else{
					Swal.fire('Đã có lỗi xảy ra vui lòng kiểm tra lại', "Xảy ra lỗi", "error")
				}
			})
		})
	}
async	function loadData(){
		axios.get('getdanhsachlophoc').then(res=>{
			let data = res.data;
			data.forEach(element => {
				$('#lop').append(`<option value="${element.id}">${element.tenlop}</option>`);
			});
		})

		$("#thang").datepicker({
				format: "mm/yyyy",
				orientation: "bottom",
				viewMode: "months",
				minViewMode: "months",
				autoclose: true,
				language: "vi"
    		});

			danhsachGiaovien = await axios.get('getdanhsachgv').then(res=>{
				return res.data;
			});
			
			

	}
</script>
@endsection