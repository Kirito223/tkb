<?php

namespace App\Http\Controllers\rangbuoc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\mucrangbuoc;
use App\danhsachrangbuoc;
use App\danhsachgv;
use App\khoihoc;
use App\monhoc;
use App\danhsachlophoc;
use App\tiethoc;
use App\tiethopcuato;
use App\tochuyenmon;
use App\rangbuoctiettranh;
use App\rangbuoctietcodinh;
use App\rangbuoctranh2moncungbuoi;
use App\rangbuoccaptietxepliennhau;
use App\sotietbuoi;
use App\sotietngay;
use DB;
use Session; 
use stdClass;

class rangbuocController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('rangbuoc.index');
	}
	public function getlistrangbuoc(){
		$data =  mucrangbuoc::all();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function getlistdanhsachrangbuoc(){
		$data =  danhsachrangbuoc::all();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

		//get khối học
	public function getkhoihoc(){
		$matruong = Session::get('matruong');
		// $data = khoihoc::all();
		$data = khoihoc::where('matruong',$matruong)->with(['danhsachlophoc'=>function($author){
			$author->select('danhsachlophoc.id','danhsachlophoc.tenlop','danhsachlophoc.khoi');
		}])
		->select('id','tenkhoi')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//get ràng buộc tiết cố định
	public function getrangbuoctietcodinh(){
		$matruong = Session::get('matruong');
		$data =  monhoc::where('matruong',$matruong)->with(['danhsachlophocrb'=>function($author){
			$author->select('danhsachlophoc.id','danhsachlophoc.tenlop','danhsachlophoc.khoi','rangbuoctietcodinh.id as idrbtcd','rangbuoctietcodinh.mamonhoc','rangbuoctietcodinh.mamucrangbuoc','rangbuoctietcodinh.buoi','rangbuoctietcodinh.thu','rangbuoctietcodinh.tiet');
			$author->with(['mucrangbuoc'=>function($to){
				$to->select('mucrangbuoc.id','mucrangbuoc.mucrangbuoc');
			}]);
		}])
		->select('id','tenmonhoc')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);


	}

	//add ràng buộc tiết cố định tiết học
	public function addrangbuoctietcodinhtiethoc(Request $rq){
		$matruong = Session::get('matruong');
		$datalh = danhsachlophoc::where('matruong',$matruong)->get();
		$dataidklad= json_decode($rq->idkhoilopapdung);
		$dataidadtt= json_decode($rq->idapdungtoantruong);
		if($dataidklad !=''){
			foreach($dataidklad as $d){
				$tietcodinhtiethoc = new rangbuoctietcodinh();
				$tietcodinhtiethoc->malop = $d->id;
				$tietcodinhtiethoc->mamonhoc = $rq->idmon;
				$tietcodinhtiethoc->mamucrangbuoc = $rq->idmucrangbuoc;
				$tietcodinhtiethoc->buoi = $rq->idbuoi;
				$tietcodinhtiethoc->thu = $rq->idthu;
				$tietcodinhtiethoc->tiet = $rq->idtietthu;
				$tietcodinhtiethoc->matruong = $matruong;
				$tietcodinhtiethoc->save();
			}
		}
		if($dataidadtt !=''){
			foreach($dataidadtt as $d){
				foreach($datalh as $d1){
					if($d->id == $d1->khoi){
						$tietcodinhtiethoc = new rangbuoctietcodinh();
						$tietcodinhtiethoc->malop = $d1->id;
						$tietcodinhtiethoc->mamonhoc = $rq->idmon;
						$tietcodinhtiethoc->mamucrangbuoc = $rq->idmucrangbuoc;
						$tietcodinhtiethoc->buoi = $rq->idbuoi;
						$tietcodinhtiethoc->thu = $rq->idthu;
						$tietcodinhtiethoc->tiet = $rq->idtietthu;
						$tietcodinhtiethoc->matruong = $matruong;
						$tietcodinhtiethoc->save();
					}
				}
			}
		}
		$success = 1;
		return json_encode($success);
	}

	//update ràng buộc tiết cố định tiết học
	public function updaterangbuoctietcodinhtiethoc(Request $rq){
		$matruong = Session::get('matruong');
		$datalh = danhsachlophoc::where('matruong',$matruong)->get();
		$idrbtcds= json_decode($rq->idrbtcds);
		$dataidklad= json_decode($rq->idkhoilopapdung);
		$dataidadtt= json_decode($rq->idapdungtoantruong);

		foreach($idrbtcds as $i){
			rangbuoctietcodinh::destroy($i->idrbtcds);
		}

		if($dataidklad !=''){
			foreach($dataidklad as $d){
				$tietcodinhtiethoc = new rangbuoctietcodinh();
				$tietcodinhtiethoc->malop = $d->id;
				$tietcodinhtiethoc->mamonhoc = $rq->idmon;
				$tietcodinhtiethoc->mamucrangbuoc = $rq->idmucrangbuoc;
				$tietcodinhtiethoc->buoi = $rq->idbuoi;
				$tietcodinhtiethoc->thu = $rq->idthu;
				$tietcodinhtiethoc->tiet = $rq->idtietthu;
				$tietcodinhtiethoc->matruong = $matruong;
				$tietcodinhtiethoc->save();
			}
		}
		if($dataidadtt !=''){
			foreach($dataidadtt as $d){
				foreach($datalh as $d1){
					if($d->id == $d1->khoi){
						$tietcodinhtiethoc = new rangbuoctietcodinh();
						$tietcodinhtiethoc->malop = $d1->id;
						$tietcodinhtiethoc->mamonhoc = $rq->idmon;
						$tietcodinhtiethoc->mamucrangbuoc = $rq->idmucrangbuoc;
						$tietcodinhtiethoc->buoi = $rq->idbuoi;
						$tietcodinhtiethoc->thu = $rq->idthu;
						$tietcodinhtiethoc->tiet = $rq->idtietthu;
						$tietcodinhtiethoc->matruong = $matruong;
						$tietcodinhtiethoc->save();
					}
				}
			}
		}
		$success = 1;
		return json_encode($success);
	}

	//xoá ràng buộc tiết cố định 
	public function delrangbuoctietcodinh(Request $rq)
	{	
		$idrbtcd= json_decode($rq->idrbtcd);

		foreach($idrbtcd as $i){
			rangbuoctietcodinh::destroy($i->idrbtcd);
		}
		$success = 1;
		return json_encode($success);
	}



	//get tiết họp của tổ
	public function gettiethopcuato(){
		$matruong = Session::get('matruong');
		$data = tiethopcuato::where('matruong',$matruong)->with(['tochuyenmon'=>function($author){
			$author->select('tochuyenmon.id','tochuyenmon.tentocm');
		}])
		->select('id','matochuyenmon','buoi','thu','tiet')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	
	//add tiết họp của tổ
	public function addtiethopcuato(Request $rq){
		$matruong = Session::get('matruong');
		$tiethopcuato = new tiethopcuato();
		$tiethopcuato->matochuyenmon = $rq->idtcm;
		$tiethopcuato->buoi = $rq->buoi;
		$tiethopcuato->thu = $rq->thu;
		$tiethopcuato->tiet = $rq->tiet;
		$tiethopcuato->matruong = $matruong;
		$tiethopcuato->save();
		$success = 1;
		return json_encode($success);
	}

	//sửa tiết họp của tổ
	public function updatetiethopcuato(Request $rq){
		$tiethopcuato = tiethopcuato::find($rq->id);
		$tiethopcuato->matochuyenmon = $rq->idtcm;
		$tiethopcuato->buoi = $rq->buoi;
		$tiethopcuato->thu = $rq->thu;
		$tiethopcuato->tiet = $rq->tiet;
		$tiethopcuato->update();
		$success = 1;
		return json_encode($success);
	}

	//xoá tiết họp của tổ
	public function deltiethopcuato(Request $rq)
	{
		$tiethopcuato = tiethopcuato::destroy($rq->id);
		$success = 1;
		return json_encode($success);
	}


	//get gv buộc phải có
	public function gettietgvbuocphaico(){
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong',$matruong)->with(['monhoc'=>function($author){
			$author->select('monhoc.id','monhoc.tenmonhoc','phancongchuyenmon.malop','phancongchuyenmon.magiaovien','phancongchuyenmon.mamonhoc','phancongchuyenmon.sotiet');
			$author->with(['danhsachlophoc'=>function($to){
				// $to->join('phancongchuyenmon','phancongchuyenmon.malop','=','danhsachlophoc.id')
				$to->select('danhsachlophoc.id','danhsachlophoc.tenlop');
			}]);
		}])
		->with(['rangbuoctietgvbuocphaico'=>function($author1){
			$author1->select('rangbuoctietgvbuocphaico.id','rangbuoctietgvbuocphaico.magiaovien','rangbuoctietgvbuocphaico.mamucrangbuoc','rangbuoctietgvbuocphaico.buoi','rangbuoctietgvbuocphaico.thu','rangbuoctietgvbuocphaico.tiet');
		}])
		->select('id','hovaten','bidanh','thutuhienthi')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	//add ràng buộc tiết cố định tiết học
	public function addrangbuoctietgvbuocphaico(Request $rq){
		$matruong = Session::get('matruong');
		$iddktgvbpc= json_decode($rq->iddktgvbpc);
		// $idthu = $rq->idthu;
		$datatietnghi= json_decode($rq->datatietnghi);
		if($iddktgvbpc != ''){
			foreach($iddktgvbpc as $i){
				rangbuoctietgvbuocphaico::destroy($i->iddktgvbpc);
			}
		}
		
		if($datatietnghi != ''){
			foreach($datatietnghi as $d){
				foreach($d->idthu as $t){
					$tietgvbuocphaico = new rangbuoctietgvbuocphaico();
					$tietgvbuocphaico->magiaovien = $d->idgv;
					$tietgvbuocphaico->mamucrangbuoc = $d->idmrb;
					$tietgvbuocphaico->buoi = $d->idbuoi;
					$tietgvbuocphaico->thu = $t->id;
					$tietgvbuocphaico->tiet = $d->idtiet;
					$tietgvbuocphaico->matruong = $matruong;
					$tietgvbuocphaico->save();
				}
			}
		}
		$success = 1;
		return json_encode($success);
	}


	//get đăng ký buổi/tiết nghỉ của gv
	public function getdangkybuoitietnghicuagv(){
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong',$matruong)->with(['monhoc'=>function($author){
			$author->select('monhoc.id','monhoc.tenmonhoc','phancongchuyenmon.malop','phancongchuyenmon.magiaovien','phancongchuyenmon.mamonhoc','phancongchuyenmon.sotiet');
			$author->with(['danhsachlophoc'=>function($to){
				// $to->join('phancongchuyenmon','phancongchuyenmon.malop','=','danhsachlophoc.id')
				$to->select('danhsachlophoc.id','danhsachlophoc.tenlop');
			}]);
		}])
		->with(['rangbuocdangkybuoitietnghigv'=>function($author1){
			$author1->select('rangbuocdangkybuoitietnghigv.id','rangbuocdangkybuoitietnghigv.magiaovien','rangbuocdangkybuoitietnghigv.mamucrangbuoc','rangbuocdangkybuoitietnghigv.buoi','rangbuocdangkybuoitietnghigv.thu','rangbuocdangkybuoitietnghigv.tiet');
		}])
		->select('id','hovaten','bidanh','thutuhienthi')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);

	}
	// add ràng buộc đăng ký tiết nghỉ của gv
	public function addrangbuocdangkytietnghigv(Request $rq){
		$matruong = Session::get('matruong');
		$iddktn= json_decode($rq->iddktn);
		// $idthu = $rq->idthu;
		$datatietnghi= json_decode($rq->datatietnghi);
		if($iddktn != ''){
			foreach($iddktn as $i){
				rangbuocdangkybuoitietnghigv::destroy($i->iddktn);
			}
		}
		
		if($datatietnghi != ''){
			foreach($datatietnghi as $d){
				foreach($d->idthu as $t){
					$dangkytietnghigv = new rangbuocdangkybuoitietnghigv();
					$dangkytietnghigv->magiaovien = $d->idgv;
					$dangkytietnghigv->mamucrangbuoc = $d->idmrb;
					$dangkytietnghigv->buoi = $d->idbuoi;
					$dangkytietnghigv->thu = $t->id;
					$dangkytietnghigv->tiet = $d->idtiet;
					$dangkytietnghigv->matruong = $matruong;
					$dangkytietnghigv->save();
				}
			}
		}
		$success = 1;
		return json_encode($success);
	}


	//add ràng buộc đăng ký buổi nghỉ của gv
	public function addrangbuocdangkybuoinghigv(Request $rq){
		$matruong = Session::get('matruong');
		$data_buoi_mrb= json_decode($rq->data_buoi_mrb);
		$iddkbn= json_decode($rq->iddkbn);
		$idthu = $rq->idthu;
		$datatietnghi= $rq->datatietnghi;
		if($iddkbn != ''){
			foreach($iddkbn as $i){
				rangbuocdangkybuoitietnghigv::destroy($i->iddkbn);
			}
		}

		if($data_buoi_mrb !='' ){
			foreach($data_buoi_mrb as $d){
				$dangkybuoinghigv = new rangbuocdangkybuoitietnghigv();
				$dangkybuoinghigv->magiaovien = $rq->idgv;
				$dangkybuoinghigv->mamucrangbuoc = $d->idmrb;
				$dangkybuoinghigv->buoi = $d->idbuoi;
				$dangkybuoinghigv->thu = $d->idthu;
				$dangkytietnghigv->matruong = $matruong;
				$dangkybuoinghigv->save();
			}
		}
		$success = 1;
		return json_encode($success);
	}

		//ràng buộc số tiết 5 sáng (tiết 1 chiều)
	public function getrangbuocsotiet5sangtiet1chieu(){
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong',$matruong)->with(['rangbuocsotiet5sangtiet1chieu'=>function($author1){
			$author1->select('rangbuocsotiet5sangtiet1chieu.id','rangbuocsotiet5sangtiet1chieu.magiaovien','rangbuocsotiet5sangtiet1chieu.sotiet5buoisang','rangbuocsotiet5sangtiet1chieu.sotiet1buoichieu');
		}])
		->select('id','hovaten','bidanh','thutuhienthi')
		->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//update ràng buộc số tiết 5 sáng (tiết 1 chiều)
	public function updatesotiet5sangtiet1chieu(Request $rq){
		$matruong = Session::get('matruong');
		$findidold = rangbuocsotiet5sangtiet1chieu::find($rq->id);
		if($findidold != ''){
			$rangbuocsotiet5sangtiet1chieu = rangbuocsotiet5sangtiet1chieu::find($rq->id);
			$rangbuocsotiet5sangtiet1chieu->magiaovien = $rq->magiaovien;
			$rangbuocsotiet5sangtiet1chieu->sotiet5buoisang = $rq->sotiet5buoisang;
			$rangbuocsotiet5sangtiet1chieu->sotiet1buoichieu = $rq->sotiet1buoichieu;
			$rangbuocsotiet5sangtiet1chieu->matruong = $matruong;
			$rangbuocsotiet5sangtiet1chieu->update();
		}else{
			$rangbuocsotiet5sangtiet1chieu = new rangbuocsotiet5sangtiet1chieu();
			$rangbuocsotiet5sangtiet1chieu->magiaovien = $rq->magiaovien;
			$rangbuocsotiet5sangtiet1chieu->sotiet5buoisang = $rq->sotiet5buoisang;
			$rangbuocsotiet5sangtiet1chieu->matruong = $matruong;
			$rangbuocsotiet5sangtiet1chieu->save();
		}
		$success = 1;
		return json_encode($success);
	}






	//get rang buoc tiet tranh của môn
	public function getlistrangbuoctiettranh(){
		$matruong = Session::get('matruong');
		$monhoc = monhoc::where('matruong',$matruong)->get();
		$rangbuoctiettranh = rangbuoctiettranh::join('danhsachlophoc','danhsachlophoc.id','rangbuoctiettranh.malop')->where('rangbuoctiettranh.malop','<>',null)->where('rangbuoctiettranh.matruong',$matruong)->get();
		$rangbuocchontiet = rangbuoctiettranh::where(function ($query)use($matruong){
			$query->where('malop',null);
			$query->where('matruong',$matruong);
		})->get();
		$data=[];
		$obj  = new stdClass;
		$obj->monhoc = $monhoc;
		$obj->rangbuoctiettranh = $rangbuoctiettranh;
		$obj->rangbuocchontiet = $rangbuocchontiet;
		array_push($data, $obj);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	//chọn tiết ràng buộc tiết tránh
	public function rangbuoctiettranhchontiet(Request $rq){
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$tiet = $rq->tiet;
		$mucrangbuoc = $rq->mucrangbuoc;
		$data = rangbuoctiettranh::where(function ($query) use($monhoc,$matruong){
			$query->where('malop',null);
			$query->where('mamonhoc',$monhoc);
			$query->where('matruong',$matruong);
		})->delete();

		foreach ($tiet as $key=>$value) {
			$mrb = $mucrangbuoc[$key];
			if($value == 0){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 1; 
				$datas->buoi = 0; 
				$datas->matruong = $matruong; 
				$datas->mucrangbuoc = $mrb;
				$success = $datas->save();
			}else if($value == 1){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 2; 
				$datas->buoi = 0; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 2){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 3; 
				$datas->buoi = 0; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 3){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 4; 
				$datas->buoi = 0; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 4){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 5; 
				$datas->buoi = 0; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 5){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 1; 
				$datas->buoi = 1; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 6){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 2; 
				$datas->buoi = 1; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 7){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 3; 
				$datas->buoi = 1; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 8){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 4; 
				$datas->buoi = 1; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}else if($value == 9){
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null; 
				$datas->tiet = 5; 
				$datas->buoi = 1; 
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}

		}
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//chon lop sáng ràng buộc tiết tránh
	public function rangbuoctiettranhchonlops(Request $rq){
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$lops = $rq->lops;
		$data = rangbuoctiettranh::where(function ($query) use($monhoc,$matruong){
			$query->where('matruong',$matruong);
			$query->where('mamonhoc',$monhoc);
			$query->where('malop','<>',null);
			$query->where('buoi',0);
		})->delete();
		foreach ($lops as $key=>$value) {
			$data = rangbuoctiettranh::where(function ($query) use($monhoc,$value,$matruong){
				$query->where('malop',$value);
				$query->where('matruong',$matruong);
				$query->where('mamonhoc',$monhoc);
			})->delete();
			for ($i=1; $i < 6; $i++) { 
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = $value; 
				$datas->tiet = $i; 
				$datas->buoi = 0; 
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}
		}
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	public function rangbuoctiettranhchonlopc(Request $rq){
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$lopc = $rq->lopc;
		$data = rangbuoctiettranh::where(function ($query) use($monhoc,$matruong){
			$query->where('matruong',$matruong);
			$query->where('mamonhoc',$monhoc);
			$query->where('malop','<>',null);
			$query->where('buoi',1);
		})->delete();
		foreach ($lopc as $key=>$value) {
			$data = rangbuoctiettranh::where(function ($query) use($monhoc,$value,$matruong){
				$query->where('matruong',$matruong);
				$query->where('malop',$value);
				$query->where('mamonhoc',$monhoc);
			})->delete();
			for ($i=1; $i < 6; $i++) { 
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = $value; 
				$datas->tiet = $i; 
				$datas->buoi = 1; 
				$datas->matruong = $matruong; 
				$success = $datas->save();
			}
		}
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//rang buộc tránh 2 môn
	public function getlistrangbuoctranh2moncungbuoi(){
		$matruong = Session::get('matruong');
		$monhoc = monhoc::where('matruong',$matruong)->get();
		$rangbuoctranh2moncungbuoi = rangbuoctranh2moncungbuoi::where('rangbuoctranh2moncungbuoi.matruong',$matruong)->join('monhoc','monhoc.id','rangbuoctranh2moncungbuoi.montranh')->get();
		$data=[];
		$obj  = new stdClass;
		$obj->monhoc = $monhoc;
		$obj->rangbuoctranh2moncungbuoi = $rangbuoctranh2moncungbuoi;
		array_push($data, $obj);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function rangbuoctranh2mon(Request $rq){
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$montranh = $rq->montranh;
		$mucrangbuoc = $rq->mucrangbuoc;

		$data = rangbuoctranh2moncungbuoi::where(function ($query) use($monhoc,$matruong){
			$query->where('mamonhoc',$monhoc);
			$query->where('matruong',$matruong);
		})->delete();
		$counts =count($montranh);
		for ($i=0; $i < $counts; $i++) { 
			for ($j=0; $j < 2; $j++) { 
				if($j == 0 ){
					$datas = new rangbuoctranh2moncungbuoi();
					$datas->mamonhoc = $monhoc;
					$datas->montranh = $montranh[$i]; 
					$datas->buoi = 0; 
					$datas->mucrangbuoc = $mucrangbuoc[$i]; 
					$datas->matruong = $matruong;
					$success = $datas->save();
				}elseif ($j == 1) {
					$datas = new rangbuoctranh2moncungbuoi();
					$datas->mamonhoc = $monhoc;
					$datas->montranh = $montranh[$i]; 
					$datas->buoi = 1; 
					$datas->mucrangbuoc = $mucrangbuoc[$i]; 
					$datas->matruong = $matruong;
					$success = $datas->save();
				}
			}
		}

		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}


	//rang buộc cap tiết xếp liền nhau
	public function getlistrangbuoccaptietxepliennhau(){
		$matruong = Session::get('matruong');
		$rangbuoccaptietxepliennhau = rangbuoccaptietxepliennhau::with('monhoc')->with('lophoc')->where('matruong',$matruong)->get();
		return json_encode($rangbuoccaptietxepliennhau, JSON_UNESCAPED_UNICODE);
	}
	public function updaterangbuoccaptietxepliennhau(Request $rq){
		$matruong = Session::get('matruong');
		$id = $rq->id;
		$mamonhoc = $rq->mamonhoc;
		$phamvi = $rq->phamvi;
		$lop = $rq->lop;
		$khoi = $rq->khoi;
		$vitricaptiet = $rq->vitricaptiet;
		$tranhcaptietsang = $rq->tranhcaptietsang;
		$tranhcaptietchieu = $rq->tranhcaptietchieu;
		$mucrangbuoc = $rq->mucrangbuoc;

		$rangbuoccaptietxepliennhau = rangbuoccaptietxepliennhau::where('mamonhoc', '=', $mamonhoc)->orWhere('matruong',$matruong)->first();
		if($rangbuoccaptietxepliennhau == null){
			$datas = new rangbuoccaptietxepliennhau();
			$datas->mamonhoc = $mamonhoc;
			$datas->phamvi = $phamvi;
			$datas->lop = $lop;
			$datas->khoi = $khoi;
			$datas->vitricaptiet = $vitricaptiet;
			$datas->tranhcaptietsang = $tranhcaptietsang;
			$datas->tranhcaptietchieu = $tranhcaptietchieu;
			$datas->mucrangbuoc = $mucrangbuoc;
			$datas->matruong = $matruong;
			$success = $datas->save();
		}else{
			$datas = rangbuoccaptietxepliennhau::find($mamonhoc);
			$datas->mamonhoc = $mamonhoc;
			$datas->phamvi = $phamvi;
			$datas->lop = $lop;
			$datas->khoi = $khoi;
			$datas->vitricaptiet = $vitricaptiet;
			$datas->tranhcaptietsang = $tranhcaptietsang;
			$datas->tranhcaptietchieu = $tranhcaptietchieu;
			$datas->mucrangbuoc = $mucrangbuoc;
			$datas->matruong = $matruong;
			$success = $datas->save();
		}
		return json_encode($rangbuoccaptietxepliennhau, JSON_UNESCAPED_UNICODE);
	}












//a đức
  public function getData()
    {
       $matruong = Session::get('matruong'); // Lay ma truong tu session
        $danhSachMonHoc = monhoc::where('matruong',$matruong)->get();
        $danhsachKhoiLop = khoihoc::where('matruong', $matruong)->get();
        $danhsachKhoi = array();
        $bangphantiet =  sotietngay::where('matruong', $matruong)->get();
        foreach ($danhsachKhoiLop as $itemKhoi) {
            $khoi = new stdClass();
            $khoi->makhoi = $itemKhoi->id;
            $khoi->tenkhoi = $itemKhoi->tenkhoi;
            $lop = danhsachlophoc::where('khoi', '=',  $itemKhoi->id)->get();
            $khoi->danhsachlop = $lop;
            array_push($danhsachKhoi, $khoi);
        }
        return response()->json(["monhoc" => $danhSachMonHoc, "khoihoc" => $danhsachKhoi, "bangphantiet" => $bangphantiet], Response::HTTP_OK);
    }

    public function saveData(Request $request)
    {
        try {
            $data = json_decode($request->data);
            if (count($data)> 0) {
            	$this->deletePhantiet();
            $success = false;
           $matruong = Session::get('matruong'); // Lay ma truong tu session
            foreach ($data as $item) {
                $sotiet = new sotietngay();
                $sotiet->lophoc = $item->lophoc;
                $sotiet->monhoc = $item->monhoc;
                $sotiet->sotiet = $item->sotiet;
                $sotiet->matruong = $matruong;
                if ($sotiet->save()) {
                    $success = true;
                } else {
                    $success = false;
                    $this->deletePhantiet();
                    break;
                }
            }
            if ($success == true) {
                return response()->json(["msg" => "OK"], Response::HTTP_OK);
            } else {
                return response()->json(["msg" => "error"], Response::HTTP_BAD_REQUEST);
            }
            }else{
            	return response()->json(["msg" => "data empty"], Response::HTTP_BAD_REQUEST);
            }
            
        } catch (Exception $ex) {
            return $ex;
        }
    }

    private function deletePhantiet()
    {
        $listDelete =  sotietngay::select('id')->get()->toArray();
        if (count($listDelete) > 0) {
            sotietngay::destroy($listDelete);
        }
    }
    // So tiet toi da buoi

    public function indexBuoi()
    {
        return view('sotiettoidabuoi\index');
    }

    public function getDataBuoi()
    {
        $matruong = Session::get('matruong'); // Lay ma truong tu session
        $danhSachMonHoc = monhoc::where('matruong',$matruong)->get();
        $danhsachKhoiLop = khoihoc::where('matruong', $matruong)->get();
        $danhsachKhoi = array();
        $bangphantiet =  sotietbuoi::where('matruong', $matruong)->get();
        foreach ($danhsachKhoiLop as $itemKhoi) {
            $khoi = new stdClass();
            $khoi->makhoi = $itemKhoi->id;
            $khoi->tenkhoi = $itemKhoi->tenkhoi;
            $lop = danhsachlophoc::where('khoi', '=',  $itemKhoi->id)->get();
            $khoi->danhsachlop = $lop;
            array_push($danhsachKhoi, $khoi);
        }
        return response()->json(["monhoc" => $danhSachMonHoc, "khoihoc" => $danhsachKhoi, "bangphantiet" => $bangphantiet], Response::HTTP_OK);
    }

    public function saveDataBuoi(Request $request)
    {
        try {
        	$data = json_decode($request->data);
        	if (count($data)) {
        		$data = json_decode($request->data);
            $this->deletePhantietBuoi();
            $success = false;
            $matruong = 1; // Lay ma truong tu session
            foreach ($data as $item) {
                $sotiet = new sotietbuoi();
                $sotiet->lophoc = $item->lophoc;
                $sotiet->monhoc = $item->monhoc;
                $sotiet->sotiet = $item->sotiet;
                $sotiet->matruong = $matruong;
                if ($sotiet->save()) {
                    $success = true;
                } else {
                    $success = false;
                    $this->deletePhantiet();
                    break;
                }
            }
            if ($success == true) {
                return response()->json(["msg" => "OK"], Response::HTTP_OK);
            } else {
                return response()->json(["msg" => "error"], Response::HTTP_BAD_REQUEST);
            }
        	}else{
                return response()->json(["msg" => "data empty"], Response::HTTP_BAD_REQUEST);

        	}
            
        } catch (Exception $ex) {
            return $ex;
        }
    }

    private function deletePhantietBuoi()
    {
        $listDelete =  sotietbuoi::select('id')->get()->toArray();
        if (count($listDelete) > 0) {
            sotietbuoi::destroy($listDelete);
        }
    }






}
