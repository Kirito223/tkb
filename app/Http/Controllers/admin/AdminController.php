<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_admin;
use App\truong;
use App\huyen;
use App\tochuyenmon;
use App\khoihoc;
use App\giaovien_chuyenmon;
use App\phancongchuyenmon;
use App\sotiettrongbuoi;
use App\monhoc;
use App\xa;
use App\danhsachgv;
use App\danhsachlophoc;
use App\thututiet;
use App\sotietmonhoc_temp;
use Hash;
use App\roles;
use stdClass;
use Session; 

use App\tiethoc;
use App\sotietmonhoc;
use App\phonghoc;
use App\diemtruong;
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

class AdminController extends Controller
{
	public function viewtaikhoan()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('admin.taikhoan');
	}
	public function viewphanquyen()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('admin.phanquyen');
	}
	public function viewhuyen()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('admin.huyen');
	}
	public function viewxa()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('admin.xa');
	}
	public function viewtruong()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('admin.truong');
	}
	public function getlisttaikhoan(){
		$matruong = Session::get('matruong');
		if($matruong == null){
			$data =  DB::table('tbl_admin')->orderBy('id', 'DESC')->get();
		}else{
			$data =  DB::table('tbl_admin')->where('matruong',$matruong)->orderBy('id', 'DESC')->get();
		}
		
		$lopcount = danhsachlophoc::all();
		$gvcount = danhsachgv::all();
		
		$huyen = huyen::all();
		$truong = truong::all();
		$xa = xa::all();
		$quyen = roles::all();

		$datas = [];
		$obj  = new stdClass;
		$obj->huyen = $huyen;
		$obj->xa = $xa;
		$obj->quyen = $quyen;
		$obj->truong = $truong;
		$obj->data = $data;
		$obj->lopcount = $lopcount;
		$obj->gvcount = $gvcount;
		array_push($datas, $obj);
		return json_encode($datas, JSON_UNESCAPED_UNICODE);
	}
	public function getlisttruong(){
		$data =  DB::table('truong')->orderBy('matruong', 'DESC')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function getlisthuyen(){
		$data =  DB::table('huyen')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function getlistquyen(){
		$data =  DB::table('roles')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function getlistxa(){
		$data =  DB::table('xa')->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	
	public function addtaikhoan(Request $rq){
		$data = new tbl_admin();
		$data->tentaikhoan = $rq->tentaikhoan;
		$data->password = Hash::make($rq->password);  
		$data->email = $rq->email;
		$data->matruong = $rq->truong;
		$data->mahuyen = $rq->huyen;
		$data->loaixa = $rq->xa;
		$data->level = $rq->quyen;    
		$success = $data->save();        
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function updatetaikhoan(Request $rq){
		$data = tbl_admin::find($rq->id);
		$data->tentaikhoan = $rq->tentaikhoan;
		$data->email = $rq->email;
		if($rq->level == "1"){
			$data->matruong = "";
		}else{
			$data->matruong = $rq->matruong;
		}	
		$data->mahuyen = $rq->mahuyen;
		$data->loaixa = $rq->loaixa;
		$data->level = $rq->level;    
		$success = $data->save();        
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function updatepassword(Request $rq){        
		$find = tbl_admin::find($rq->id);     
		$find->password = Hash::make($rq->password);      
		$success = $find->save();        
	}
	public function resetpassword(Request $rq){        
		$find = tbl_admin::find($rq->id);     
		$find->password = Hash::make('123456');      
		$success = $find->save();        
	}

	public function deltaikhoan(Request $rq){
		$matruong = $rq->matruong;		
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
		
		//$danhsachgv = danhsachgv::query()->delete();
		//$danhsachlophoc = danhsachlophoc::query()->delete();
		//$giaovien_chuyenmon = giaovien_chuyenmon::query()->delete();
		//$khoihoc = khoihoc::query()->delete();
		//$monhoc = monhoc::query()->delete();
		//$phancongchuyenmon = phancongchuyenmon::query()->delete();
		//$tochuyenmon = tochuyenmon::query()->delete();
		//$sotiettrongbuoi = sotiettrongbuoi::query()->delete();
		
		$success = tbl_admin::destroy($rq->id);
		
		return $success?200:500;
	}
	
	public function resetdata(Request $rq){
		$matruong = $rq->matruong;
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
		$success = 200;
		
		return $success?200:500;
	}



	public function addphanquyen(Request $rq){
		$data = new roles();
		$data->name = $rq->name;
		$data->description = $rq->description;    
		$success = $data->save();        
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function updatephanquyen(Request $rq){
		$data = roles::find($rq->id);     
		$data->name = $rq->name;
		$data->description = $rq->description;    
		$success = $data->save();        
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function delphanquyen(Request $rq){
		$success = roles::destroy($rq->id);
		return $success?200:500;
	}

		//thêm huyện
	public function addhuyen(Request $rq){
		$huyen = new huyen();
		$huyen->tenhuyen = $rq->tenhuyen;
		$success = $huyen->save();        
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	//sửa huyện
	public function updatehuyen(Request $rq){
		$mahuyen = $rq->id;
		$huyen = huyen::where('mahuyen', '=', $mahuyen)->update(array('tenhuyen' => $rq->tenhuyen));    
		return json_encode($huyen, JSON_UNESCAPED_UNICODE);
	}
	//xoá huyện
	public function delhuyen(Request $rq){
		$success = huyen::where('mahuyen', '=', $rq->id)->delete();           
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	//thêm xã
	public function addxa(Request $rq){
		$xa = new xa();
		$xa->tenxa = $rq->tenxa;
		$xa->mahuyen = $rq->mahuyen;
		$success = $xa->save();        
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	//sửa xã
	public function updatexa(Request $rq){
		$xa = xa::find($rq->id);
		$xa->tenxa = $rq->tenxa;
		$xa->mahuyen = $rq->mahuyen;
		$success = $xa->save();          
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	//xoá xã
	public function delxa(Request $rq){
		$success = xa::destroy($rq->id);          
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	//thêm trường
	public function addtruong(Request $rq){
		$truong = new truong();
		$truong->tentruong = $rq->tentruong;
		$truong->mahuyen = $rq->mahuyen;
		$truong->caphoc = $rq->caphoc;
		$truong->loaitruong = $rq->loaitruong;
		$success = $truong->save();        
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	//sửa trường
	public function updatetruong(Request $rq){
		$truong = truong::where('matruong', '=', $rq->id)->update(array('tentruong' => $rq->tentruong,'mahuyen' => $rq->mahuyen,'caphoc' => $rq->caphoc,'loaitruong' => $rq->loaitruong));   
		return json_encode($truong, JSON_UNESCAPED_UNICODE);
	}
	//xoá trường
	public function deltruong(Request $rq){
		$success = truong::where('matruong', '=', $rq->id)->delete();   
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	
	
	
	
	
	
	
	//import số tiết môn học temp
	public function viewimportsotietmonhoctemp()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('admin.importsotietmonhoctemp');
	}

	public function getDssotietmonhoctemp(){
		$dataSotietmonhoctemp = sotietmonhoc_temp::all();
		$data = [];
		foreach($dataSotietmonhoctemp as $d){
			if($d->khoi == 1 || $d->khoi == 2 || $d->khoi == 3 || $d->khoi == 4 || $d->khoi == 5){
				array_push($data,array("idstmhtemp"=>$d->id,"macaphoc"=>1,"mahuyen"=>$d->mahuyen,"tenmon"=>$d->tenmon,"khoi"=>$d->khoi,"sotiet"=>$d->sotiet));
			}

			if($d->khoi == 6 || $d->khoi == 7 || $d->khoi == 8 || $d->khoi == 9){
				array_push($data,array("idstmhtemp"=>$d->id,"macaphoc"=>2,"mahuyen"=>$d->mahuyen,"tenmon"=>$d->tenmon,"khoi"=>$d->khoi,"sotiet"=>$d->sotiet));
			}
		}
		return json_encode($data, JSON_UNESCAPED_UNICODE);

	}

	public function postexcelsotietmonhoctemp(Request $rq){
		$getDataRq = $rq->request;
		$mahuyen = 0 ;
		$khoi = 0 ;
		foreach($getDataRq as $r){
			$mahuyen = $r['mahuyen'];
			$khoi = $r['khoi'];
		}
		
		$getData = sotietmonhoc_temp::where('mahuyen',$mahuyen)->where('khoi',$khoi)->get();
		
		if($getData != ''){
			foreach($getData as $g){
				sotietmonhoc_temp::destroy($g->id);
			}
		}
		
		
		foreach($getDataRq as $rq){
			$stmh_temp = new sotietmonhoc_temp();
			$stmh_temp->mahuyen = $rq['mahuyen'];
			$stmh_temp->tenmon = $rq['tenmon'];
			$stmh_temp->khoi = $rq['khoi'];
			$stmh_temp->sotiet = $rq['sotiet'];
			$stmh_temp->save();
		}
		$success = 1;
		return json_encode($success);

	}

	//add số tiết môn học temp
	public function addsotietmonhoc_temp(Request $rq){
		$stmh_temp = new sotietmonhoc_temp();
		$stmh_temp->mahuyen = $rq->mahuyen;
		$stmh_temp->tenmon = $rq->tenmon;
		$stmh_temp->khoi = $rq->khoi;
		$stmh_temp->sotiet = $rq->sotiet;
		$stmh_temp->save();
		$success = 1;
		return json_encode($success);
	}

	//sửa số tiết môn học temp
	public function updatesotietmonhoc_temp(Request $rq){
		$stmh_temp = sotietmonhoc_temp::find($rq->id);
		$stmh_temp->mahuyen = $rq->mahuyen;
		$stmh_temp->tenmon = $rq->tenmon;
		$stmh_temp->khoi = $rq->khoi;
		$stmh_temp->sotiet = $rq->sotiet;
		$stmh_temp->update();
		$success = 1;
		return json_encode($success);
	}

	//xoá số tiết môn học temp
	public function delsotietmonhoc_temp(Request $rq)
	{
		$stmh_temp = sotietmonhoc_temp::destroy($rq->id);
		$success = 1;
		return json_encode($success);
	}

	//xoá toàn bộ số tiết môn học temp
	public function delsotietmonhoc_tempall(Request $rq)
	{	
		$id = $rq->id;
		foreach($id as $i){
			$stmh_temp = sotietmonhoc_temp::destroy($i['id']);
		}
		$success = 1;
		return json_encode($success);
	}
	
	
	
	
	
	
	
	
	
	
	
	


}
