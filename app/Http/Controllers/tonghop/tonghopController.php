<?php

namespace App\Http\Controllers\tonghop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\truong;
use App\danhsachlophoc;
use App\danhsachgv;
use App\khoihoc;
use App\phancongchuyenmon;
use App\monhoc;
use App\phonghoc;
use App\thongbao;
use App\User;
use Auth;
use DB;
use stdClass;
use Carbon;

class tonghopController extends Controller
{
	
	//xem thời khoá biểu
	public function xemthoikhoabieu()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		return view('tonghop.xemthoikhoabieu');
	}

	//thống kê
	public function thongke()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		return view('tonghop.thongke');
	}

	//theo dõi biến động thời khoá biểu
	public function theodoibiendongtkb()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable','js-datepicker'])->addStyles(['style-macdinh','style-dev','style-datatable','style-datepicker']);
		return view('tonghop.theodoibiendongtkb');
	}

	//theo dõi báo cáo đơn vị
	public function theodoibaocaodonvi()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		return view('tonghop.theodoibaocaodonvi');
	}
	//thông báo
	public function thongbao()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable','js-datepicker','js-moment'])->addStyles(['style-macdinh','style-dev','style-datatable','style-datepicker']);
		return view('tonghop.thongbao');
	}


	//lấy danh sách trường
	public function getdstruong(){
		$data = [];
		$truong = truong::all();
		foreach ($truong as $t) {
            $dstruong = new stdClass();
            $dstruong->matruong = $t->matruong;
            $dstruong->tentruong = $t->tentruong;
            $dstruong->mahuyen = $t->mahuyen;
            $dstruong->caphoc = $t->caphoc;
            $dstruong->loaitruong = $t->loaitruong;
            $lop = danhsachlophoc::where('matruong', '=',  $t->matruong)->select('id','tenlop','khoi')->get();
            $gv = danhsachgv::where('matruong','=', $t->matruong)->select('id','hovaten','bidanh','dienthoai','email')->get();
            $khoi = khoihoc::where('matruong','=', $t->matruong)->select('id','tenkhoi')->get();
            $demlop = count($lop);
            $demgv = count($gv);
            $dstruong->demdslop = $demlop;
            $dstruong->demdsgv = $demgv;
            $dstruong->danhsachlop = $lop;
            $dstruong->danhsachgv = $gv;
            $dstruong->danhsachkhoihoc = $khoi;
            array_push($data, $dstruong);
        }
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//lấy danh sách giáo viên phân công giảng dạy
	public function getdsgvpcgd(){
		$data = [];
		$truong = truong::all();
		foreach($truong as $t){
			$dstruong = new stdClass();
            $dstruong->matruong = $t->matruong;
            $dstruong->tentruong = $t->tentruong;
            $dstruong->mahuyen = $t->mahuyen;
            $dstruong->caphoc = $t->caphoc;
            $dstruong->loaitruong = $t->loaitruong;

            $datapcgd =  danhsachgv::where('matruong', '=',  $t->matruong)->with(['monhoc'=>function($author){
				$author->select('monhoc.id','monhoc.tenmonhoc','phancongchuyenmon.malop','phancongchuyenmon.magiaovien','phancongchuyenmon.mamonhoc','phancongchuyenmon.sotiet');
				$author->with(['danhsachlophoc'=>function($to){
					$to->select('danhsachlophoc.id','danhsachlophoc.tenlop');
				}]);
			}])
			->select('id','hovaten','bidanh','matruong')
			->get();

			$dataphonghoc = phonghoc::where('matruong','=', $t->matruong)
			->select('id','tenphong','matruong')
			->get();

			$dstruong->danhsachgv = $datapcgd;
			$dstruong->phonghoc = $dataphonghoc;
			array_push($data, $dstruong);
		}
		
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//lấy danh sách thông báo
	public function getdsthongbao(){

		$thongbao = DB::table('thongbao')
		->join('tbl_admin','tbl_admin.id','=','thongbao.tbl_admin_id')
		->select('thongbao.id','thongbao.truong_id','thongbao.tbl_admin_id','thongbao.sohieu','thongbao.tieude','thongbao.loai','thongbao.ngaytao','thongbao.ngaygui','thongbao.file','thongbao.noidung','thongbao.gui','thongbao.trangthai','tbl_admin.tentaikhoan')
		->get();

		$data = [];
		foreach($thongbao as $t){
			$dstb = new stdClass();
			$dstb->id = $t->id;
			$dstb->sohieu = $t->sohieu;
			$dstb->tieude = $t->tieude;
			$dstb->loai = $t->loai;
			$dstb->ngaytao = $t->ngaytao;
			$dstb->ngaygui = $t->ngaygui;
			$dstb->file = $t->file;
			$dstb->noidung = $t->noidung;
			$dstb->gui = $t->gui;
			$dstb->trangthai = $t->trangthai;
			$dstb->tentaikhoan = $t->tentaikhoan;
			$idtruong = json_decode($t->truong_id);
			$datatruong = explode(",", $idtruong);
			for($i=0;$i<count($datatruong);$i++){
				$truong = truong::where('matruong','=', $datatruong[$i])->select('matruong','tentruong')->get();
				$dstb->truong[] = $truong;
			}
			array_push($data, $dstb);
		}

		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//thêm mới thông báo
	public function addthongbao(Request $rq){
		// $Str = addslashes($iddonvi);
		// $iddonvijson = json_encode($iddonvi);
		$ngaytaofirst = strtr( $rq->idngaytao, '/', '-');
		$ngaytaoformat = date('Y-m-d', strtotime($ngaytaofirst));
		$tenfile = [];
		if(isset($_FILES['file'])){
	        if($_FILES['file']['name'] !=''){
	            $date = getdate();
	            $name_array = $_FILES['file']['name'];
	            $tmp_name_array = $_FILES['file']['tmp_name'];
	            $type_array = $_FILES['file']['type'];
	            $size_array = $_FILES['file']['size'];
	            $error_array = $_FILES['file']['error'];
                $file_name=$date['mday'].'_'.$date['mon'].'_'.$date['year'].'_'.rand(10,1000).'_'.$name_array;
                array_push($tenfile, $file_name);
                move_uploaded_file($tmp_name_array, public_path('uploads/thongbao/').$file_name);
	        }         
	    }    
		if($rq->iddonvi !=''){
			// for($i=0;$i<count($iddonvi);$i++){
				$thongbao = new thongbao();
				$thongbao->truong_id = json_encode($rq->iddonvi);
				$thongbao->tbl_admin_id = Auth::user()->id;
				$thongbao->sohieu = $rq->idsohieu;
				$thongbao->tieude = $rq->idtieude;
				$thongbao->loai = $rq->idloai;
				$thongbao->ngaytao = $ngaytaoformat;
				$thongbao->ngaygui = null;
				if($tenfile !=''){
					$thongbao->file = $tenfile[0];
				}else{
					$thongbao->file = '';
				} 
			    $thongbao->noidung = $rq->idnoidung;
			    $thongbao->gui = 0;
			    $thongbao->trangthai = 0;
			    $thongbao->save();    
			// }
		}
		$success = 1;
		return json_encode($success);
	}

	//sửa thông báo
	public function updatethongbao(Request $rq){
		// $Str = addslashes($iddonvi);
		// $iddonvijson = json_encode($iddonvi);
		$ngaytaofirst = strtr( $rq->idngaytao, '/', '-');
		$ngaytaoformat = date('Y-m-d', strtotime($ngaytaofirst));
		$tenfile = [];
		if(isset($_FILES['file'])){
	        if($_FILES['file']['name'] !=''){
	            $date = getdate();
	            $name_array = $_FILES['file']['name'];
	            $tmp_name_array = $_FILES['file']['tmp_name'];
	            $type_array = $_FILES['file']['type'];
	            $size_array = $_FILES['file']['size'];
	            $error_array = $_FILES['file']['error'];
                $file_name=$date['mday'].'_'.$date['mon'].'_'.$date['year'].'_'.rand(10,1000).'_'.$name_array;
                array_push($tenfile, $file_name);
                move_uploaded_file($tmp_name_array, public_path('uploads/thongbao/').$file_name);
	        }         
	    }    
		if($rq->iddonvi !=''){
			// for($i=0;$i<count($iddonvi);$i++){
				$thongbao = thongbao::find($rq->idthongbao);	
				$thongbao->truong_id = json_encode($rq->iddonvi);
				$thongbao->tbl_admin_id = Auth::user()->id;
				$thongbao->sohieu = $rq->idsohieu;
				$thongbao->tieude = $rq->idtieude;
				$thongbao->loai = $rq->idloai;
				$thongbao->ngaytao = $ngaytaoformat;
				if($tenfile !=''){
					$thongbao->file = $tenfile[0];
				}else{
					$thongbao->file = '';
				} 
			    $thongbao->noidung = $rq->idnoidung;
			    $thongbao->update();    
			// }
		}
		$success = 1;
		return json_encode($success);
	}

	//xoá thông báo 
	public function delthongbao(Request $rq)
	{	

		thongbao::destroy($rq->idthongbao);
		$success = 1;
		return json_encode($success);
	}

	//gửi thông báo 
	public function sendthongbao(Request $rq)
	{	
		$ngayhientai = date("Y-m-d");
		$thongbao = thongbao::find($rq->idthongbao);
		$thongbao->gui = 1;
		$thongbao->ngaygui = $ngayhientai;
		$thongbao->update();  
		$success = 1;
		return json_encode($success);
	}

}
