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
use App\thoikhoabieu;
use App\danhgiagv;
use App\tochuyenmon;
use App\giaovien_chuyenmon;
use Auth;
use DB;
use stdClass;
use Carbon;
use App\baocao;
use Session; 

class tonghopController extends Controller
{
	    public function uploadFileKyso(Request $request)
    {
        if ($request->file != "null") {
            if (!\is_dir(\public_path('upload'))) {
                \mkdir(\public_path('upload'));
            }
            $request->file->move(public_path('upload'), $request->file->getClientOriginalName());
            $file = public_path('upload/' . $request->file->getClientOriginalName());
            return $request->file->getClientOriginalName();
        }
    }
	
	
	//xem thời khoá biểu
	public function xemthoikhoabieu()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		
		$matruong = Session::get('matruong');
		$baocao = baocao::where('truong_id',$matruong)->get();
		$baocaocount = baocao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tonghop.xemthoikhoabieu',compact('baocao', 'baocaocount'));
	}

	//thống kê
	public function thongke()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
				$matruong = Session::get('matruong');
		$baocao = baocao::where('truong_id',$matruong)->get();
		$baocaocount = baocao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tonghop.thongke',compact('baocao', 'baocaocount'));
	}

	//theo dõi biến động thời khoá biểu
	public function theodoibiendongtkb()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable','js-datepicker','js-moment'])->addStyles(['style-macdinh','style-dev','style-datatable','style-datepicker']);
				$matruong = Session::get('matruong');
		$baocao = baocao::where('truong_id',$matruong)->get();
		$baocaocount = baocao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tonghop.theodoibiendongtkb',compact('baocao', 'baocaocount'));
	}

	//theo dõi báo cáo đơn vị
	public function theodoibaocaodonvi()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
				$matruong = Session::get('matruong');
		$baocao = baocao::where('truong_id',$matruong)->get();
		$baocaocount = baocao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tonghop.theodoibaocaodonvi',compact('baocao', 'baocaocount'));
	}

	//theo dõi đánh giá giáo viên
	public function theodoidanhgiagiaovien()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
				$matruong = Session::get('matruong');
		$baocao = baocao::where('truong_id',$matruong)->get();
		$baocaocount = baocao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tonghop.theodoidanhgiagiaovien',compact('baocao', 'baocaocount'));
	}

	//thông báo
	public function thongbao()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable','js-datepicker','js-moment'])->addStyles(['style-macdinh','style-dev','style-datatable','style-datepicker']);
				$matruong = Session::get('matruong');
		$baocao = baocao::where('truong_id',$matruong)->get();
		$baocaocount = baocao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tonghop.thongbao',compact('baocao', 'baocaocount'));
	}


	//lấy danh sách trường
	public function getdstruong(){
		$mahuyen = Session::get('mahuyen');
		$data = [];
		$truong = truong::where('mahuyen',$mahuyen)->get();
		foreach ($truong as $t) {
            $dstruong = new stdClass();
            $dstruong->matruong = $t->matruong;
            $dstruong->tentruong = $t->tentruong;
            $dstruong->mahuyen = $t->mahuyen;
            $dstruong->caphoc = $t->caphoc;
            $dstruong->loaitruong = $t->loaitruong;
            $lop = danhsachlophoc::where('matruong', '=',  $t->matruong)->select('id','tenlop','khoi')->orderBy('tenlop', 'ASC')->get();
            $gv = danhsachgv::where('matruong','=', $t->matruong)->select('id','hovaten','bidanh','dienthoai','email')->get();
            $khoi = khoihoc::where('matruong','=', $t->matruong)->select('id','tenkhoi')->orderBy('tenkhoi', 'ASC')->get();
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
		$mahuyen = Session::get('mahuyen');
		$data = [];
		$truong = truong::where('mahuyen',$mahuyen)->get();
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
		$mahuyen = Session::get('mahuyen');
		$thongbao = DB::table('thongbao')
		->join('tbl_admin','tbl_admin.id','=','thongbao.tbl_admin_id')
		->where('mahuyen',$mahuyen)
		->select('thongbao.id','thongbao.truong_id','thongbao.tbl_admin_id','thongbao.sohieu','thongbao.tieude','thongbao.loai','thongbao.ngaytao','thongbao.ngaygui','thongbao.file','thongbao.noidung','thongbao.gui','thongbao.trangthai','tbl_admin.tentaikhoan','tbl_admin.mahuyen')
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
			if($tenfile != null){
				$thongbao->file = $tenfile[0];
			}else{
				$thongbao->file = '';
			} 
		    $thongbao->noidung = $rq->idnoidung;
		    $thongbao->gui = 0;
		    $thongbao->trangthai = 0;
		    $thongbao->save();    
			// }
		}else{
			$thongbao = new thongbao();
			$thongbao->truong_id = json_encode($rq->idcaphocall);
			$thongbao->tbl_admin_id = Auth::user()->id;
			$thongbao->sohieu = $rq->idsohieu;
			$thongbao->tieude = $rq->idtieude;
			$thongbao->loai = $rq->idloai;
			$thongbao->ngaytao = $ngaytaoformat;
			$thongbao->ngaygui = null;
			if($tenfile != null){
				$thongbao->file = $tenfile[0];
			}else{
				$thongbao->file = '';
			} 
		    $thongbao->noidung = $rq->idnoidung;
		    $thongbao->gui = 0;
		    $thongbao->trangthai = 0;
		    $thongbao->save(); 
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
			if($tenfile != null){
				$thongbao->file = $tenfile[0];
			} 
		    $thongbao->noidung = $rq->idnoidung;
		    $thongbao->update();    
			// }
		}else{
			$thongbao = thongbao::find($rq->idthongbao);
			$thongbao->truong_id = json_encode($rq->idcaphocall);
			$thongbao->tbl_admin_id = Auth::user()->id;
			$thongbao->sohieu = $rq->idsohieu;
			$thongbao->tieude = $rq->idtieude;
			$thongbao->loai = $rq->idloai;
			$thongbao->ngaytao = $ngaytaoformat;
			$thongbao->ngaygui = null;
			if($tenfile != null){
				$thongbao->file = $tenfile[0];
			}
		    $thongbao->noidung = $rq->idnoidung;
		    $thongbao->update(); 
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

	//thu hồi thông báo 
	public function thuhoithongbao(Request $rq)
	{	
		$thongbao = thongbao::find($rq->idthongbao);
		$thongbao->gui = 0;
		$thongbao->ngaygui = null;
		$thongbao->update();  
		$success = 1;
		return json_encode($success);
	}

	//get thời khoá biểu trường
	public function getthoikhoabieutruong(){
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong')
	 	->get();

	 	$buoithu = array(
	 		array(
	 			'idbuoi'=>0,
	 			'idthu'=>2,
	 			"tenbuoithu"=>"Sáng thứ 2"
	 		),
	 		array(
	 			'idbuoi'=>0,
	 			'idthu'=>3,
	 			"tenbuoithu"=>"Sáng thứ 3"
	 		),
	 		array(
	 			'idbuoi'=>0,
	 			'idthu'=>4,
	 			"tenbuoithu"=>"Sáng thứ 4"
	 		),
	 		array(
	 			'idbuoi'=>0,
	 			'idthu'=>5,
	 			"tenbuoithu"=>"Sáng thứ 5"
	 		),
	 		array(
	 			'idbuoi'=>0,
	 			'idthu'=>6,
	 			"tenbuoithu"=>"Sáng thứ 6"
	 		),
	 		array(
	 			'idbuoi'=>0,
	 			'idthu'=>7,
	 			"tenbuoithu"=>"Sáng thứ 7"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			'idthu'=>2,
	 			"tenbuoithu"=>"Chiều thứ 2"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			'idthu'=>3,
	 			"tenbuoithu"=>"Chiều thứ 3"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			'idthu'=>4,
	 			"tenbuoithu"=>"Chiều thứ 4"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			'idthu'=>5,
	 			"tenbuoithu"=>"Chiều thứ 5"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			'idthu'=>6,
	 			"tenbuoithu"=>"Chiều thứ 6"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			'idthu'=>7,
	 			"tenbuoithu"=>"Chiều thứ 7"
	 		)
	 	);

	 	$databt= array();
		foreach($thoikhoabieu as $t){
			foreach($buoithu as $b){
				if($t->buoi == $b['idbuoi'] && $t->thu == $b['idthu']){
					$bt = $b['idbuoi'].','.$b['idthu'];
					$mabuoi = $b['idbuoi'];
					array_push($databt,array('matruong'=>$t->matruong,'magiaovien'=>$t->magiaovien,'malop'=>$t->malop,'mamonhoc'=>$t->mamonhoc,'maphong'=>$t->maphong,'mabuoithu'=>$bt,'mabuoi'=>$mabuoi,'bidanh'=>$t->bidanh,'tenlop'=>$t->tenlop,'tenmonhoc'=>$t->tenmonhoc,'tiet'=>$t->tiet,'tenbuoithu'=>$b['tenbuoithu']));
				}
			}
		}

		foreach($databt as $d){
			$matruong = $d['matruong'];
			$mabuoithu = $d['mabuoithu'];
			$tiet = $d['tiet'];
			$malop = $d['malop'];
			$mamonhoc = $d['mamonhoc'];
			$magiaovien = $d['magiaovien'];
			$grouped[$matruong][$mabuoithu][$tiet][$malop][$mamonhoc][$magiaovien][] = $d;
		}

		// dd($grouped);
		foreach($grouped as $k => $v) {
			$databuoithu = [];		
			foreach($v as $k1=>$v1){
				$datatiet = [];
				$mabuoi;
				$tenbuoithu;
				foreach($v1 as $k2=>$v2){
					$datalop = [];
					foreach($v2 as $k3=>$v3){
						$datamh = [];
						$tenlop;
						foreach($v3 as $k4=>$v4){
							$datagv = [];
							$tenmonhoc;
							foreach($v4 as $k5=>$v5){
								$tenbuoithu = $v5[0]['tenbuoithu'];
								$mabuoi= $v5[0]['mabuoi'];
								$tenlop= $v5[0]['tenlop'];
								$bidanh= $v5[0]['bidanh'];
								$tenmonhoc= $v5[0]['tenmonhoc'];
								array_push($datagv,array('magiaovien' => $k5,'bidanh' => $bidanh));
							}
							array_push($datamh,array('mamonhoc' => $k4, 'tenmonhoc' => $tenmonhoc ,'dsgiaovien'=>$datagv));
						}
						array_push($datalop,array('malop' => $k3, 'tenlop' => $tenlop ,'dsmonhoc'=>$datamh));
					}
					array_push($datatiet,array('tiet' => $k2, 'dslop'=>$datalop));
				}
				array_push($databuoithu,array('mabuoithu' => $k1,'mabuoi' => $mabuoi,'tenbuoithu' => $tenbuoithu ,'dstiet'=>$datatiet));			
			}
			$new_data_tkb[] = array('matruong' => $k, 'dsbuoithu'=> $databuoithu);
		}

		return json_encode($new_data_tkb, JSON_UNESCAPED_UNICODE);
	}

	//get danh sách lớp tkb trường
	public function getdsloptruong(){
		$danhsachlophoc = danhsachlophoc::orderBy('tenlop', 'ASC')->get();
		$datadslop = [];
		foreach($danhsachlophoc as $d){
			array_push($datadslop,array('matruong'=>$d->matruong,'malop'=>$d->id,'tenlop'=>$d->tenlop));
		}
		foreach($datadslop as $d){
			$matruong = $d['matruong'];
			$groupedmatruong[$matruong][] = $d;
		}

	 	foreach($groupedmatruong as $k =>$g){
	 		$datamatenlop = [];
	 		foreach($g as $gv){
	 			array_push($datamatenlop,array('malop'=>$gv['malop'],'tenlop'=>$gv['tenlop']));
	 		}
	 		$new_datadslop[] = array('matruong'=>$k,'dslop'=>$datamatenlop);
	 	}
	 	return json_encode($new_datadslop, JSON_UNESCAPED_UNICODE);
	}

	//get thời khoá biểu giáo viên
	public function getthoikhoabieugv(){
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong')
	 	->get();

	 	$buoi = array(
	 		array(
	 			'idbuoi'=>0,
	 			"tenbuoi"=>"Sáng"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			"tenbuoi"=>"Chiều"
	 		)
	 	);

	 	$thu = array(
	 		array(
	 			'idthu'=>2,
	 			"tenthu"=>"Thứ 2"
	 		),
	 		array(
	 			'idthu'=>3,
	 			"tenthu"=>"Thứ 3"
	 		),
	 		array(
	 			'idthu'=>4,
	 			"tenthu"=>"Thứ 4"
	 		),
	 		array(
	 			'idthu'=>5,
	 			"tenthu"=>"Thứ 5"
	 		),
	 		array(
	 			'idthu'=>6,
	 			"tenthu"=>"Thứ 6"
	 		),
	 		array(
	 			'idthu'=>7,
	 			"tenthu"=>"Thứ 7"
	 		),
	 	);

	 	$databt= array();
		foreach($thoikhoabieu as $t){
			foreach($buoi as $b){
				foreach($thu as $k){
					if($t->buoi == $b['idbuoi'] && $t->thu == $k['idthu']){
						array_push($databt,array('matruong'=>$t->matruong,'magiaovien'=>$t->magiaovien,'malop'=>$t->malop,'mamonhoc'=>$t->mamonhoc,'maphong'=>$t->maphong,'mabuoi'=>$b['idbuoi'],'mathu'=>$k['idthu'],'bidanh'=>$t->bidanh,'tenlop'=>$t->tenlop,'tenmonhoc'=>$t->tenmonhoc,'tiet'=>$t->tiet,'tenbuoi'=>$b['tenbuoi'],'tenthu'=>$k['tenthu']));
					}
				}
				
			}
		}

		foreach($databt as $d){
			$matruong = $d['matruong'];
			$magiaovien = $d['magiaovien'];
			$mabuoi = $d['mabuoi'];
			$tiet = $d['tiet'];
			$mathu = $d['mathu'];
			$mamonhoc = $d['mamonhoc'];
			$malop = $d['malop'];
			$grouped[$matruong][$magiaovien][$mabuoi][$tiet][$mathu][$mamonhoc][$malop][] = $d;
		}
		
		foreach($grouped as $k=>$v){
			$datagv = [];
			foreach($v as $k1=>$v1){
				$databuoi = [];
				$bidanh;
				foreach($v1 as $k2=>$v2){
					$datatiet = [];
					$tenbuoi;
					foreach($v2 as $k3=>$v3){
						$datathu = [];
						foreach($v3 as $k4=>$v4){
							$datamh = [];
							$tenthu;
							foreach($v4 as $k5=>$v5){
								$datalop = [];
								$tenmonhoc;
								foreach($v5 as $k6=>$v6){
									$bidanh = $v6[0]['bidanh'];
									$tenbuoi= $v6[0]['tenbuoi'];
									$tenthu= $v6[0]['tenthu'];
									$tenmonhoc= $v6[0]['tenmonhoc'];
									$tenlop= $v6[0]['tenlop'];
									array_push($datalop,array('malop' => $k6,'tenlop' => $tenlop));
								}
								array_push($datamh,array('mamonhoc' => $k5,'tenmonhoc'=>$tenmonhoc,'dslop'=>$datalop));
							}
							array_push($datathu,array('mathu' => $k4,'tenthu'=>$tenthu,'dsmonhoc'=>$datamh));
						}
						array_push($datatiet,array('tiet' => $k3,'dsthu'=>$datathu));
					}
					array_push($databuoi,array('mabuoi' => $k2,'tenbuoi' => $tenbuoi ,'dstiet'=>$datatiet));
				}
				array_push($datagv,array('magiaovien' => $k1,'bidanh' => $bidanh ,'dsbuoi'=>$databuoi));
			}
			$new_data_tkb_gv[] = array('matruong' => $k, 'dsgiaovien'=> $datagv);

		}

		return json_encode($new_data_tkb_gv, JSON_UNESCAPED_UNICODE);
	}

	//get thời khoá biểu lớp
	public function getthoikhoabieulop(){
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong')
	 	->get();

	 	$buoi = array(
	 		array(
	 			'idbuoi'=>0,
	 			"tenbuoi"=>"Sáng"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			"tenbuoi"=>"Chiều"
	 		)
	 	);

	 	$thu = array(
	 		array(
	 			'idthu'=>2,
	 			"tenthu"=>"Thứ 2"
	 		),
	 		array(
	 			'idthu'=>3,
	 			"tenthu"=>"Thứ 3"
	 		),
	 		array(
	 			'idthu'=>4,
	 			"tenthu"=>"Thứ 4"
	 		),
	 		array(
	 			'idthu'=>5,
	 			"tenthu"=>"Thứ 5"
	 		),
	 		array(
	 			'idthu'=>6,
	 			"tenthu"=>"Thứ 6"
	 		),
	 		array(
	 			'idthu'=>7,
	 			"tenthu"=>"Thứ 7"
	 		),
	 	);

	 	$databt= array();
		foreach($thoikhoabieu as $t){
			foreach($buoi as $b){
				foreach($thu as $k){
					if($t->buoi == $b['idbuoi'] && $t->thu == $k['idthu']){
						array_push($databt,array('matruong'=>$t->matruong,'magiaovien'=>$t->magiaovien,'malop'=>$t->malop,'mamonhoc'=>$t->mamonhoc,'maphong'=>$t->maphong,'mabuoi'=>$b['idbuoi'],'mathu'=>$k['idthu'],'bidanh'=>$t->bidanh,'tenlop'=>$t->tenlop,'tenmonhoc'=>$t->tenmonhoc,'tiet'=>$t->tiet,'tenbuoi'=>$b['tenbuoi'],'tenthu'=>$k['tenthu']));
					}
				}
				
			}
		}

		foreach($databt as $d){
			$matruong = $d['matruong'];
			$malop = $d['malop'];
			$mabuoi = $d['mabuoi'];
			$tiet = $d['tiet'];
			$mathu = $d['mathu'];
			$mamonhoc = $d['mamonhoc'];
			$magiaovien = $d['magiaovien'];
			$grouped[$matruong][$malop][$mabuoi][$tiet][$mathu][$mamonhoc][$magiaovien][] = $d;
		}

		foreach($grouped as $k=>$v){
			$datalop = [];
			foreach($v as $k1=>$v1){
				$databuoi = [];
				$tenlop;
				foreach($v1 as $k2=>$v2){
					$datatiet = [];
					$tenbuoi;
					foreach($v2 as $k3=>$v3){
						$datathu = [];
						foreach($v3 as $k4=>$v4){
							$datamh = [];
							$tenthu;
							foreach($v4 as $k5=>$v5){
								$datagv = [];
								$tenmonhoc;
								foreach($v5 as $k6=>$v6){
									$bidanh = $v6[0]['bidanh'];
									$tenbuoi= $v6[0]['tenbuoi'];
									$tenthu= $v6[0]['tenthu'];
									$tenmonhoc= $v6[0]['tenmonhoc'];
									$tenlop= $v6[0]['tenlop'];
									array_push($datagv,array('magiaovien' => $k6,'bidanh' => $bidanh));
								}
								array_push($datamh,array('mamonhoc' => $k5,'tenmonhoc'=>$tenmonhoc,'dsgiaovien'=>$datagv));
							}
							array_push($datathu,array('mathu' => $k4,'tenthu'=>$tenthu,'dsmonhoc'=>$datamh));
						}
						array_push($datatiet,array('tiet' => $k3,'dsthu'=>$datathu));
					}
					array_push($databuoi,array('mabuoi' => $k2,'tenbuoi' => $tenbuoi ,'dstiet'=>$datatiet));
				}
				array_push($datalop,array('malop' => $k1,'tenlop' => $tenlop ,'dsbuoi'=>$databuoi));
			}
			$new_data_tkb_lop[] = array('matruong' => $k, 'dslop'=> $datalop);

		}

		return json_encode($new_data_tkb_lop, JSON_UNESCAPED_UNICODE);
	}

	//lấy danh sách đánh giá giáo viên
	public function getdanhgiagv(){
		$data =  tochuyenmon::get();
		$tengv = danhsachgv::get();
		$danhgiagv = danhgiagv::get();
		$giaovien_chuyenmon = giaovien_chuyenmon::join('danhgiagv','danhgiagv.magiaovien','giaovien_chuyenmon.magiaovien')->get();
		return json_encode([$data,$tengv,$giaovien_chuyenmon,$danhgiagv], JSON_UNESCAPED_UNICODE);
	}

	//lấy thời khoá biểu giáo viên theo thời gian
	public function getthoikhoabieugvtime(){
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong','thoikhoabieu.created_at')
	 	->get();

	 	$buoi = array(
	 		array(
	 			'idbuoi'=>0,
	 			"tenbuoi"=>"Sáng"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			"tenbuoi"=>"Chiều"
	 		)
	 	);

	 	$thu = array(
	 		array(
	 			'idthu'=>2,
	 			"tenthu"=>"Thứ 2"
	 		),
	 		array(
	 			'idthu'=>3,
	 			"tenthu"=>"Thứ 3"
	 		),
	 		array(
	 			'idthu'=>4,
	 			"tenthu"=>"Thứ 4"
	 		),
	 		array(
	 			'idthu'=>5,
	 			"tenthu"=>"Thứ 5"
	 		),
	 		array(
	 			'idthu'=>6,
	 			"tenthu"=>"Thứ 6"
	 		),
	 		array(
	 			'idthu'=>7,
	 			"tenthu"=>"Thứ 7"
	 		),
	 	);

	 	$databt= array();
		foreach($thoikhoabieu as $t){
			foreach($buoi as $b){
				foreach($thu as $k){
					if($t->buoi == $b['idbuoi'] && $t->thu == $k['idthu']){
						$ngay = date('Y-m-d', strtotime($t->created_at));
						array_push($databt,array('matruong'=>$t->matruong,'magiaovien'=>$t->magiaovien,'malop'=>$t->malop,'mamonhoc'=>$t->mamonhoc,'maphong'=>$t->maphong,'mabuoi'=>$b['idbuoi'],'mathu'=>$k['idthu'],'bidanh'=>$t->bidanh,'tenlop'=>$t->tenlop,'tenmonhoc'=>$t->tenmonhoc,'tiet'=>$t->tiet,'tenbuoi'=>$b['tenbuoi'],'tenthu'=>$k['tenthu'],'ngay'=>$ngay));
					}
				}
				
			}
		}

		foreach($databt as $d){
			$matruong = $d['matruong'];
			$magiaovien = $d['magiaovien'];
			$mabuoi = $d['mabuoi'];
			$tiet = $d['tiet'];
			$mathu = $d['mathu'];
			$mamonhoc = $d['mamonhoc'];
			$malop = $d['malop'];
			$ngay = $d['ngay'];
			$grouped[$matruong][$magiaovien][$ngay][$mabuoi][$tiet][$mathu][$mamonhoc][$malop][] = $d;
		}

		foreach($grouped as $k=>$v){
			$datagv = [];
			foreach($v as $k1=>$v1){
				$bidanh;
				$datathoigian = [];
				foreach($v1 as $k2=>$v2){
					$ngay;
					$thang;
					$nam;
					$databuoi = [];
					foreach($v2 as $k3=>$v3){
						$tenbuoi;
						$datatiet = [];
						foreach($v3 as $k4=>$v4){
							$datathu = [];
							foreach($v4 as $k5=>$v5){
								$tenthu;
								$datamh = [];
								foreach($v5 as $k6=>$v6){
									$tenmonhoc;
									$datalop = [];
									foreach($v6 as $k7=>$v7){
										$bidanh = $v7[0]['bidanh'];
										$layngaythangnam = date_parse_from_format("Y-m-d", $v7[0]['ngay']);
										$ngay = $layngaythangnam['day']; 
										$thang = $layngaythangnam['month'];
										$nam = $layngaythangnam['year'];
										$tenbuoi = $v7[0]['tenbuoi'];
										$tenthu = $v7[0]['tenthu'];
										$tenmonhoc = $v7[0]['tenmonhoc'];
										$tenlop = $v7[0]['tenlop'];
										array_push($datalop,array('malop'=>$k7,'tenlop'=>$tenlop));
									}
									array_push($datamh,array('mamonhoc'=>$k6,'tenmonhoc'=>$tenmonhoc,'dslop'=>$datalop));
								}
								array_push($datathu,array('mathu'=>$k5,'tenthu'=>$tenthu,'dsmonhoc'=>$datamh));
							}
							array_push($datatiet,array('tiet'=>$k4,'dsthu'=>$datathu));
						}
						array_push($databuoi,array('mabuoi'=>$k3,'tenbuoi'=>$tenbuoi,'dstiet'=>$datatiet));
					}
					array_push($datathoigian,array('datangay' =>$k2,'ngay'=>$ngay,'thang' => $thang, 'nam'=>$nam, 'dsbuoi'=>$databuoi));
				}
				array_push($datagv,array('magiaovien' => $k1,'bidanh' => $bidanh ,'dsthoigian'=>$datathoigian));
			}
			$new_data_tkb_gv_thoigian[] = array('matruong' => $k, 'dsgiaovien'=> $datagv);

		}
		// dd($new_data_tkb_gv_thoigian);
		return json_encode($new_data_tkb_gv_thoigian, JSON_UNESCAPED_UNICODE);
	}

	//lấy thời khoá biểu lớp theo thời gian
	public function getthoikhoabieuloptime(){
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong','thoikhoabieu.created_at')
	 	->get();

	 	$buoi = array(
	 		array(
	 			'idbuoi'=>0,
	 			"tenbuoi"=>"Sáng"
	 		),
	 		array(
	 			'idbuoi'=>1,
	 			"tenbuoi"=>"Chiều"
	 		)
	 	);

	 	$thu = array(
	 		array(
	 			'idthu'=>2,
	 			"tenthu"=>"Thứ 2"
	 		),
	 		array(
	 			'idthu'=>3,
	 			"tenthu"=>"Thứ 3"
	 		),
	 		array(
	 			'idthu'=>4,
	 			"tenthu"=>"Thứ 4"
	 		),
	 		array(
	 			'idthu'=>5,
	 			"tenthu"=>"Thứ 5"
	 		),
	 		array(
	 			'idthu'=>6,
	 			"tenthu"=>"Thứ 6"
	 		),
	 		array(
	 			'idthu'=>7,
	 			"tenthu"=>"Thứ 7"
	 		),
	 	);

	 	$databt= array();
		foreach($thoikhoabieu as $t){
			foreach($buoi as $b){
				foreach($thu as $k){
					if($t->buoi == $b['idbuoi'] && $t->thu == $k['idthu']){
						$ngay = date('Y-m-d', strtotime($t->created_at));
						array_push($databt,array('matruong'=>$t->matruong,'magiaovien'=>$t->magiaovien,'malop'=>$t->malop,'mamonhoc'=>$t->mamonhoc,'maphong'=>$t->maphong,'mabuoi'=>$b['idbuoi'],'mathu'=>$k['idthu'],'bidanh'=>$t->bidanh,'tenlop'=>$t->tenlop,'tenmonhoc'=>$t->tenmonhoc,'tiet'=>$t->tiet,'tenbuoi'=>$b['tenbuoi'],'tenthu'=>$k['tenthu'],'ngay'=>$ngay));
					}
				}
				
			}
		}

		foreach($databt as $d){
			$matruong = $d['matruong'];
			$malop = $d['malop'];
			$mabuoi = $d['mabuoi'];
			$tiet = $d['tiet'];
			$mathu = $d['mathu'];
			$mamonhoc = $d['mamonhoc'];
			$magiaovien = $d['magiaovien'];
			$ngay = $d['ngay'];
			$grouped[$matruong][$malop][$ngay][$mabuoi][$tiet][$mathu][$mamonhoc][$magiaovien][] = $d;
		}

		foreach($grouped as $k=>$v){
			$datalop = [];
			foreach($v as $k1=>$v1){
				$tenlop;
				$datathoigian = [];
				foreach($v1 as $k2=>$v2){
					$thang;
					$nam;
					$databuoi = [];
					foreach($v2 as $k3=>$v3){
						$tenbuoi;
						$datatiet = [];
						foreach($v3 as $k4=>$v4){
							$datathu = [];
							foreach($v4 as $k5=>$v5){
								$tenthu;
								$datamh = [];
								foreach($v5 as $k6=>$v6){
									$tenmonhoc;
									$datagv = [];
									foreach($v6 as $k7=>$v7){
										$bidanh = $v7[0]['bidanh'];
										$layngaythangnam = date_parse_from_format("Y-m-d", $v7[0]['ngay']);
										$ngay = $layngaythangnam['day']; 
										$thang = $layngaythangnam['month'];
										$nam = $layngaythangnam['year'];
										$tenbuoi = $v7[0]['tenbuoi'];
										$tenthu = $v7[0]['tenthu'];
										$tenmonhoc = $v7[0]['tenmonhoc'];
										$tenlop = $v7[0]['tenlop'];
										array_push($datagv,array('magiaovien'=>$k7,'bidanh'=>$bidanh));
									}
									array_push($datamh,array('mamonhoc'=>$k6,'tenmonhoc'=>$tenmonhoc,'dsgiaovien'=>$datagv));
								}
								array_push($datathu,array('mathu'=>$k5,'tenthu'=>$tenthu,'dsmonhoc'=>$datamh));
							}
							array_push($datatiet,array('tiet'=>$k4,'dsthu'=>$datathu));
						}
						array_push($databuoi,array('mabuoi'=>$k3,'tenbuoi'=>$tenbuoi,'dstiet'=>$datatiet));
					}
					array_push($datathoigian,array('datangay' =>$k2,'thang' => $thang, 'nam'=>$nam, 'dsbuoi'=>$databuoi));
				}
				array_push($datalop,array('malop' => $k1,'tenlop' => $tenlop ,'dsthoigian'=>$datathoigian));
			}
			$new_data_tkb_lop_thoigian[] = array('matruong' => $k, 'dslop'=> $datalop);

		}

		return json_encode($new_data_tkb_lop_thoigian, JSON_UNESCAPED_UNICODE);
	}

	//lấy danh sách báo cáo đơn vị
	public function getdsbaocaodonvi(){
		$truong = truong::all();	
		$data = [];
		foreach($truong as $t){
			$dstruong = new stdClass();
			$dstruong->matruong = $t->matruong;
			$dstruong->tentruong = $t->tentruong;
			$baocao = DB::table('baocao')
			->join('tbl_admin','tbl_admin.id','=','baocao.tbl_admin_id')
			->select('baocao.id','baocao.truong_id','baocao.tbl_admin_id','baocao.sohieu','baocao.tieude','baocao.loai','baocao.ngaytao','baocao.ngaygui','baocao.file','baocao.noidung','baocao.gui','baocao.trangthai','tbl_admin.tentaikhoan')
			->where('baocao.gui',1)
			->where('baocao.truong_id',$t->matruong)
			->get();
			$dstruong->danhsachbaocao = $baocao;
			array_push($data,$dstruong);
		}
		
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//cập nhật trạng thái xem báo cáo đơn vị
	public function updatetrangthaixembaocaodonvi(Request $rq){
		$baocao = baocao::find($rq->idbaocao);
		$baocao->trangthai = 1;
		$baocao->update();
		$success = 1;
		return json_encode($success);
	}

}
