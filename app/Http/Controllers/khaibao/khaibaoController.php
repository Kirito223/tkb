<?php

namespace App\Http\Controllers\khaibao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\danhsachgv;
use App\monhoc;
use App\danhsachlophoc;
use App\tochuyenmon;
use App\mucrangbuoc;
use App\giaovien_chuyenmon;
use App\phonghoc;
use App\tiethoc;
use App\phancongchuyenmon;
use App\sotietmonhoc;
use App\sotiettrongbuoi;
use Illuminate\Support\Facades\DB;
use stdClass;
use Session; 

class khaibaoController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('khaibao.index');
	}
	//danh sách giáo viên
	public function getdanhsachgv(){
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong',$matruong)->orderBy('id', 'desc')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachgv(Request $rq){
		$matruong = Session::get('matruong');
		$danhsachgv = new danhsachgv();
		$danhsachgv->hovaten = $rq->hovaten;
		$danhsachgv->bidanh = $rq->bidanh;
		$danhsachgv->dienthoai = $rq->dienthoai;
		$danhsachgv->email = $rq->email;
		$danhsachgv->matruong = $matruong;
		$success = $danhsachgv->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function updatedanhsachgv(Request $rq){
		$matruong = Session::get('matruong');
		$danhsachgv = danhsachgv::find($rq->id);
		$danhsachgv->hovaten = $rq->hovaten;
		$danhsachgv->bidanh = $rq->bidanh;
		$danhsachgv->dienthoai = $rq->dienthoai;
		$danhsachgv->email = $rq->email;
		$danhsachgv->matruong = $matruong;
		$success = $danhsachgv->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function deldanhsachgv(Request $rq)
	{
		$danhsachgv = danhsachgv::destroy($rq->id);
		return json_encode($danhsachgv, JSON_UNESCAPED_UNICODE);
	}
	public function deltoanbodanhsachgv(Request $rq)
	{
		$idgv = $rq->id;
		foreach ($idgv as $key) {
			foreach ($key as $value) {
				$danhsachgv = danhsachgv::destroy($value);
			}	
			
		}
		return json_encode($danhsachgv, JSON_UNESCAPED_UNICODE);
	}


	//danh sach mon hoc
	public function getdanhsachmonhoc(){
		$matruong = Session::get('matruong');
		$data =  monhoc::with('tochuyenmon')->where('matruong',$matruong)->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachmonhoc(Request $rq){
		$matruong = Session::get('matruong');
		$danhsachmonhoc = new monhoc();
		$danhsachmonhoc->matochuyenmon = $rq->matochuyenmon;
		$danhsachmonhoc->tenmonhoc = $rq->tenmonhoc;
		$danhsachmonhoc->monhocviettat = $rq->monhocviettat;
		$danhsachmonhoc->matruong = $matruong;
		$success = $danhsachmonhoc->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function updatedanhsachmonhoc(Request $rq){
		$matruong = Session::get('matruong');
		$danhsachmonhoc = monhoc::find($rq->id);
		$danhsachmonhoc->matochuyenmon = $rq->matochuyenmon;
		$danhsachmonhoc->tenmonhoc = $rq->tenmonhoc;
		$danhsachmonhoc->monhocviettat = $rq->monhocviettat;
		$danhsachmonhoc->matruong = $matruong;
		$success = $danhsachmonhoc->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function deldanhsachmonhoc(Request $rq)
	{
		$danhsachmonhoc = monhoc::destroy($rq->id);
		return json_encode($danhsachmonhoc, JSON_UNESCAPED_UNICODE);
	}
	public function deltoanbodanhsachmonhoc(Request $rq)
	{	
		$idmon = $rq->id;
		foreach ($idmon as $key) {
			foreach ($key as $value) {
				$danhsachmonhoc = monhoc::destroy($value);
			}	
			
		}
		return json_encode($danhsachmonhoc, JSON_UNESCAPED_UNICODE);		
	}


	// danh sách lớp học
	public function getdanhsachlophoc(){
		$matruong = Session::get('matruong');
		$data =  danhsachlophoc::where('matruong',$matruong)->orderBy('thutuhienthi', 'ASC')->orderBy('khoi', 'ASC')->orderBy('tenlop', 'ASC')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function updatethutuhienthi(Request $rq){
		$danhsachlophoc = danhsachlophoc::find($rq->id);
		$danhsachlophoc->thutuhienthi = $rq->thutuhienthi;
		$success = $danhsachlophoc->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachlophoc(Request $rq){
		$matruong = Session::get('matruong');
		$danhsachlophoc = new danhsachlophoc();
		$danhsachlophoc->tenlop = $rq->tenlop;
		$danhsachlophoc->khoi = $rq->khoi;
		$danhsachlophoc->thutuhienthi = $rq->thutuhienthi;
		$danhsachlophoc->matruong = $matruong;
		$success = $danhsachlophoc->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function updatedanhsachlophoc(Request $rq){
		$matruong = Session::get('matruong');
		$danhsachlophoc = danhsachlophoc::find($rq->id);
		$danhsachlophoc->tenlop = $rq->tenlop;
		$danhsachlophoc->khoi = $rq->khoi;
		$danhsachlophoc->thutuhienthi = $rq->thutuhienthi;
		$danhsachlophoc->matruong = $matruong;
		$success = $danhsachlophoc->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function deldanhsachlophoc(Request $rq)
	{
		$danhsachlophoc = danhsachlophoc::destroy($rq->id);
		return json_encode($danhsachlophoc, JSON_UNESCAPED_UNICODE);
	}
	public function deltoanbodanhsachlophoc(Request $rq)
	{	
		$idlop = $rq->id;
		foreach ($idlop as $key) {
			foreach ($key as $value) {
				$danhsachlophoc = danhsachlophoc::destroy($value);
			}	
			
		}
		return json_encode($danhsachlophoc, JSON_UNESCAPED_UNICODE);		
	}


	// danh sách tổ chuyên môn
	public function getdanhsachtochuyenmon(){
		$matruong = Session::get('matruong');
		$data =  tochuyenmon::where('matruong',$matruong)->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachtochuyenmon(Request $rq){
		$matruong = Session::get('matruong');
		$tochuyenmon = new tochuyenmon();
		$tochuyenmon->tentocm = $rq->tentocm;
		$tochuyenmon->tenviettat = $rq->tenviettat;
		$tochuyenmon->matruong = $matruong;
		$success = $tochuyenmon->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function updatedanhsachtochuyenmon(Request $rq){
		$matruong = Session::get('matruong');
		$tochuyenmon = tochuyenmon::find($rq->id);
		$tochuyenmon->tentocm = $rq->tentocm;
		$tochuyenmon->tenviettat = $rq->tenviettat;
		$tochuyenmon->matruong = $matruong;
		$success = $tochuyenmon->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function deldanhsachtochuyenmon(Request $rq)
	{
		$tochuyenmon = tochuyenmon::destroy($rq->id);
		return json_encode($tochuyenmon, JSON_UNESCAPED_UNICODE);
	}
	public function deltoanbodanhsachtochuyenmon(Request $rq)
	{
		$idtocm = $rq->id;
		foreach ($idtocm as $key) {
			foreach ($key as $value) {
				$tochuyenmon = tochuyenmon::destroy($value);
			}	
			
		}
		return json_encode($tochuyenmon, JSON_UNESCAPED_UNICODE);
	}


	//danh sách giáo viên của tổ chuyên môn
	public function loadmonhoctocmchange(Request $rq)
	{	
		$matruong = Session::get('matruong');
		$data = DB::table('tochuyenmon')->where('matruong',$matruong)
		->join('monhoc', 'monhoc.matochuyenmon', 'tochuyenmon.id')
		->select('monhoc.id','monhoc.matochuyenmon','monhoc.tenmonhoc','tochuyenmon.tentocm')
		->where('tochuyenmon.id',$rq->id)
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function getdanhsachgvcuatochuyenmon(){
		$matruong = Session::get('matruong');
		$datagv = danhsachgv::where('matruong',$matruong)->get();
		$datagvtocm = giaovien_chuyenmon::all();
		$datatocm = tochuyenmon::where('matruong',$matruong)->get();
		$datamonhoc = monhoc::where('matruong',$matruong)->get();
		$datas = [];
		$obj  = new stdClass;
		$obj->gv = $datagv;
		$obj->gvtocm = $datagvtocm;
		$obj->tocm = $datatocm;
		$obj->monhoc = $datamonhoc;
		array_push($datas, $obj);
		return json_encode($obj, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachgvcuatochuyenmonloc(Request $rq){
		$gv = $rq->magiaovien;
		$tocm = $rq->matochuyenmon;
		$monhoc =$rq->mamonhoc;
		$mucrangbuoc = $rq->mucrangbuoc;
		foreach ($monhoc as $key) {
			$giaovien_chuyenmon = new giaovien_chuyenmon();
			$giaovien_chuyenmon->magiaovien = $rq->magiaovien;
			$giaovien_chuyenmon->mamonhoc = $key;
			$giaovien_chuyenmon->matochuyenmon = $rq->matochuyenmon;
			$success = $giaovien_chuyenmon->save();	
		}
		$this->addnadupdatemucrb($mucrangbuoc,$gv);
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	private function addnadupdatemucrb($mucrangbuoc,$gv){
		$giaovien= giaovien_chuyenmon::where('magiaovien',$gv)->get();
		foreach ($giaovien as $giaovien_chuyenmon) {
			$giaovien_chuyenmon->mucrangbuoc = $mucrangbuoc;
			$success = $giaovien_chuyenmon->save();
		}
	}

	public function updatedanhsachgvcuatochuyenmonloc(Request $rq){
		$gvnew = $rq->magiaoviennew;
		$gvold = $rq->magiaovienold;
		$tocm = $rq->matochuyenmon;
		$monhoc = $rq->mamonhoc;
		$mucrangbuoc = $rq->mucrangbuoc;

		$giaovien =	giaovien_chuyenmon::where('magiaovien',$gvold)->get();
		$del = array();

		foreach ($giaovien as $key => $value) {
			giaovien_chuyenmon::destroy($value->id);
		}
		if($gvnew == null){
			foreach ($monhoc as $keys) {
				$key = new giaovien_chuyenmon();
				$key->magiaovien = $gvold;
				$key->matochuyenmon = $tocm;
				$key->mucrangbuoc = $mucrangbuoc;
				$key->mamonhoc = $keys;
				$success = $key->save();
			}
		}else{
			foreach ($monhoc as $keys) {
				$key = new giaovien_chuyenmon();
				$key->magiaovien = $gvnew;
				$key->matochuyenmon = $tocm;
				$key->mucrangbuoc = $mucrangbuoc;
				$key->mamonhoc = $keys;
				$success = $key->save();
			}
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}



	// danh sách phòng học bộ môn
	public function getdanhsachphonghocbomon(){
		$matruong = Session::get('matruong');
		$data =  phonghoc::where('matruong',$matruong)->orderBy('tenphong', 'ASC')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachphonghocbomon(Request $rq){
		$matruong = Session::get('matruong');
		$phonghocbomon = new phonghoc();
		$phonghocbomon->tenphong = $rq->tenphonghoc;
		$phonghocbomon->matruong = $matruong;
		$success = $phonghocbomon->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function updatedanhsachphonghocbomon(Request $rq){
		$phonghocbomon = phonghoc::find($rq->id);
		$phonghocbomon->tenphong = $rq->tenphonghoc;
		$success = $phonghocbomon->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function deldanhsachphonghocbomon(Request $rq)
	{
		$phonghocbomon = phonghoc::destroy($rq->id);
		return json_encode($phonghocbomon, JSON_UNESCAPED_UNICODE);
	}
	public function deltoanbodanhsachphonghocbomon(Request $rq)
	{	
		$idphonghoc = $rq->id;
		foreach ($idphonghoc as $key) {
			foreach ($key as $value) {
				$phonghocbomon = phonghoc::destroy($value);
			}	
			
		}
		return json_encode($phonghocbomon, JSON_UNESCAPED_UNICODE);		
	}









	// danh sách gv tham gia giảng dạy
	public function getdanhsachgvthamgiagiangday(){
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong',$matruong)->with(['monhoc'=>function($author){
			$author->select('monhoc.id','monhoc.tenmonhoc','phancongchuyenmon.malop','phancongchuyenmon.magiaovien','phancongchuyenmon.mamonhoc','phancongchuyenmon.sotiet');
			$author->with(['danhsachlophoc'=>function($to){
				$to->select('danhsachlophoc.id','danhsachlophoc.tenlop');
			}]);
		}])
		->select('id','hovaten','bidanh','thutuhienthi','trangthai')
		->orderBy('thutuhienthi', 'ASC')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	// update thứ tự hiển thị gv tham gia giảng dạy
	public function updatethutuhienthigvthamgiagiangday(Request $rq){
		$matruong = Session::get('matruong');
		$id = $rq->id;
		$thutuhienthi = $rq->thutuhienthi;
		$danhsachlophoc = danhsachgv::find($id);
		$danhsachlophoc->thutuhienthi = $thutuhienthi;
		$danhsachlophoc->matruong = $matruong;
		$success = $danhsachlophoc->save();

		return json_encode($success);
	}
	public function updatetrangthaigvthamgiagiangday(Request $rq){
		$idth1 = $rq->idth1;
		foreach ($idth1 as $key => $value1) {
			$danhsachgv = danhsachgv::find($value1);
			$danhsachgv->trangthai = "1";
			$success = $danhsachgv->save();
		}
		$idth0 = $rq->idth0;
		foreach ($idth0 as $key => $value0) {
			$danhsachgv = danhsachgv::find($value0);
			$danhsachgv->trangthai = "0";
			$success = $danhsachgv->save();
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}


	//chon mon hoc
	public function updatechonbuoihoc(Request $rq){
		$idth1 = $rq->idth1;
		foreach ($idth1 as $key => $value1) {
			$chonmonhoc = monhoc::find($value1);
			$chonmonhoc->trangthai = "1";
			$success = $chonmonhoc->save();
		}
		$idth0 = $rq->idth0;
		foreach ($idth0 as $key => $value0) {
			$chonmonhoc = monhoc::find($value0);
			$chonmonhoc->trangthai = "0";
			$success = $chonmonhoc->save();
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}


	//chon lop hoc
	public function updatechonthlophoc(Request $rq){
		$idth1 = $rq->idth1;
		foreach ($idth1 as $key => $value1) {
			$danhsachlophoc = danhsachlophoc::find($value1);
			$danhsachlophoc->trangthai = "1";
			$success = $danhsachlophoc->save();
		}
		$idth0 = $rq->idth0;
		foreach ($idth0 as $key => $value0) {
			$danhsachlophoc = danhsachlophoc::find($value0);
			$danhsachlophoc->trangthai = "0";
			$success = $danhsachlophoc->save();
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	//chon to cm
	public function updatechonthtocm(Request $rq){
		$idth1 = $rq->idth1;
		foreach ($idth1 as $key => $value1) {
			$tochuyenmon = tochuyenmon::find($value1);
			$tochuyenmon->trangthai = "1";
			$success = $tochuyenmon->save();
		}
		$idth0 = $rq->idth0;
		foreach ($idth0 as $key => $value0) {
			$tochuyenmon = tochuyenmon::find($value0);
			$tochuyenmon->trangthai = "0";
			$success = $tochuyenmon->save();
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	//chon phong hoc
	public function updatechonthphonghoc(Request $rq){
		$idth1 = $rq->idth1;
		foreach ($idth1 as $key => $value1) {
			$phonghoc = phonghoc::find($value1);
			$phonghoc->trangthai = "1";
			$success = $phonghoc->save();
		}
		$idth0 = $rq->idth0;
		foreach ($idth0 as $key => $value0) {
			$phonghoc = phonghoc::find($value0);
			$phonghoc->trangthai = "0";
			$success = $phonghoc->save();
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}





	//danh sách số tiết trong buổi của mỗi lớp
	public function getdanhsachsotiettrongbuoi(){
		$matruong = Session::get('matruong');
		$data = DB::table('sotiettrongbuoi')->where('sotiettrongbuoi.matruong',$matruong)
		->join('danhsachlophoc','danhsachlophoc.id','=','sotiettrongbuoi.malop')
		->select('sotiettrongbuoi.*','danhsachlophoc.tenlop','danhsachlophoc.id as idlh')
		->orderBy('danhsachlophoc.tenlop', 'ASC')->get();
		foreach($data as $k => $v) {
			if($v->buoi == 0){
				$buoi = "sang";
			}else{
				$buoi = "chieu";
			}
			$temp[] = array('id'=>$v->id,'malop'=>$v->malop,'tenlop'=>$v->tenlop,'buoi'=>$buoi,'thu'=>$v->thu,'sotiet'=>$v->sotiet);
		}
		if(empty($temp)){
			$new_data = [];
		}else{
			foreach($temp as $t){
				$tenlop = $t['tenlop'];
				$buoi = $t['buoi'];
				$grouped[$tenlop][$buoi][] = $t;
			}
			foreach($grouped as $k => $v) {
				$new_data[] = array('tenlop' => $k, 'buoi'=> $v);
			}
		}
		return json_encode($new_data, JSON_UNESCAPED_UNICODE);
	}
	public function getdssotiettrongbuoi(){
		$data = sotiettrongbuoi::all();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//update s? ti?t trong bu?i c?a m?i l?p
	public function updatesotiettrongbuoi(Request $rq){
		$matruong = Session::get('matruong');
		$sotiettrongbuoi = sotiettrongbuoi::find($rq->id);		
		if($sotiettrongbuoi != null){			
			$sotiettrongbuoi->sotiet = $rq->sotiet;
			$sotiettrongbuoi->update();
			$success = 1;
		}else{
			$sotiettrongbuoi= new sotiettrongbuoi;
			$sotiettrongbuoi->malop = $rq->malop;
			$sotiettrongbuoi->buoi = $rq->buoi;
			$sotiettrongbuoi->thu = $rq->thu;
			$sotiettrongbuoi->sotiet = $rq->sotiet;
			$sotiettrongbuoi->matruong = $matruong;
			$sotiettrongbuoi->save();
			$success = 1;	
		}			
		return json_encode($success);
	}
	public function addsotiettrongbuoi(){
		$matruong = Session::get('matruong');
		$dslophoc = danhsachlophoc::select('id')->get();
		foreach ($dslophoc as $key => $value) {
			$itemml = $value->id;
			for ($i=0; $i < 12; $i++) { 
				if($i == 0){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 2;
					$success = $sotiettrongbuoi->save();
				}else if($i == 1){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 3;
					$success = $sotiettrongbuoi->save();
				}else if($i == 2){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 4;
					$success = $sotiettrongbuoi->save();
				}else if($i == 3){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 5;
					$success = $sotiettrongbuoi->save();
				}else if($i == 4){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 6;
					$success = $sotiettrongbuoi->save();
				}else if($i == 5){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 7;
					$success = $sotiettrongbuoi->save();
				}else if($i == 6){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 2;
					$success = $sotiettrongbuoi->save();
				}else if($i == 7){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 3;
					$success = $sotiettrongbuoi->save();
				}else if($i == 8){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 4;
					$success = $sotiettrongbuoi->save();
				}else if($i == 9){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 5;
					$success = $sotiettrongbuoi->save();
				}else if($i == 10){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 6;
					$success = $sotiettrongbuoi->save();
				}else if($i == 11){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $itemml;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 7;
					$success = $sotiettrongbuoi->save();
				}
			}
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}









//danh sách s? ti?t ? m?i môn c?a m?i l?p
	public function getdanhsachsotietmoimon(){
		$matruong = Session::get('matruong');
		$data =  danhsachlophoc::where('matruong',$matruong)->with(['monhoc'=>function($author) use($matruong){
			$author->where('monhoc.matruong',$matruong);
			$author->select('sotietmonhoc.id','monhoc.id as mamonhoc','monhoc.tenmonhoc','sotietmonhoc.sotiet','sotietmonhoc.malop');
		}])
		->orderBy('danhsachlophoc.tenlop', 'ASC')->select('id','tenlop')
		->get();
		// dd($new_data1);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//update s? ti?t ? m?i môn c?a m?i l?p
	public function updatesotietmoimon(Request $rq){
		$matruong = Session::get('matruong');
		$sotietmonhoc = sotietmonhoc::find($rq->id);		
		if($sotietmonhoc != null){			
			$sotietmonhoc->sotiet = $rq->sotiet;
			$sotietmonhoc->update();
			$success = 1;

		}else{
			$sotietmonhoc= new sotietmonhoc;
			$sotietmonhoc->malop = $rq->malop;
			$sotietmonhoc->mamonhoc = $rq->mamonhoc;
			$sotietmonhoc->sotiet = $rq->sotiet;
			$sotietmonhoc->matruong = $matruong;
			$sotietmonhoc->save();
			$success = 1;	
		}			
		return json_encode($success);
	}


	// danh sách gv tham gia giảng dạy
	public function getdanhsachphanconggvday(Request $rq){
		$matruong = Session::get('matruong');
		$data = DB::table('phancongchuyenmon')
		->leftjoin('danhsachgv','danhsachgv.id','=','phancongchuyenmon.magiaovien')
		->leftjoin('monhoc','monhoc.id','=','phancongchuyenmon.mamonhoc')
		->leftjoin('danhsachlophoc','danhsachlophoc.id','=','phancongchuyenmon.malop')
		->select('phancongchuyenmon.*','danhsachgv.holot','danhsachgv.ten','danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);

	}















	//import excel bang phân công tkb
	public function importexcelbangphancongtkb(Request $rq){
		$tenlop = $rq->tenlop;
		$monhoc = $rq->monhoc;
		$tengv = $rq->tengv;

		$magiaovien = danhsachgv::where('ten', '=', $tengv)->select('id')->get();
		$mamonhoc = monhoc::where('tenmonhoc', '=', $monhoc)->select('id')->get();

		foreach ($magiaovien as $keys) {
			$giaovien = phancongchuyenmon::where('magiaovien', '=', $keys->id)->first();
			if ($giaovien === null) {
				$phanconggv = new phancongchuyenmon();
				$phanconggv->magiaovien = $keys->id;
			}
			foreach ($mamonhoc as $keyss) {
				$monhocs = phancongchuyenmon::where('mamonhoc', '=', $keyss->id)->first();
				if ($monhocs === null) {
					$phanconggv = new phancongchuyenmon();
					$phanconggv->magiaovien = $keys->id;
					$phanconggv->mamonhoc = $keyss->id;
				}
				foreach ($tenlop as $keysss) {
					$malop = danhsachlophoc::where('tenlop', '=', $keysss)->select('id')->first();			
					$phanconggv = new phancongchuyenmon();
					$phanconggv->magiaovien = $keys->id;
					$phanconggv->mamonhoc = $keyss->id;
					$phanconggv->malop = $malop->id;
					$success = $phanconggv->save();
				}
				// $success = $phanconggv->save();
			}
			// $success = $phanconggv->save();
			// return json_encode($success, JSON_UNESCAPED_UNICODE);
		}
		$giaovien = danhsachgv::where('ten', '=', $tengv)->first();
		if ($giaovien === null) {
			$giaovien = new danhsachgv();
			$giaovien->ten = $tengv;
			$giaovien->matruong = "1";
			$success = $giaovien->save();
			return json_encode($success, JSON_UNESCAPED_UNICODE);
		}
		$this->importmonhoc($monhoc);
		$this->importlophoc($tenlop);
		// return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	private function importmonhoc($monhoc){      
		$monhocs = monhoc::where('tenmonhoc', '=', $monhoc)->first();
		if ($monhocs === null) {
			$monhocs = new monhoc();
			$monhocs->tenmonhoc = $monhoc;
			$monhocs->matruong = "1";
			$success = $monhocs->save();
			return json_encode($success, JSON_UNESCAPED_UNICODE);
		}
	}
	private function importlophoc($tenlop){      
		foreach ($tenlop as $keys) {		
			$tenlop = danhsachlophoc::where('tenlop', '=', $keys)->first();
			if ($tenlop === null) {
				$key = new danhsachlophoc();
				$key->tenlop = $keys;
				$key->matruong = '1';
				$success = $key->save();
			}
		}
	}











}
