<?php

namespace App\Http\Controllers\exportkb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session; 
use App\thoikhoabieuexcel;
use App\danhsachgv;
use App\monhoc;
use App\danhsachlophoc;
use App\baocao;
use App\User;
use Auth;
use DB;
use stdClass;
use App\thongbao;

class exportkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		
				$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('exportkb.index',compact('thongbao', 'thongbaocount'));
	}


	public function importexceltkb(Request $rq){
		$matruong = Session::get('matruong');       
		$request = $rq->request;
		$datadel = thoikhoabieuexcel::query()->delete();
		foreach ($request as $data) {
			$datas = (object)$data;
			$mon = $datas->monhoc;
			$tengvs = $datas->tengv;
			$tiet = $datas->tiet;
			$buoi = $datas->buoi;
			$thu = $datas->thu;
			$lop = $datas->lop;
			$matruongs = $matruong;

			$giaovien = danhsachgv::where(function($query)use($tengvs,$matruong) {
				$query->where('hovaten', '=', $tengvs);
				$query->where('matruong',$matruong);
			})->first();

			if ($giaovien === null) {
				$giaovien = new danhsachgv();
				$giaovien->hovaten = $tengvs;
				
				$name1 = explode(" ",$tengvs);
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
				}
				$giaovien->trangthai = 1;
				$giaovien->matruong = $matruong;
				$success = $giaovien->save();
			}




			$tengv = danhsachgv::where(function($query)use($tengvs,$matruong) {
				$query->where('hovaten', '=', $tengvs);
				$query->where('matruong',$matruong);
			})->select('id')->first();

			$dslop = danhsachlophoc::where(function($query)use($lop,$matruong) {
				$query->where('tenlop', '=', $lop);
				$query->where('matruong',$matruong);
			})->select('id')->first();

			$dsmon = monhoc::where(function($query)use($mon,$matruong) {
				$query->where('tenmonhoc', '=', $mon);
				$query->where('matruong',$matruong);
			})->select('id')->first();

			
			$data = new thoikhoabieuexcel();
			$data->magiaovien = $tengv->id;
			$data->malop = $dslop->id;
			$data->matruong = $matruongs;
			$data->mamonhoc = $dsmon->id;
			$data->thu = $thu;
			$data->buoi = $buoi;
			$data->tiet = $tiet;
			$success = $data->save();   
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	//lấy danh sách báo cáo
	public function getdsbaocao(){
		$matruong = Session::get('matruong');  
		$baocao = DB::table('baocao')
		->join('tbl_admin','tbl_admin.id','=','baocao.tbl_admin_id')
		->select('baocao.id','baocao.truong_id','baocao.tbl_admin_id','baocao.sohieu','baocao.tieude','baocao.loai','baocao.ngaytao','baocao.ngaygui','baocao.file','baocao.noidung','baocao.gui','baocao.trangthai','tbl_admin.tentaikhoan')
		->where('baocao.truong_id',$matruong)
		->get();
		
		return json_encode($baocao, JSON_UNESCAPED_UNICODE);
	}

	//thêm mới báo cáo
	public function addbaocao(Request $rq){
		// $Str = addslashes($iddonvi);
		// $iddonvijson = json_encode($iddonvi);
		$matruong = Session::get('matruong');
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
                move_uploaded_file($tmp_name_array, public_path('uploads/baocao/').$file_name);
	        }         
	    }    
		// if($rq->iddonvi !=''){
			// for($i=0;$i<count($iddonvi);$i++){
				$baocao = new baocao();
				$baocao->truong_id = $matruong;
				$baocao->tbl_admin_id = Auth::user()->id;
				$baocao->sohieu = $rq->idsohieu;
				$baocao->tieude = $rq->idtieude;
				$baocao->loai = $rq->idloai;
				$baocao->ngaytao = $ngaytaoformat;
				$baocao->ngaygui = null;
				if($tenfile != null){
					$baocao->file = $tenfile[0];
				}else{
					$baocao->file = '';
				} 
			    $baocao->noidung = $rq->idnoidung;
			    $baocao->gui = 0;
			    $baocao->trangthai = 0;
			    $baocao->save();    
			// }
		// }
		$success = 1;
		return json_encode($success);
	}

	//sửa báo cáo
	public function updatebaocao(Request $rq){
		$matruong = Session::get('matruong');  
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
                move_uploaded_file($tmp_name_array, public_path('uploads/baocao/').$file_name);
	        }         
	    }    
		// if($rq->iddonvi !=''){
			// for($i=0;$i<count($iddonvi);$i++){
				$baocao = baocao::find($rq->idbaocao);	
				$baocao->truong_id = $matruong;
				$baocao->tbl_admin_id = Auth::user()->id;
				$baocao->sohieu = $rq->idsohieu;
				$baocao->tieude = $rq->idtieude;
				$baocao->loai = $rq->idloai;
				$baocao->ngaytao = $ngaytaoformat;
				if($tenfile != null){
					$baocao->file = $tenfile[0];
				}else{
					$baocao->file = '';
				} 
			    $baocao->noidung = $rq->idnoidung;
			    $baocao->update();    
			// }
		// }
		$success = 1;
		return json_encode($success);
	}

	//xoá báo cáo 
	public function delbaocao(Request $rq)
	{	

		baocao::destroy($rq->idbaocao);
		$success = 1;
		return json_encode($success);
	}

	//gửi báo cáo
	public function sendbaocao(Request $rq)
	{	
		$ngayhientai = date("Y-m-d");
		$baocao = baocao::find($rq->idbaocao);
		$baocao->gui = 1;
		$baocao->ngaygui = $ngayhientai;
		$baocao->update();  
		$success = 1;
		return json_encode($success);
	}

	//thu hồi báo cáo 
	public function thuhoibaocao(Request $rq)
	{	
		$baocao = baocao::find($rq->idbaocao);
		$baocao->gui = 0;
		$baocao->ngaygui = null;
		$baocao->update();  
		$success = 1;
		return json_encode($success);
	}



}
