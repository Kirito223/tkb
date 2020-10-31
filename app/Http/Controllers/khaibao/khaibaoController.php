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
use App\khoihoc;
use App\phancongchuyenmon;
use App\sotietmonhoc;
use App\sotiettrongbuoi;
use App\sotietmonhoc_temp;
use App\diemtruong;
use App\giaovien_diemtruong;

use App\thututiet;
use App\danhgiagv;
use App\giaovienmonlop;
use App\phongmonlop;
use App\rangbuoccaptietxepliennhau;
use App\rangbuocdangkybuoitietnghigv;
use App\rangbuocdangkytietnghilop;
use App\rangbuocsotiet5sangtiet1chieu;
use App\rangbuoctietcodinh;
use App\rangbuoctietgvbuocphaico;
use App\rangbuoctiethopcuato;
use App\rangbuoctiettranh;
use App\rangbuoctranh2moncungbuoi;
use App\sotietbuoi;
use App\thoikhoabieu;
use App\sotietngay;
use App\thoikhoabieuexcel;
use App\thutumon;
use App\tietcodinh;
use App\tietghep;
use App\tiethopcuato;
use App\tietnghigiaovien;

use Illuminate\Support\Facades\DB;
use stdClass;
use Session; 
use App\thongbao;

class khaibaoController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('khaibao.index',compact('thongbao', 'thongbaocount'));
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
		$matruong = Session::get('matruong');
		$idgv = $rq->id;
		foreach ($idgv as $key) {
			foreach ($key as $value) {
				$danhsachgv = danhsachgv::where('matruong',$matruong)->delete($value);
			}	
			
		}
		$khoi = khoihoc::where('matruong',$matruong)->delete();
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
	
	
	
	//diem truong
	public function getdanhsachdiemtruong(){
		$matruong = Session::get('matruong');
		$data =  diemtruong::where('matruong',$matruong)->get();
		$gvdiemtruong =  giaovien_diemtruong::where('matruong',$matruong)->get();
		$gv =  danhsachgv::where('matruong',$matruong)->get();
		$lop =  danhsachlophoc::where('matruong',$matruong)->orderBy('tenlop', 'ASC')->get();
		$mon =  monhoc::where('matruong',$matruong)->get();
		return json_encode([$data,$gvdiemtruong,$gv,$lop,$mon], JSON_UNESCAPED_UNICODE);
	}
	public function updatediemtruong(Request $rq){
		$matruong = Session::get('matruong');
		$data = diemtruong::find($rq->id);
		$data->tendiemtruong = $rq->tendiemtruong;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function adddiemtruong(Request $rq){
		$matruong = Session::get('matruong');
		$data =  new diemtruong();
		$data->tendiemtruong = $rq->tendiemtruong;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function deldiemtruong(Request $rq){
		$matruong = Session::get('matruong');
		$tendiemtruong = $rq->tendiemtruong;
		$data = diemtruong::where(function($query)use($tendiemtruong,$matruong) {
			$query->where('tendiemtruong',$tendiemtruong);
			$query->where('matruong',$matruong);
		})->delete();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function updategvdiemtruong(Request $rq){
		$matruong = Session::get('matruong');
		$data = diemtruong::find($rq->id);
		$data->tendiemtruong = $rq->tendiemtruong;
		$data->malop = $rq->malop;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function addgvdiemtruong(Request $rq){
		$matruong = Session::get('matruong');
		$tendiemtruong = $rq->tendiemtruong;
		$malop = $rq->malop;
		$data = diemtruong::where(function($query)use($tendiemtruong,$matruong) {
			$query->where('tendiemtruong',$tendiemtruong);
			$query->where('matruong',$matruong);
		})->delete();
		foreach($malop as $key){
			$data =  new diemtruong();
			$data->tendiemtruong = $tendiemtruong;
			$data->malop = $key;
			$data->matruong = $matruong;
			$success = $data->save();
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function delgvdiemtruong(Request $rq){
		$matruong = Session::get('matruong');
		$data = diemtruong::destroy($rq->id);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
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
		$datagvtocm = giaovien_chuyenmon::where('matruong',$matruong)->get();
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
		$matruong = Session::get('matruong');
		$gv = $rq->magiaovien;
		$tocm = $rq->matochuyenmon;
		$monhoc =$rq->mamonhoc;
		$mucrangbuoc = $rq->mucrangbuoc;
		foreach ($monhoc as $key) {
			$giaovien_chuyenmon = new giaovien_chuyenmon();
			$giaovien_chuyenmon->magiaovien = $rq->magiaovien;
			$giaovien_chuyenmon->mamonhoc = $key;
			$giaovien_chuyenmon->matruong = $matruong;
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
		$matruong = Session::get('matruong');
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
				$key->matruong = $matruong;
				$success = $key->save();
			}
		}else{
			foreach ($monhoc as $keys) {
				$key = new giaovien_chuyenmon();
				$key->magiaovien = $gvnew;
				$key->matochuyenmon = $tocm;
				$key->mucrangbuoc = $mucrangbuoc;
				$key->mamonhoc = $keys;
				$key->matruong = $matruong;
				$success = $key->save();
			}
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	public function deldanhsachgvphancong(Request $rq){
		$matruong = Session::get('matruong');
		$magv = $rq->id;
		$giaovien =	giaovien_chuyenmon::where(function($query)use($magv,$matruong) {
			$query->where('magiaovien',$magv);
			$query->where('matruong',$matruong);
		})->delete();
		return json_encode($giaovien, JSON_UNESCAPED_UNICODE);
	}

	public function deldanhsachgvphancongall(Request $rq)
	{	
		$matruong = Session::get('matruong');
		$magv = $rq->id;
		foreach ($magv as $key) {
			$magvs = (object)$key;
			$aaa = $magvs->magiaovien;
			$giaovien =	giaovien_chuyenmon::where(function($query)use($aaa,$matruong) {
				$query->where('magiaovien',$aaa);
				$query->where('matruong',$matruong);
			})->delete();	
			
		}
		return json_encode($giaovien, JSON_UNESCAPED_UNICODE);		
	}



	// danh sách phòng học bộ môn
	public function getdanhsachphonghocbomon(){
		$matruong = Session::get('matruong');
		$data =  phonghoc::where('matruong',$matruong)->orderBy('tenphong', 'ASC')->get();
		$monhoc = monhoc::where('matruong',$matruong)->get();
		return json_encode([$data,$monhoc], JSON_UNESCAPED_UNICODE);
	}
	public function updatemonphonghoc(Request $rq){
		$matruong = Session::get('matruong');
		$phonghocbomon = phonghoc::find($rq->id);
		$phonghocbomon->tenphong =  $rq->tenphong;
		$phonghocbomon->mamonhoc = $rq->mamonhoc;
		$success = $phonghocbomon->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function addmonphonghoc(Request $rq){
		$matruong = Session::get('matruong');
		$phonghocbomon = new phonghoc();
		$phonghocbomon->tenphong =  $rq->tenphong;
		$phonghocbomon->mamonhoc = $rq->mamonhoc;
		$phonghocbomon->matruong = $matruong;
		$phonghocbomon->trangthai = "1";
		$success = $phonghocbomon->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function adddanhsachphonghocbomon(Request $rq){
		$matruong = Session::get('matruong');
		$phonghocbomon = new phonghoc();
		$phonghocbomon->tenphong = $rq->tenphonghoc;
		$phonghocbomon->matruong = $matruong;
		$phonghocbomon->trangthai = "1";
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
		$tenphong = $rq->tenphong;
		$matruong = Session::get('matruong');
		$data = phonghoc::where(function($query)use($tenphong,$matruong) {
			$query->where('tenphong',$tenphong);
			$query->where('matruong',$matruong);
		})->delete();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function dellmonphonghoc(Request $rq)
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

		$danhsachlophoc = danhsachgv::where(function($query)use($id,$matruong) {
			$query->where('id', '=', $id);
			$query->where('matruong',$matruong);
		})->select('id')->first();

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
		->join('danhsachlophoc','danhsachlophoc.id','=','sotiettrongbuoi.malop')->where('danhsachlophoc.trangthai','1')
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
		$lop = danhsachlophoc::where('matruong',$matruong)->where('trangthai','1')->orderBy('tenlop', 'ASC')->get();
		return json_encode([$new_data,$lop], JSON_UNESCAPED_UNICODE);
	}

	public function getdssotiettrongbuoi(){
		$matruong = Session::get('matruong');
		$data = sotiettrongbuoi::where('matruong',$matruong)->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//update s? ti?t trong bu?i c?a m?i l?p
	public function updatesotiettrongbuoi(Request $rq){
		$matruong = Session::get('matruong');
		$malop = $rq->malop;
		if($rq->id!=0&&$rq->thu!=0)
		{
			$sotiettrongbuoi = sotiettrongbuoi::find($rq->id);		
			if($sotiettrongbuoi != null){			
				$sotiettrongbuoi->sotiet = $rq->sotiet;
				$sotiettrongbuoi->update();
				$success = 1;
			}else{
				foreach($malop as $key){
					$sotiettrongbuoi= new sotiettrongbuoi;
					$sotiettrongbuoi->malop = $key;
					$sotiettrongbuoi->buoi = $rq->buoi;
					$sotiettrongbuoi->thu = $i;
					$sotiettrongbuoi->sotiet = $rq->sotiet;
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->save();
				}	
				$success = 1;	
			}	
		}
		else
		{
			if($malop[0] == "0"){
				$ml = danhsachlophoc::where('matruong',$matruong)->get();
				foreach($ml as $keys){
					$data = sotiettrongbuoi::where('matruong',$matruong)
					->where('malop',$keys->id)
					->where('buoi',$rq->buoi)
					->delete();
					for($i=2;$i<=7;$i++)
					{					
						$sotiettrongbuoi= new sotiettrongbuoi;
						$sotiettrongbuoi->malop = $keys->id;
						$sotiettrongbuoi->buoi = $rq->buoi;
						$sotiettrongbuoi->thu = $i;
						$sotiettrongbuoi->sotiet = $rq->sotiet;
						$sotiettrongbuoi->matruong = $matruong;
						$sotiettrongbuoi->save();
						
					}
				}
				$success = 1;

			}else{
				if($rq->thu == 0){
					foreach($malop as $key){
						$data = sotiettrongbuoi::where('matruong',$matruong)
						->where('malop',$key)
						->where('buoi',$rq->buoi)
						->delete();
						for($i=2;$i<=7;$i++)
						{					
							$sotiettrongbuoi= new sotiettrongbuoi;
							$sotiettrongbuoi->malop = $key;
							$sotiettrongbuoi->buoi = $rq->buoi;
							$sotiettrongbuoi->thu = $i;
							$sotiettrongbuoi->sotiet = $rq->sotiet;
							$sotiettrongbuoi->matruong = $matruong;
							$sotiettrongbuoi->save();						
						}
					}
					$success = 1;	
				}else if($rq->thu != 0){
					foreach($malop as $key){
						$data = sotiettrongbuoi::where('matruong',$matruong)
						->where('malop',$key)
						->where('thu',$rq->thu)
						->where('buoi',$rq->buoi)
						->delete();					
						$sotiettrongbuoi= new sotiettrongbuoi;
						$sotiettrongbuoi->malop = $key;
						$sotiettrongbuoi->buoi = $rq->buoi;
						$sotiettrongbuoi->thu = $rq->thu;
						$sotiettrongbuoi->sotiet = $rq->sotiet;
						$sotiettrongbuoi->matruong = $matruong;
						$sotiettrongbuoi->save();						
					}
					$success = 1;	
				}
			}
		}
		return json_encode($success);
	}
	public function addsotiettrongbuoi(){
		$matruong = Session::get('matruong');
		$dslophoc = danhsachlophoc::where('matruong',$matruong)->select('id')->get();
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
		$data =  danhsachlophoc::where('matruong',$matruong)->where('trangthai',"1")->with(['monhoc'=>function($author) use($matruong){
			$author->where('monhoc.matruong',$matruong);
			$author->where('monhoc.trangthai',"1");
			$author->select('sotietmonhoc.id','monhoc.id as mamonhoc','monhoc.tenmonhoc','sotietmonhoc.sotiet','sotietmonhoc.malop','monhoc.trangthai','monhoc.matruong');
		}])->where('danhsachlophoc.trangthai',"1")
		->orderBy('danhsachlophoc.tenlop', 'ASC')->select('id','tenlop')
		->get();

		$datalop = danhsachlophoc::where(function($query)use($matruong){				
			$query->where('matruong',$matruong);
			$query->where('trangthai',"1");
		})->orderBy('tenlop', 'ASC')->get();

		$datamon = monhoc::where(function($query)use($matruong){				
			$query->where('matruong',$matruong);
			$query->where('trangthai',"1");
		})->get();
		return json_encode([$data,$datalop,$datamon], JSON_UNESCAPED_UNICODE);
	}
	
		public function capnhatsotietmoimon(Request $rq){
		$matruong = Session::get('matruong');
		$lop = $rq->lop;
		$mon = $rq->mon;
		$sotiet = $rq->sotiet;
		if($lop[0] == "0"){
			$ml = danhsachlophoc::where('matruong',$matruong)->get();
			foreach($ml as $keys){
				$datasotietmonhoc = sotietmonhoc::where(function($query)use($matruong,$keys,$mon){				
					$query->where('matruong',$matruong);
					$query->where('malop',$keys->id);
					$query->where('mamonhoc',$mon);
				})->delete();			
				$sotietmonhoc= new sotietmonhoc;
				$sotietmonhoc->malop = $keys->id;
				$sotietmonhoc->mamonhoc = $mon;
				$sotietmonhoc->sotiet = $sotiet;
				$sotietmonhoc->matruong = $matruong;
				$sotietmonhoc->save();
			}
			$success = 1;
		}else{
			foreach ($lop as $key) {
				$datasotietmonhoc = sotietmonhoc::where(function($query)use($matruong,$key,$mon){				
					$query->where('matruong',$matruong);
					$query->where('malop',$key);
					$query->where('mamonhoc',$mon);
				})->first();

				if($datasotietmonhoc != null){
					$datasotietmonhoc->sotiet = $sotiet;
					$datasotietmonhoc->update();
					$success = 1;
				}else{
					$sotietmonhoc= new sotietmonhoc;
					$sotietmonhoc->malop = $key;
					$sotietmonhoc->mamonhoc = $mon;
					$sotietmonhoc->sotiet = $sotiet;
					$sotietmonhoc->matruong = $matruong;
					$sotietmonhoc->save();
					$success = 1;	
				}			
			}	
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	//update s? ti?t ? m?i môn c?a m?i l?p
	public function updatesotietmoimon(Request $rq){
		$matruong = Session::get('matruong');
		$caphoc = Session::get('caphoc');
		$mahuyen = Session::get('mahuyen');
		$sotietmonhoc = sotietmonhoc::where('matruong',$matruong)->delete();
		$mamonhoc = $rq->mamonhoc;
		$sotietmh = $rq->sotiet;
		$malop = $rq->malop;
		if($rq->mamonhoc!=0)
		{
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
		}
		else
		{
			$makhoi=$caphoc;
			if($makhoi == 1){
				$dsmon= sotietmonhoc_temp::whereBetween('khoi', [1, 5])->where('mahuyen',$mahuyen)->get();
			}else if($makhoi == 2){
				$dsmon= sotietmonhoc_temp::whereBetween('khoi', [6, 9])->where('mahuyen',$mahuyen)->get();
			}else if($makhoi == 3){
				$dsmon= sotietmonhoc_temp::whereBetween('khoi', [10, 12])->where('mahuyen',$mahuyen)->get();
			}	



			
			foreach ($dsmon as $row) 
			{	
				$tbxoa= sotietmonhoc::where('malop',$row->khoi)->delete();

			//lấy ds lớp theo khối
				if($makhoi == 1){
					$dslop = danhsachlophoc::where(function($query)use($matruong,$row){
						$query->where('matruong',$matruong);
						$query->where('khoi',$row->khoi);
					})->orderBy('tenlop', 'ASC')->get();
				}else if($makhoi == 2){
					$dslop = danhsachlophoc::where(function($query)use($matruong,$row){
						$query->where('matruong',$matruong);
						$query->where('khoi',$row->khoi);
					})->orderBy('tenlop', 'ASC')->get();
				}else if($makhoi == 3){
					$dslop = danhsachlophoc::where(function($query)use($matruong,$row){
						$query->where('matruong',$matruong);
						$query->where('khoi',$row->khoi);
					})->orderBy('tenlop', 'ASC')->get();
				}	


				foreach ($dslop as $lophoc) 
				{
					$tbmonhoc=monhoc::where('matruong',$matruong)
					->where('tenmonhoc',$row->tenmon)->first();
					if($tbmonhoc!=null)
					{
						$sotietmonhoc= new sotietmonhoc;
						$sotietmonhoc->malop = $lophoc->id;
						$sotietmonhoc->mamonhoc = $tbmonhoc['id'];
						$sotietmonhoc->sotiet = $row->sotiet;
						$sotietmonhoc->matruong = $matruong;
						$sotietmonhoc->save();
					}
				}
			}
			// thêm môn mặc định
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
		$matruong = Session::get('matruong');		


		$danhsachgv = danhsachgv::where('matruong',$matruong)->delete();
		$danhsachlophoc = danhsachlophoc::where('matruong',$matruong)->delete();
		$giaovien_chuyenmon = giaovien_chuyenmon::where('matruong',$matruong)->delete();
		$khoihoc = khoihoc::where('matruong',$matruong)->delete();
		$monhoc = monhoc::where('matruong',$matruong)->delete();
		$phancongchuyenmon = phancongchuyenmon::where('matruong',$matruong)->delete();
		$tochuyenmon = tochuyenmon::where('matruong',$matruong)->delete();
		$sotiettrongbuoi = sotiettrongbuoi::where('matruong',$matruong)->delete();
		$thututiet = thututiet::where('matruong',$matruong)->delete();

		$danhgiagv = danhgiagv::where('matruong',$matruong)->delete();
		$diemtruong = diemtruong::where('matruong',$matruong)->delete();
		$giaovien_mon_lop = giaovienmonlop::where('matruong',$matruong)->delete();
		$phonghoc = phonghoc::where('matruong',$matruong)->delete();
		$phongmonlop = phongmonlop::where('matruong',$matruong)->delete();
		$rangbuoccaptietxepliennhau = rangbuoccaptietxepliennhau::where('matruong',$matruong)->delete();
		$rangbuocdangkybuoitietnghigv = rangbuocdangkybuoitietnghigv::where('matruong',$matruong)->delete();
		$rangbuocdangkytietnghilop = rangbuocdangkytietnghilop::where('matruong',$matruong)->delete();
		$rangbuocsotiet5sangtiet1chieu = rangbuocsotiet5sangtiet1chieu::where('matruong',$matruong)->delete();
		$rangbuoctietcodinh = rangbuoctietcodinh::where('matruong',$matruong)->delete();
		$rangbuoctietgvbuocphaico = rangbuoctietgvbuocphaico::where('matruong',$matruong)->delete();
		$rangbuoctiethopcuato = rangbuoctiethopcuato::where('matruong',$matruong)->delete();
		$rangbuoctiettranh = rangbuoctiettranh::where('matruong',$matruong)->delete();
		$rangbuoctranh2moncungbuoi = rangbuoctranh2moncungbuoi::where('matruong',$matruong)->delete();
		$sotietbuoi = sotietbuoi::where('matruong',$matruong)->delete();
		$sotietmonhoc = sotietmonhoc::where('matruong',$matruong)->delete();
		$sotietngay = sotietngay::where('matruong',$matruong)->delete();
		$thoikhoabieu = thoikhoabieu::where('matruong',$matruong)->delete();
		$thoikhoabieuexcel = thoikhoabieuexcel::where('matruong',$matruong)->delete();
		$thutumon = thutumon::where('matruong',$matruong)->delete();
		$tietcodinh = tietcodinh::where('matruong',$matruong)->delete();
		$tietghep = tietghep::where('matruong',$matruong)->delete();
		$tiethoc = tiethoc::where('matruong',$matruong)->delete();
		$tiethopcuato = tiethopcuato::where('matruong',$matruong)->delete();
		$tietnghigiaovien = tietnghigiaovien::where('matruong',$matruong)->delete();



		$request = $rq->request;
		foreach ($request as $datas1 => $data) {	
			$datas = (object)$data;
			$tengv = $datas->tengv;
			$tenlop = $datas->tenlop;
			$monhoc = $datas->monhoc;
			$tochuyenmon = $datas->tochuyenmon;
			
			$dongvipham1 = $datas1+1;
			$dongvipham2 = $datas1+2;
			
			if($datas->email == null){
				$email = '';
			}else{
				$email = $datas->email;
				$chuoicantim  = '@gmail.com';
				$pos = strpos($email, $chuoicantim);
				if ($pos === false) {
					return json_encode([$datas,3000,$dongvipham2], JSON_UNESCAPED_UNICODE);
				}
			}
			
			if($datas->sdt == null){
				$sdt = '';
			}else{
				$sdt = $datas->sdt;				
				if (!is_numeric($sdt)){
					return json_encode([$datas,2000,$dongvipham2], JSON_UNESCAPED_UNICODE);
				}
			}





			if($tengv != null){
				$giaovien = danhsachgv::where(function($query)use($tengv,$matruong) {
					$query->where('hovaten', '=', $tengv);
					$query->where('matruong',$matruong);
				})->first();
				if ($giaovien === null) {
					$giaovien = new danhsachgv();
					$giaovien->hovaten = $tengv;
					
					$name1 = explode(" ",$tengv);
					$countname = count($name1);
					if($countname == 2){
						$last_name1 = $name1[0];
						$last_name2 = $name1[1];
						$isTouch = empty($name1[3]);
						if( $isTouch != true){
							$last_name3 = $name1[3];
							$bidanhloc = $last_name1 . "-" . $last_name2 ." ".$last_name3;
						}else{
							$bidanhloc = $last_name1 . "-" . $last_name2;
						}	
						$giaovien->bidanh = $bidanhloc;
					}else if($countname < 4){
						$last_name1 = $name1[1];
						$last_name2 = $name1[2];
						$isTouch = empty($name1[3]);
						if( $isTouch != true){
							$last_name3 = $name1[3];
							$bidanhloc = $last_name1 . "-" . $last_name2 ." ".$last_name3;
						}else{
							$bidanhloc = $last_name1 . "-" . $last_name2;
						}	
						$giaovien->bidanh = $bidanhloc;
					}else if($countname < 5){
						$last_name1 = $name1[2];
						$last_name2 = $name1[3];
						$isTouch = empty($name1[4]);
						if( $isTouch != true){
							$last_name3 = $name1[4];
							$bidanhloc = $last_name1 . "-" . $last_name2 ." ".$last_name3;
						}else{
							$bidanhloc = $last_name1 . "-" . $last_name2;
						}		
						$giaovien->bidanh = $bidanhloc;
					}else if($countname < 6){
						$last_name1 = $name1[3];
						$last_name2 = $name1[4];
						$isTouch = empty($name1[5]);
						if( $isTouch != true){
							$last_name3 = $name1[5];
							$bidanhloc = $last_name1 . "-" . $last_name2 ." ".$last_name3;
						}else{
							$bidanhloc = $last_name1 . "-" . $last_name2;
						}		
						$giaovien->bidanh = $bidanhloc;
					}
					$giaovien->email = $email;
					$giaovien->dienthoai = $sdt;
					$giaovien->trangthai = 1;
					$giaovien->matruong = $matruong;
					$success = $giaovien->save();
				}
			}



			if($tochuyenmon != null){
				$tochuyenmons = tochuyenmon::where(function($query)use($tochuyenmon,$matruong) {
					$query->where('tentocm', '=', $tochuyenmon);
					$query->where('matruong',$matruong);
				})->first();
				if ($tochuyenmons === null) {
					$tochuyenmons = new tochuyenmon();
					$tochuyenmons->tentocm = $tochuyenmon;
					$tochuyenmons->matruong = $matruong;
					$tochuyenmons->trangthai = 1;
					$success = $tochuyenmons->save();
				}
			}else if($tochuyenmon == null){
				$tochuyenmons = tochuyenmon::where(function($query)use($tochuyenmon,$matruong) {
					$query->where('tentocm', '=', 'Tổ chủ nhiệm');
					$query->where('matruong',$matruong);
				})->first();
				if ($tochuyenmons === null) {
					$tochuyenmons = new tochuyenmon();
					$tochuyenmons->tentocm = 'Tổ chủ nhiệm';
					$tochuyenmons->matruong = $matruong;
					$tochuyenmons->trangthai = 1;
					$success = $tochuyenmons->save();
				}
			}




				if($monhoc != null){
					$monhocs = monhoc::where(function($query)use($monhoc,$matruong) {
						$query->where('tenmonhoc', '=', $monhoc);
						$query->where('matruong',$matruong);
					})->first();
					if ($monhocs === null) {
						$monhocs = new monhoc();				
	
						$monhocs->tenmonhoc = $monhoc;
						$BD = explode(" ",$monhoc);
						$countBD = count($BD);
	
	
	
						if($countBD == 1){
							$BD1 = $BD[0];
							$BDs = substr($BD1,0,1);
							$monvt = $BDs;
							$monhocs->monhocviettat = $monvt;
						}else if($countBD == 2){
							$BD1 = $BD[0];
							$BDs = mb_substr ($BD1,0,1);
							$BD2 = $BD[1];
							$monvt = $BDs. "-" .$BD2;
							$monhocs->monhocviettat = $monvt;
						}else if($countBD == 3){
							$BD1 = $BD[0];
							$BD1s = mb_substr($BD1,0,1);
							$BD2 = $BD[1];
							$BD2s = mb_substr($BD2,0,1);
							$BD3 = $BD[2];
							$BD3s = mb_substr($BD3,0,1);
							$monvt = $BD1s. " " .$BD2s. " " .$BD3s;
							$monhocs->monhocviettat = $monvt;
						}else if($countBD == 4){
							$BD1 = $BD[0];
							$BD1s = mb_substr($BD1,0,1);
							$BD2 = $BD[1];
							$BD2s = mb_substr($BD2,0,1);
							$BD3 = $BD[2];
							$BD3s = mb_substr($BD3,0,1);
							$BD4 = $BD[3];
							$BD4s = mb_substr($BD4,0,1);
							$monvt = $BD1s. " " .$BD2s. " " .$BD3s. " " .$BD4s;
							$monhocs->monhocviettat = $monvt;
						}else if($countBD == 5){
							$BD1 = $BD[0];
							$BD1s = mb_substr($BD1,0,1);
							$BD2 = $BD[1];
							$BD2s = mb_substr($BD2,0,1);
							$BD3 = $BD[2];
							$BD3s = mb_substr($BD3,0,1);
							$BD4 = $BD[3];
							$BD4s = mb_substr($BD4,0,1);
							$BD5 = $BD[4];
							$BD5s = mb_substr($BD5,0,1);
							$monvt = $BD1s. " " .$BD2s. " " .$BD3s. " " .$BD4s. " " .$BD5s;
							$monhocs->monhocviettat = $monvt;
						}
	
						$monhocs->matruong = $matruong;
						$tochuyenmonss = tochuyenmon::where(function($query)use($tochuyenmon,$matruong) {
							if($tochuyenmon == null){
								$query->where('tentocm', '=', 'Tổ chủ nhiệm');
							}else{
								$query->where('tentocm', '=', $tochuyenmon);
							}					
							$query->where('matruong',$matruong);
						})->select('id')->first();
						$monhocs->matochuyenmon = $tochuyenmonss->id;
						$monhocs->trangthai = 1;
						$success = $monhocs->save();
					}
				}
			
			

			foreach ($tenlop as $keys) {	
				$st1 = str_replace("("," ",$keys);
				$st2 = str_replace(")","",$st1);
				$st = explode(' ', $st2);
				$tenlopss = $st[0];





				$tenlops = danhsachlophoc::where(function($query)use($tenlopss,$matruong) {
					$query->where('tenlop', '=', $tenlopss);
					$query->where('matruong',$matruong);
				})->first();
				
				$tenkhois = substr($tenlopss,0,1); 

				if (!is_numeric($tenkhois)){
					return json_encode([$datas,1000,$dongvipham1], JSON_UNESCAPED_UNICODE);
				}

				$khois = khoihoc::where(function($query)use($tenkhois,$matruong) {
					$query->where('tenkhoi', '=', $tenkhois);
					$query->where('matruong',$matruong);
				})->first();
				if ($khois === null) {
					$khoi =  new khoihoc();
					$khoi->tenkhoi = $tenkhois;
					$khoi->matruong = $matruong;
					$success = $khoi->save();
				}
				
				if ($tenlops === null) {
					$tenlops = new danhsachlophoc();
					$tenlops->tenlop = $tenlopss;
					$name1 = substr($tenlopss,0,1); 
					$tenlops->khoi = $name1;
					$tenlops->matruong = $matruong;
					$tenlops->trangthai = 1;
					$success = $tenlops->save();
				}
			}


			





			

			$magiaovien = danhsachgv::where(function($query)use($tengv,$matruong) {
				$query->where('hovaten', '=', $tengv);
				$query->where('matruong',$matruong);
			})->select('id')->get();

			$mamonhoc = monhoc::where(function($query)use($monhoc,$matruong) {
				$query->where('tenmonhoc', '=', $monhoc);
				$query->where('matruong',$matruong);
			})->select('id')->get();


			foreach ($magiaovien as $keys) {
				$giaovien = phancongchuyenmon::where(function($query)use($keys,$matruong) {
					$query->where('magiaovien', '=', $keys->id);
					$query->where('matruong',$matruong);
				})->first();
				if ($giaovien === null) {
					$phanconggv = new phancongchuyenmon();
					$phanconggv->magiaovien = $keys->id;
				}
				

				foreach ($mamonhoc as $keyss) {
					$monhocs = phancongchuyenmon::where(function($query)use($keyss,$matruong) {
						$query->where('mamonhoc', '=', $keyss->id);
						$query->where('matruong',$matruong);
					})->first();



					$tochuyenmonid = tochuyenmon::where(function($query)use($tochuyenmon,$matruong) {
						if($tochuyenmon == null){
							$query->where('tentocm', '=', 'Tổ chủ nhiệm');
						}else{
							$query->where('tentocm', '=', $tochuyenmon);
						}					
						$query->where('matruong',$matruong);
					})->select('id')->first();

					$monhocpc = giaovien_chuyenmon::where(function($query)use($keys,$keyss,$tochuyenmonid,$matruong) {
						$query->where('magiaovien',$keys->id);
						$query->where('mamonhoc',$keyss->id);
						$query->where('matochuyenmon',$tochuyenmonid->id);
						$query->where('matruong',$matruong);
					})->first();

					if($monhocpc == null){
						$monhocpc = new giaovien_chuyenmon();
						$monhocpc->magiaovien = $keys->id;
						$monhocpc->mamonhoc = $keyss->id;
						$monhocpc->matochuyenmon = $tochuyenmonid->id;
						$monhocpc->matruong = $matruong;
						$success = $monhocpc->save();
					}

					


					if ($monhocs === null) {
						$phanconggv = new phancongchuyenmon();
						$phanconggv->magiaovien = $keys->id;
						$phanconggv->mamonhoc = $keyss->id;
					}
					foreach ($tenlop as $keysss1 => $keysss) {		
						$st1 = str_replace("("," ",$keysss);
						$st2 = str_replace(")","",$st1);
						$st = explode(' ', $st2);
						$tenlop1 = $st[0];
						$sotiets = $st[1];


						if (!is_numeric($sotiets)){
							return json_encode([$datas,1000,$dongvipham1], JSON_UNESCAPED_UNICODE);
						}

						$malop = danhsachlophoc::where(function($query)use($tenlop1,$matruong) {
							$query->where('tenlop', '=', $tenlop1);
							$query->where('matruong',$matruong);
						})->select('id')->first();

						$phanconglop = phancongchuyenmon::where(function($query)use($keys,$keyss,$malop,$matruong) {
							$query->where('magiaovien', '=', $keys->id);
							$query->where('mamonhoc', '=', $keyss->id);
							$query->where('malop', '=', $malop->id);
							$query->where('matruong',$matruong);
						})->first();

						if($phanconglop === null ){
							$phanconggv = new phancongchuyenmon();
							$phanconggv->magiaovien = $keys->id;
							$phanconggv->mamonhoc = $keyss->id;
							$phanconggv->malop = $malop->id;
							$phanconggv->sotiet = $sotiets;
							$phanconggv->matruong = $matruong;
							$success = $phanconggv->save();
						}
					}
				}
			}
		}
	}

	public function importexcelsotiettrongbuoi(Request $rq){
		$matruong = Session::get('matruong');		
		$datadel = sotiettrongbuoi::where('matruong',$matruong)->delete();
		$request = $rq->request;
		$dslophoc = danhsachlophoc::where('matruong',$matruong)->get();

		foreach($dslophoc as $key){
			$malop = danhsachlophoc::where(function($query)use($key,$matruong) {
				$query->where('id',$key->id);
				$query->where('matruong',$matruong);
			})->select('id')->first();

			for ($i=0; $i < 12; $i++) { 
				if($i == 0){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 2;
					$success = $sotiettrongbuoi->save();
				}else if($i == 1){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 3;
					$success = $sotiettrongbuoi->save();
				}else if($i == 2){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 4;
					$success = $sotiettrongbuoi->save();
				}else if($i == 3){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 5;
					$success = $sotiettrongbuoi->save();
				}else if($i == 4){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 6;
					$success = $sotiettrongbuoi->save();
				}else if($i == 5){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 0;
					$sotiettrongbuoi->thu = 7;
					$success = $sotiettrongbuoi->save();
				}else if($i == 6){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 2;
					$success = $sotiettrongbuoi->save();
				}else if($i == 7){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 3;
					$success = $sotiettrongbuoi->save();
				}else if($i == 8){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 4;
					$success = $sotiettrongbuoi->save();
				}else if($i == 9){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 5;
					$success = $sotiettrongbuoi->save();
				}else if($i == 10){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 6;
					$success = $sotiettrongbuoi->save();
				}else if($i == 11){
					$sotiettrongbuoi = new sotiettrongbuoi();
					$sotiettrongbuoi->matruong = $matruong;
					$sotiettrongbuoi->malop = $malop->id;
						// $sotiettrongbuoi->sotiet = $sotiets;
					$sotiettrongbuoi->buoi = 1;
					$sotiettrongbuoi->thu = 7;
					$success = $sotiettrongbuoi->save();
				}
			}
		}		
	}

//public function importexcelsotiettrongbuoi(Request $rq){
	// 	$datadel = sotiettrongbuoi::query()->delete();
	// 	$matruong = Session::get('matruong');		
	// 	$request = $rq->request;
	// 	foreach ($request as $data) {	
	// 		$datas = (object)$data;
	// 		$tenlop = $datas->tenlop;

	// 		foreach($tenlop as $keys){
	// 			$st1 = str_replace("("," ",$keys);
	// 			$st2 = str_replace(")","",$st1);
	// 			$st = explode(' ', $st2);
	// 			$tenlop1 = $st[0];
	// 			$sotiets = $st[1];

	// 			$malop = danhsachlophoc::where(function($query)use($tenlop1,$matruong) {
	// 				$query->where('tenlop', '=', $tenlop1);
	// 				$query->where('matruong',$matruong);
	// 			})->select('id')->first();

	// 			for ($i=0; $i < 12; $i++) { 
	// 				if($i == 0){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 0;
	// 					$sotiettrongbuoi->thu = 2;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 1){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 0;
	// 					$sotiettrongbuoi->thu = 3;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 2){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 0;
	// 					$sotiettrongbuoi->thu = 4;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 3){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 0;
	// 					$sotiettrongbuoi->thu = 5;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 4){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 0;
	// 					$sotiettrongbuoi->thu = 6;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 5){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 0;
	// 					$sotiettrongbuoi->thu = 7;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 6){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 1;
	// 					$sotiettrongbuoi->thu = 2;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 7){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 1;
	// 					$sotiettrongbuoi->thu = 3;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 8){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 1;
	// 					$sotiettrongbuoi->thu = 4;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 9){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 1;
	// 					$sotiettrongbuoi->thu = 5;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 10){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 1;
	// 					$sotiettrongbuoi->thu = 6;
	// 					$success = $sotiettrongbuoi->save();
	// 				}else if($i == 11){
	// 					$sotiettrongbuoi = new sotiettrongbuoi();
	// 					$sotiettrongbuoi->matruong = $matruong;
	// 					$sotiettrongbuoi->malop = $malop->id;
	// 					$sotiettrongbuoi->sotiet = $sotiets;
	// 					$sotiettrongbuoi->buoi = 1;
	// 					$sotiettrongbuoi->thu = 7;
	// 					$success = $sotiettrongbuoi->save();
	// 				}
	// 			}
	// 		}
	// 	}
	// }








}
