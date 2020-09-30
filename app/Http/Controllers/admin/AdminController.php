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
use Hash;
use App\roles;
use stdClass;
use Session; 

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
			$data =  DB::table('tbl_admin')->get();
		}else{
			$data =  DB::table('tbl_admin')->where('matruong',$matruong)->get();
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
		$data =  DB::table('truong')->get();
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


}
