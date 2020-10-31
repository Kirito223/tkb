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
use App\rangbuocdangkybuoitietnghigv;
use App\rangbuocsotiet5sangtiet1chieu;
use App\rangbuoctietgvbuocphaico;
use App\sotietbuoi;
use App\sotietngay;
use App\thututiet;
use App\rangbuocdangkytietnghilop;
use DB;
use Session;
use stdClass;
use App\thongbao;

class rangbuocController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh', 'js-custom', 'js-dev'])->addStyles(['style-macdinh', 'style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id', $matruong)->get();
		$thongbaocount = thongbao::where('trangthai', 0)->where('truong_id', $matruong)->count();
		return view('rangbuoc.index', compact('thongbao', 'thongbaocount'));
	}
	public function getlistrangbuoc()
	{
		$data =  mucrangbuoc::all();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function getlistdanhsachrangbuoc()
	{
		$data =  danhsachrangbuoc::all();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//get khối học
	public function getkhoihoc()
	{
		$matruong = Session::get('matruong');
		$data = khoihoc::with(['danhsachlophoc' => function ($author) use ($matruong) {
			$author->where('danhsachlophoc.matruong', $matruong);
			$author->orderBy('danhsachlophoc.tenlop', 'ASC');
			$author->select('danhsachlophoc.id', 'danhsachlophoc.tenlop', 'danhsachlophoc.khoi', 'danhsachlophoc.matruong');
		}])
			->where('khoihoc.matruong', $matruong)
			->select('id', 'tenkhoi')
			->orderBy('tenkhoi', 'ASC')
			->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	public function getrangbuoctietcodinh()
	{
		$matruong = Session::get('matruong');
		// $data =  monhoc::where('matruong',$matruong)->with(['danhsachlophocrb'=>function($author){
		// 	$author->select('danhsachlophoc.id','danhsachlophoc.tenlop','danhsachlophoc.khoi','rangbuoctietcodinh.id as idrbtcd','rangbuoctietcodinh.mamonhoc','rangbuoctietcodinh.mamucrangbuoc','rangbuoctietcodinh.buoi','rangbuoctietcodinh.thu','rangbuoctietcodinh.tiet','mucrangbuoc.mucrangbuoc');
		// 	$author->join('mucrangbuoc','mucrangbuoc.id','=','rangbuoctietcodinh.mamucrangbuoc');
		// 	// $author->with(['mucrangbuoc'=>function($to){
		// 	// 	$to->select('mucrangbuoc.id','mucrangbuoc.mucrangbuoc');
		// 	// }]);
		// }])
		// ->select('id','tenmonhoc')
		// ->get();
		// return json_encode($data, JSON_UNESCAPED_UNICODE);
		$datarbtcd = DB::table('rangbuoctietcodinh')
			->leftjoin('danhsachlophoc', 'danhsachlophoc.id', '=', 'rangbuoctietcodinh.malop')
			->leftjoin('monhoc', 'monhoc.id', '=', 'rangbuoctietcodinh.mamonhoc')
			->leftjoin('mucrangbuoc', 'mucrangbuoc.id', '=', 'rangbuoctietcodinh.mamucrangbuoc')
			->where('rangbuoctietcodinh.matruong', $matruong)
			->select('rangbuoctietcodinh.id', 'rangbuoctietcodinh.malop', 'rangbuoctietcodinh.mamonhoc', 'rangbuoctietcodinh.mamucrangbuoc', 'rangbuoctietcodinh.buoi', 'rangbuoctietcodinh.thu', 'rangbuoctietcodinh.tiet', 'rangbuoctietcodinh.matruong', 'danhsachlophoc.tenlop', 'danhsachlophoc.khoi', 'monhoc.tenmonhoc', 'mucrangbuoc.mucrangbuoc')
			->orderBy('rangbuoctietcodinh.buoi', 'ASC')
			->orderBy('danhsachlophoc.khoi', 'ASC')
			->get();

		$buoithu = array(
			array(
				'idbuoi' => 0,
				'idthu' => 2,
				"tenbuoithu" => "Thứ 2 - Sáng"
			),
			array(
				'idbuoi' => 0,
				'idthu' => 3,
				"tenbuoithu" => "Thứ 3 - Sáng"
			),
			array(
				'idbuoi' => 0,
				'idthu' => 4,
				"tenbuoithu" => "Thứ 4 - Sáng"
			),
			array(
				'idbuoi' => 0,
				'idthu' => 5,
				"tenbuoithu" => "Thứ 5 - Sáng"
			),
			array(
				'idbuoi' => 0,
				'idthu' => 6,
				"tenbuoithu" => "Thứ 6 - Sáng"
			),
			array(
				'idbuoi' => 0,
				'idthu' => 7,
				"tenbuoithu" => "Thứ 7 - Sáng"
			),
			array(
				'idbuoi' => 1,
				'idthu' => 2,
				"tenbuoithu" => "Thứ 2 - Chiều"
			),
			array(
				'idbuoi' => 1,
				'idthu' => 3,
				"tenbuoithu" => "Thứ 3 - Chiều"
			),
			array(
				'idbuoi' => 1,
				'idthu' => 4,
				"tenbuoithu" => "Thứ 4 - Chiều"
			),
			array(
				'idbuoi' => 1,
				'idthu' => 5,
				"tenbuoithu" => "Thứ 5 - Chiều"
			),
			array(
				'idbuoi' => 1,
				'idthu' => 6,
				"tenbuoithu" => "Thứ 6 - Chiều"
			),
			array(
				'idbuoi' => 1,
				'idthu' => 7,
				"tenbuoithu" => "Thứ 7 - Chiều"
			)
		);

		$tiet = array(
			array(
				'tiet' => 1
			),
			array(
				'tiet' => 2
			),
			array(
				'tiet' => 3
			),
			array(
				'tiet' => 4
			),
			array(
				'tiet' => 5
			)
		);

		$databt = array();
		foreach ($datarbtcd as $d) {
			foreach ($buoithu as $b) {
				foreach ($tiet as $t) {
					if ($d->buoi == $b['idbuoi'] && $d->thu == $b['idthu'] && $d->tiet == $t['tiet']) {
						$btt = $b['idthu'] . ',' . $b['idbuoi'] . ',' . $t['tiet'];
						$mabuoi = $b['idbuoi'];
						$mathu = $b['idthu'];
						$tenbuoithu = $b['tenbuoithu'];
						array_push($databt, array('id' => $d->id, 'malop' => $d->malop, 'mamonhoc' => $d->mamonhoc, 'mamucrangbuoc' => $d->mamucrangbuoc, 'mabuoi' => $mabuoi, 'mathu' => $mathu, 'mabuoithutiet' => $btt, 'tiet' => $d->tiet, 'tenbuoithu' => $tenbuoithu, 'tenlop' => $d->tenlop, 'khoi' => $d->khoi, 'tenmonhoc' => $d->tenmonhoc, 'mucrangbuoc' => $d->mucrangbuoc));
					}
				}
			}
		}

		foreach ($databt as $d) {
			$mamonhoc = $d['mamonhoc'];
			$mabuoithu = $d['mabuoithutiet'];
			$grouped[$mamonhoc][$mabuoithu][] = $d;
		}
		foreach ($grouped as $k => $v) {
			$databuoithu = [];
			$tenmonhoc = null;
			foreach ($v as $k1 => $v1) {
				$datarbtcd = [];
				$mabuoi;
				$mathu;
				$mamucrangbuoc;
				$tenbuoithu;
				$mamonhoc;
				$tiet;
				$tenmucrangbuoc;
				foreach ($v1 as $k2 => $v2) {
					$tenmonhoc = $v2['tenmonhoc'];
					$mabuoi = $v2['mabuoi'];
					$mathu = $v2['mathu'];
					$mamucrangbuoc = $v2['mamucrangbuoc'];
					$tenbuoithu = $v2['tenbuoithu'];
					$mamonhoc = $v2['mamonhoc'];
					$tiet = $v2['tiet'];
					$tenmucrangbuoc = $v2['mucrangbuoc'];
					array_push($datarbtcd, array('marbtcd' => $v2['id'], 'malop' => $v2['malop'], 'tenlop' => $v2['tenlop'], 'khoi' => $v2['khoi']));
				}

				array_push($databuoithu, array('mathubuoitiet' => $k1, 'mabuoi' => $mabuoi, 'mathu' => $mathu, 'tenbuoithu' => $tenbuoithu, 'tiet' => $tiet, 'mamonhoc' => $mamonhoc, 'mamucrangbuoc' => $mamucrangbuoc, 'tenmucrangbuoc' => $tenmucrangbuoc, 'dsrbtcd' => $datarbtcd));
			}
			$new_data_rbtcd[] = array('mamonhoc' => $k, 'tenmonhoc' => $tenmonhoc, 'dsbuoithu' => $databuoithu);
		}

		return json_encode($new_data_rbtcd, JSON_UNESCAPED_UNICODE);
	}

	public function delmonhocrangbuoctietcodinh(Request $rq)
	{
		$matruong = Session::get('matruong');
		$datarbtcdmh = DB::table('rangbuoctietcodinh')
			->where('rangbuoctietcodinh.mamonhoc', $rq->idmonhoc)
			->where('rangbuoctietcodinh.matruong', $matruong)
			->select('*')
			->get();

		foreach ($datarbtcdmh as $d) {
			rangbuoctietcodinh::destroy($d->id);
		}
		$success = 1;
		return json_encode($success);
	}

	//add ràng buộc tiết cố định tiết học
	public function addrangbuoctietcodinhtiethoc(Request $rq)
	{
		$matruong = Session::get('matruong');
		$datalh = danhsachlophoc::where('matruong', $matruong)->get();
		$dataidklad = json_decode($rq->idkhoilopapdung);
		$dataidadtt = json_decode($rq->idapdungtoantruong);
		if ($dataidklad != '') {
			foreach ($dataidklad as $d) {
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
		if ($dataidadtt != '') {
			foreach ($dataidadtt as $d) {
				foreach ($datalh as $d1) {
					if ($d->id == $d1->khoi) {
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
	public function updaterangbuoctietcodinhtiethoc(Request $rq)
	{
		$matruong = Session::get('matruong');
		$datalh = danhsachlophoc::where('matruong', $matruong)->get();
		$idrbtcds = json_decode($rq->idrbtcds);
		$dataidklad = json_decode($rq->idkhoilopapdung);
		$dataidadtt = json_decode($rq->idapdungtoantruong);

		foreach ($idrbtcds as $i) {
			rangbuoctietcodinh::destroy($i->idrbtcds);
		}

		if ($dataidklad != '') {
			foreach ($dataidklad as $d) {
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
		if ($dataidadtt != '') {
			foreach ($dataidadtt as $d) {
				foreach ($datalh as $d1) {
					if ($d->id == $d1->khoi) {
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
		$idrbtcd = json_decode($rq->idrbtcd);

		foreach ($idrbtcd as $i) {
			rangbuoctietcodinh::destroy($i->idrbtcd);
		}
		$success = 1;
		return json_encode($success);
	}



	//get tiết họp của tổ
	public function gettiethopcuato()
	{
		$matruong = Session::get('matruong');
		$data = tiethopcuato::where('matruong', $matruong)->with(['tochuyenmon' => function ($author) {
			$author->select('tochuyenmon.id', 'tochuyenmon.tentocm');
		}])
			->select('id', 'matochuyenmon', 'buoi', 'thu', 'tiet')
			->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//add tiết họp của tổ
	public function addtiethopcuato(Request $rq)
	{
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
	public function updatetiethopcuato(Request $rq)
	{
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
	public function deltiethopcuatoall(Request $rq)
	{
		$matruong = Session::get('matruong');
		$id = $rq->id;
		foreach ($id as $i) {
			$tiethopcuato = tiethopcuato::destroy($i['id']);
		}
		$success = 1;
		return json_encode($success);
	}


	//get gv buộc phải có
	public function gettietgvbuocphaico()
	{
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong', $matruong)->with(['monhoc' => function ($author) {
			$author->select('monhoc.id', 'monhoc.tenmonhoc', 'phancongchuyenmon.malop', 'phancongchuyenmon.magiaovien', 'phancongchuyenmon.mamonhoc', 'phancongchuyenmon.sotiet');
			$author->with(['danhsachlophoc' => function ($to) {
				// $to->join('phancongchuyenmon','phancongchuyenmon.malop','=','danhsachlophoc.id')
				$to->select('danhsachlophoc.id', 'danhsachlophoc.tenlop');
			}]);
		}])
			->with(['rangbuoctietgvbuocphaico' => function ($author1) {
				$author1->select('rangbuoctietgvbuocphaico.id', 'rangbuoctietgvbuocphaico.magiaovien', 'rangbuoctietgvbuocphaico.mamucrangbuoc', 'rangbuoctietgvbuocphaico.buoi', 'rangbuoctietgvbuocphaico.thu', 'rangbuoctietgvbuocphaico.tiet', 'rangbuoctietgvbuocphaico.lop');
			}])
			->select('id', 'hovaten', 'bidanh', 'thutuhienthi')
			->get();
		return response()->json($data);
	}
	//add ràng buộc tiết cố định tiết học
	public function addrangbuoctietgvbuocphaico(Request $rq)
	{
		$matruong = Session::get('matruong');
		$iddktgvbpc = json_decode($rq->iddktgvbpc);
		// $idthu = $rq->idthu;
		$datatietnghi = json_decode($rq->datatietnghi);
		if ($iddktgvbpc != '') {
			foreach ($iddktgvbpc as $i) {
				rangbuoctietgvbuocphaico::destroy($i->iddktgvbpc);
			}
		}

		if ($datatietnghi != '') {
			foreach ($datatietnghi as $d) {
				foreach ($d->idClass as $key => $class) {
					foreach ($d->idthu as $t) {
						$tietgvbuocphaico = new rangbuoctietgvbuocphaico();
						$tietgvbuocphaico->magiaovien = $d->idgv;
						$tietgvbuocphaico->mamucrangbuoc = $d->idmrb;
						$tietgvbuocphaico->buoi = $d->idbuoi;
						$tietgvbuocphaico->thu = $t->id;
						$tietgvbuocphaico->tiet = $d->idtiet;
						$tietgvbuocphaico->matruong = $matruong;
						$tietgvbuocphaico->lop = $class->id;
						$tietgvbuocphaico->save();
					}
				}
			}
		}
		$success = 1;
		return json_encode($success);
	}


	//get đăng ký buổi/tiết nghỉ của gv
	public function getdangkybuoitietnghicuagv()
	{
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong', $matruong)->with(['monhoc' => function ($author) use ($matruong) {
			$author->select('monhoc.id', 'monhoc.tenmonhoc', 'phancongchuyenmon.malop', 'phancongchuyenmon.magiaovien', 'phancongchuyenmon.mamonhoc', 'phancongchuyenmon.sotiet');
			$author->with(['danhsachlophoc' => function ($to) use ($matruong) {
				// $to->join('phancongchuyenmon','phancongchuyenmon.malop','=','danhsachlophoc.id')
				$to->where('matruong', $matruong);
				$to->select('danhsachlophoc.id', 'danhsachlophoc.tenlop');
			}]);
		}])
			->with(['rangbuocdangkybuoitietnghigv' => function ($author1) {
				$author1->select('rangbuocdangkybuoitietnghigv.id', 'rangbuocdangkybuoitietnghigv.magiaovien', 'rangbuocdangkybuoitietnghigv.mamucrangbuoc', 'rangbuocdangkybuoitietnghigv.buoi', 'rangbuocdangkybuoitietnghigv.thu', 'rangbuocdangkybuoitietnghigv.tiet');
			}])
			->select('id', 'hovaten', 'bidanh', 'thutuhienthi')
			->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	// add ràng buộc đăng ký tiết nghỉ của gv
	public function addrangbuocdangkytietnghigv(Request $rq)
	{
		$matruong = Session::get('matruong');
		$iddktn = json_decode($rq->iddktn);
		// $idthu = $rq->idthu;
		$datatietnghi = json_decode($rq->datatietnghi);
		if ($iddktn != '') {
			foreach ($iddktn as $i) {
				rangbuocdangkybuoitietnghigv::destroy($i->iddktn);
			}
		}

		if ($datatietnghi != '') {
			foreach ($datatietnghi as $d) {
				foreach ($d->idthu as $t) {
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
	public function addrangbuocdangkybuoinghigv(Request $rq)
	{
		$matruong = Session::get('matruong');
		$data_buoi_mrb = json_decode($rq->data_buoi_mrb);
		$iddkbn = json_decode($rq->iddkbn);
		$idthu = $rq->idthu;
		$datatietnghi = $rq->datatietnghi;
		if ($iddkbn != '') {
			foreach ($iddkbn as $i) {
				rangbuocdangkybuoitietnghigv::destroy($i->iddkbn);
			}
		}

		if ($data_buoi_mrb != null) {
			foreach ($data_buoi_mrb as $d) {
				$dangkybuoinghigv = new rangbuocdangkybuoitietnghigv();
				$dangkybuoinghigv->magiaovien = $rq->idgv;
				$dangkybuoinghigv->mamucrangbuoc = $d->idmrb;
				$dangkybuoinghigv->buoi = (string) $d->idbuoi;
				$dangkybuoinghigv->thu = (string) $d->idthu;
				$dangkybuoinghigv->matruong = $matruong;
				$success = $dangkybuoinghigv->save();
			}
		} else {
			$success = 1;
			return json_encode($success, JSON_UNESCAPED_UNICODE);
		}
	}


	//rang buoc buoi nghi all
	public function  addrangbuocbuoinghiall(Request $rq)
	{
		$matruong = Session::get('matruong');
		$magvs = $rq->magv;
		$thubuoi = $rq->thubuoi;
		$mrb = $rq->mrb;
		foreach ($magvs as $key) {
			$datas = (object)$key;
			$magiaovien = $datas->id;
			foreach ($thubuoi as $keys) {
				$data2 = (object)$keys;
				$thu = $data2->thu;
				$buoi = $data2->buoi;
				$rangbuocbuoinghi = rangbuocdangkybuoitietnghigv::where(function ($query) use ($thu, $buoi, $magiaovien, $matruong) {
					$query->where('tiet', '=', null);
					$query->where('thu', '=', $thu);
					$query->where('magiaovien', '=', $magiaovien);
					$query->where('buoi', '=', $buoi);
					$query->where('matruong', $matruong);
				})->first();
				if ($rangbuocbuoinghi == null) {
					$data = new rangbuocdangkybuoitietnghigv();
					$data->magiaovien = $magiaovien;
					$data->thu = $thu;
					$data->buoi = $buoi;
					$data->matruong = $matruong;
					$data->mamucrangbuoc = $mrb;
					$success = $data->save();
				} else {
					$rangbuocbuoinghi = rangbuocdangkybuoitietnghigv::where(function ($query) use ($thu, $buoi, $magiaovien, $matruong) {
						$query->where('tiet', '=', null);
						$query->where('thu', '=', $thu);
						$query->where('magiaovien', '=', $magiaovien);
						$query->where('buoi', '=', $buoi);
						$query->where('matruong', $matruong);
					})->delete();
					$data = new rangbuocdangkybuoitietnghigv();
					$data->magiaovien = $magiaovien;
					$data->thu = $thu;
					$data->buoi = $buoi;
					$data->matruong = $matruong;
					$data->mamucrangbuoc = $mrb;
					$success = $data->save();
				}
			}
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}


	//rang buoc tiet nghi all
	public function  addrangbuoctietnghiall(Request $rq)
	{
		$matruong = Session::get('matruong');
		$magvs = $rq->magv;
		$buoitiet = $rq->buoitiet;
		$mrb = $rq->mrb;
		$dsapdung = $rq->dsapdung;
		foreach ($magvs as $key) {
			$datas = (object)$key;
			$magiaovien = $datas->id;
			foreach ($buoitiet as $keys) {
				$data2 = (object)$keys;
				$tiet = $data2->tiet;
				$buoi = $data2->buoi;
				$rangbuocbuoinghi = rangbuocdangkybuoitietnghigv::where(function ($query) use ($buoi, $magiaovien, $matruong, $tiet) {
					$query->where('tiet', '=', $tiet);
					$query->where('buoi', '=', $buoi);
					$query->where('magiaovien', '=', $magiaovien);
					$query->where('matruong', $matruong);
				})->first();
				if ($rangbuocbuoinghi == null) {
					foreach ($dsapdung as $keys) {
						$data = new rangbuocdangkybuoitietnghigv();
						$data->magiaovien = $magiaovien;
						$data->thu = $keys;
						$data->buoi = $buoi;
						$data->tiet = $tiet;
						$data->matruong = $matruong;
						$data->mamucrangbuoc = $mrb;
						$success = $data->save();
					}
				} else {
					$rangbuocbuoinghi = rangbuocdangkybuoitietnghigv::where(function ($query) use ($buoi, $magiaovien, $matruong, $tiet) {
						$query->where('buoi', '=', $buoi);
						$query->where('tiet', '=', $tiet);
						$query->where('magiaovien', '=', $magiaovien);
						$query->where('matruong', $matruong);
					})->delete();
					foreach ($dsapdung as $keys) {
						$data = new rangbuocdangkybuoitietnghigv();
						$data->magiaovien = $magiaovien;
						$data->thu = $keys;
						$data->buoi = $buoi;
						$data->tiet = $tiet;
						$data->matruong = $matruong;
						$data->mamucrangbuoc = $mrb;
						$success = $data->save();
					}
				}
			}
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}






	//ràng buộc số tiết 5 sáng (tiết 1 chiều)
	public function getrangbuocsotiet5sangtiet1chieu()
	{
		$matruong = Session::get('matruong');
		$data =  danhsachgv::where('matruong', $matruong)->with(['rangbuocsotiet5sangtiet1chieu' => function ($author1) {
			$author1->select('rangbuocsotiet5sangtiet1chieu.id', 'rangbuocsotiet5sangtiet1chieu.magiaovien', 'rangbuocsotiet5sangtiet1chieu.sotiet5buoisang', 'rangbuocsotiet5sangtiet1chieu.sotiet1buoichieu');
		}])
			->select('id', 'hovaten', 'bidanh', 'thutuhienthi')
			->get();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//update ràng buộc số tiết 5 sáng (tiết 1 chiều)
	public function updatesotiet5sangtiet1chieu(Request $rq)
	{
		$matruong = Session::get('matruong');
		$findidold = rangbuocsotiet5sangtiet1chieu::find($rq->id);
		if ($findidold != '') {
			$rangbuocsotiet5sangtiet1chieu = rangbuocsotiet5sangtiet1chieu::find($rq->id);
			$rangbuocsotiet5sangtiet1chieu->magiaovien = $rq->magiaovien;
			$rangbuocsotiet5sangtiet1chieu->sotiet5buoisang = $rq->sotiet5buoisang;
			$rangbuocsotiet5sangtiet1chieu->sotiet1buoichieu = $rq->sotiet1buoichieu;
			$rangbuocsotiet5sangtiet1chieu->matruong = $matruong;
			$rangbuocsotiet5sangtiet1chieu->update();
		} else {
			$rangbuocsotiet5sangtiet1chieu = new rangbuocsotiet5sangtiet1chieu();
			$rangbuocsotiet5sangtiet1chieu->magiaovien = $rq->magiaovien;
			$rangbuocsotiet5sangtiet1chieu->sotiet5buoisang = $rq->sotiet5buoisang;
			$rangbuocsotiet5sangtiet1chieu->sotiet1buoichieu = $rq->sotiet1buoichieu;
			$rangbuocsotiet5sangtiet1chieu->matruong = $matruong;
			$rangbuocsotiet5sangtiet1chieu->save();
		}
		$success = 1;
		return json_encode($success);
	}






	//get rang buoc tiet tranh của môn
	public function getlistrangbuoctiettranh()
	{
		$matruong = Session::get('matruong');
		$monhoc = monhoc::where('matruong', $matruong)->get();
		$rangbuoctiettranh = rangbuoctiettranh::join('danhsachlophoc', 'danhsachlophoc.id', 'rangbuoctiettranh.malop')->where('rangbuoctiettranh.malop', '<>', null)->where('rangbuoctiettranh.matruong', $matruong)->get();
		$rangbuocchontiet = rangbuoctiettranh::where(function ($query) use ($matruong) {
			$query->where('malop', null);
			$query->where('matruong', $matruong);
		})->get();
		$data = [];
		$obj  = new stdClass;
		$obj->monhoc = $monhoc;
		$obj->rangbuoctiettranh = $rangbuoctiettranh;
		$obj->rangbuocchontiet = $rangbuocchontiet;
		array_push($data, $obj);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	//chọn tiết ràng buộc tiết tránh
	public function rangbuoctiettranhchontiet(Request $rq)
	{
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$tiet = $rq->tiet;
		$mucrangbuoc = $rq->mucrangbuoc;
		$data = rangbuoctiettranh::where(function ($query) use ($monhoc, $matruong) {
			$query->where('malop', null);
			$query->where('mamonhoc', $monhoc);
			$query->where('matruong', $matruong);
		})->delete();

		foreach ($tiet as $key => $value) {
			$mrb = $mucrangbuoc[$key];
			if ($value == 0) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 1;
				$datas->buoi = 0;
				$datas->matruong = $matruong;
				$datas->mucrangbuoc = $mrb;
				$success = $datas->save();
			} else if ($value == 1) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 2;
				$datas->buoi = 0;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 2) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 3;
				$datas->buoi = 0;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 3) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 4;
				$datas->buoi = 0;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 4) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 5;
				$datas->buoi = 0;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 5) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 1;
				$datas->buoi = 1;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 6) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 2;
				$datas->buoi = 1;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 7) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 3;
				$datas->buoi = 1;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 8) {
				$datas = new rangbuoctiettranh();
				$datas->mamonhoc = $monhoc;
				$datas->malop = null;
				$datas->tiet = 4;
				$datas->buoi = 1;
				$datas->mucrangbuoc = $mrb;
				$datas->matruong = $matruong;
				$success = $datas->save();
			} else if ($value == 9) {
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
	public function rangbuoctiettranhchonlops(Request $rq)
	{
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$lops = $rq->lops;
		$data = rangbuoctiettranh::where(function ($query) use ($monhoc, $matruong) {
			$query->where('matruong', $matruong);
			$query->where('mamonhoc', $monhoc);
			$query->where('malop', '<>', null);
			$query->where('buoi', 0);
		})->delete();
		foreach ($lops as $key => $value) {
			$data = rangbuoctiettranh::where(function ($query) use ($monhoc, $value, $matruong) {
				$query->where('malop', $value);
				$query->where('matruong', $matruong);
				$query->where('mamonhoc', $monhoc);
			})->delete();
			for ($i = 1; $i < 6; $i++) {
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

	public function rangbuoctiettranhchonlopc(Request $rq)
	{
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$lopc = $rq->lopc;
		$data = rangbuoctiettranh::where(function ($query) use ($monhoc, $matruong) {
			$query->where('matruong', $matruong);
			$query->where('mamonhoc', $monhoc);
			$query->where('malop', '<>', null);
			$query->where('buoi', 1);
		})->delete();
		foreach ($lopc as $key => $value) {
			$data = rangbuoctiettranh::where(function ($query) use ($monhoc, $value, $matruong) {
				$query->where('matruong', $matruong);
				$query->where('malop', $value);
				$query->where('mamonhoc', $monhoc);
			})->delete();
			for ($i = 1; $i < 6; $i++) {
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
	public function getlistrangbuoctranh2moncungbuoi()
	{
		$matruong = Session::get('matruong');
		$monhoc = monhoc::where('matruong', $matruong)->get();
		$rangbuoctranh2moncungbuoi = rangbuoctranh2moncungbuoi::where('rangbuoctranh2moncungbuoi.matruong', $matruong)->join('monhoc', 'monhoc.id', 'rangbuoctranh2moncungbuoi.montranh')->get();
		$data = [];
		$obj  = new stdClass;
		$obj->monhoc = $monhoc;
		$obj->rangbuoctranh2moncungbuoi = $rangbuoctranh2moncungbuoi;
		array_push($data, $obj);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function rangbuoctranh2mon(Request $rq)
	{
		$matruong = Session::get('matruong');
		$monhoc = $rq->monhoc;
		$montranh = $rq->montranh;
		$mucrangbuoc = $rq->mucrangbuoc;

		$data = rangbuoctranh2moncungbuoi::where(function ($query) use ($monhoc, $matruong) {
			$query->where('mamonhoc', $monhoc);
			$query->where('matruong', $matruong);
		})->delete();
		$counts = count($montranh);
		for ($i = 0; $i < $counts; $i++) {
			for ($j = 0; $j < 2; $j++) {
				if ($j == 0) {
					$datas = new rangbuoctranh2moncungbuoi();
					$datas->mamonhoc = $monhoc;
					$datas->montranh = $montranh[$i];
					$datas->buoi = 0;
					$datas->mucrangbuoc = $mucrangbuoc[$i];
					$datas->matruong = $matruong;
					$success = $datas->save();
				} elseif ($j == 1) {
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
	public function getlistrangbuoccaptietxepliennhau()
	{
		$matruong = Session::get('matruong');
		$rangbuoccaptietxepliennhau = rangbuoccaptietxepliennhau::with('monhoc')->with('lophoc')->where('matruong', $matruong)->get();
		return json_encode($rangbuoccaptietxepliennhau, JSON_UNESCAPED_UNICODE);
	}
	public function updaterangbuoccaptietxepliennhau(Request $rq)
	{
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

		$rangbuoccaptietxepliennhau = rangbuoccaptietxepliennhau::where(function ($query) use ($mamonhoc, $matruong) {
			$query->where('mamonhoc', '=', $mamonhoc);
			$query->where('matruong', $matruong);
		})->first();
		if ($rangbuoccaptietxepliennhau == null) {
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
		} else {
			$datas = rangbuoccaptietxepliennhau::where('mamonhoc', '=', $mamonhoc)->orWhere('matruong', $matruong)->first();
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
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}



	public function dellrangbuoccaptietxepliennhau(Request $rq)
	{
		$rangbuoccaptietxepliennhau = rangbuoccaptietxepliennhau::destroy($rq->id);
		return json_encode($rangbuoccaptietxepliennhau, JSON_UNESCAPED_UNICODE);
	}

	public function dellrangbuoccaptietxepliennhauall(Request $rq)
	{
		$matruong = Session::get('matruong');
		$data = rangbuoccaptietxepliennhau::where(function ($query) use ($matruong) {
			$query->where('matruong', $matruong);
		})->delete();
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}








	//a đức
	public function getData()
	{
		$matruong = Session::get('matruong'); // Lay ma truong tu session
		$danhSachMonHoc = monhoc::where('matruong', $matruong)->get();
		$danhsachKhoiLop = khoihoc::where('matruong', $matruong)->orderBy('tenkhoi', 'ASC')->get();
		$danhsachKhoi = array();
		$bangphantiet =  sotietngay::where('matruong', $matruong)->get();
		foreach ($danhsachKhoiLop as $itemKhoi) {
			$khoi = new stdClass();
			$khoi->makhoi = $itemKhoi->id;
			$khoi->tenkhoi = $itemKhoi->tenkhoi;
			$lop = danhsachlophoc::where('matruong', $matruong)->where('khoi', '=',  $itemKhoi->tenkhoi)->orderBy('tenlop', 'ASC')->get();
			$khoi->danhsachlop = $lop;
			array_push($danhsachKhoi, $khoi);
		}
		return response()->json(["monhoc" => $danhSachMonHoc, "khoihoc" => $danhsachKhoi, "bangphantiet" => $bangphantiet], Response::HTTP_OK);
	}

	public function saveData(Request $request)
	{
		try {
			$data = json_decode($request->data);
			if (count($data) > 0) {
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
			} else {
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
		$danhSachMonHoc = monhoc::where('matruong', $matruong)->get();
		$danhsachKhoiLop = khoihoc::where('matruong', $matruong)->orderBy('tenkhoi', 'ASC')->get();
		$danhsachKhoi = array();
		$bangphantiet =  sotietbuoi::where('matruong', $matruong)->get();
		foreach ($danhsachKhoiLop as $itemKhoi) {
			$khoi = new stdClass();
			$khoi->makhoi = $itemKhoi->id;
			$khoi->tenkhoi = $itemKhoi->tenkhoi;
			$lop = danhsachlophoc::where('matruong', $matruong)->where('khoi', '=',  $itemKhoi->tenkhoi)->orderBy('tenlop', 'ASC')->get();
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
				$matruong = Session::get('matruong');
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
			} else {
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



	public function getrangbuocthututiet()
	{
		$matruong = Session::get('matruong');
		$thututiet = thututiet::where('matruong', $matruong)->orderBy('thutu', 'ASC')->get();
		$monhoc = monhoc::where('matruong', $matruong)->get();
		$khoi = khoihoc::where('matruong', $matruong)->orderBy('tenkhoi', 'ASC')->get();
		return json_encode([$khoi, $thututiet, $monhoc], JSON_UNESCAPED_UNICODE);
	}

	public function addrangbuocthututiet(Request $rq)
	{
		$matruong = Session::get('matruong');
		$data = new thututiet();
		$data->mamonhoc = $rq->mamonhoc;
		$data->makhoi = $rq->makhoi;
		$data->thutu = $rq->thutu;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	public function updaterangbuocthututiet(Request $rq)
	{
		$matruong = Session::get('matruong');
		$data = thututiet::find($rq->id);
		$data->mamonhoc = $rq->mamonhoc;
		$data->makhoi = $rq->makhoi;
		$data->thutu = $rq->thutu;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function dellrangbuocthututiet(Request $rq)
	{
		$thututiet = thututiet::destroy($rq->id);
		return json_encode($thututiet, JSON_UNESCAPED_UNICODE);
	}
	public function dellrangbuocthututietall(Request $rq)
	{
		$matruong = Session::get('matruong');
		$idgv = $rq->id;
		foreach ($idgv as $key) {
			foreach ($key as $value) {
				$thututiet = thututiet::destroy($value);
			}
		}
		return json_encode($thututiet, JSON_UNESCAPED_UNICODE);
	}
	public function updatethututietthutuhienthi(Request $rq)
	{
		$thututiet = thututiet::find($rq->id);
		$thututiet->thutu = $rq->thutu;
		$success = $thututiet->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}




	public function getrangbuoctietnghilop()
	{
		$matruong = Session::get('matruong');
		$lophoc = danhsachlophoc::where('matruong', $matruong)->orderBy('tenlop', 'ASC')->get();
		$rangbuocdangkytietnghilop = rangbuocdangkytietnghilop::where('matruong', $matruong)->get();
		return json_encode([$rangbuocdangkytietnghilop, $lophoc], JSON_UNESCAPED_UNICODE);
	}

	public function addrangbuoctietnghilop(Request $rq)
	{
		$matruong = Session::get('matruong');
		$data = new rangbuocdangkytietnghilop();
		$data->malop = $rq->malop;
		$data->buoi = $rq->buoi;
		$data->thu = $rq->thu;
		$data->tiet = $rq->tiet;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	public function updaterangbuoctietnghilop(Request $rq)
	{
		$matruong = Session::get('matruong');
		$data = rangbuocdangkytietnghilop::find($rq->id);
		$data->malop = $rq->malop;
		$data->buoi = $rq->buoi;
		$data->thu = $rq->thu;
		$data->tiet = $rq->tiet;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function dellrangbuoctietnghilop(Request $rq)
	{
		$rangbuocdangkytietnghilop = rangbuocdangkytietnghilop::destroy($rq->id);
		return json_encode($rangbuocdangkytietnghilop, JSON_UNESCAPED_UNICODE);
	}
	public function dellrangbuoctietnghilopall(Request $rq)
	{
		$matruong = Session::get('matruong');
		$idgv = $rq->id;
		foreach ($idgv as $key) {
			foreach ($key as $value) {
				$rangbuocdangkytietnghilop = rangbuocdangkytietnghilop::destroy($value);
			}
		}
		return json_encode($rangbuocdangkytietnghilop, JSON_UNESCAPED_UNICODE);
	}
	public function addtietnghilopmulti(Request $rq)
	{
		$matruong = Session::get('matruong');
		$malop = $rq->lop;
		$thu = $rq->thu;
		$buoi = $rq->buoi;
		$tiet = $rq->tiet;
		foreach ($malop as $key) {
			$rangbuocdangkytietnghilop = rangbuocdangkytietnghilop::where(function ($query) use ($key, $matruong) {
				$query->where('malop', '=', $key);
				$query->where('matruong', $matruong);
			})->first();
			if ($rangbuocdangkytietnghilop == null) {
				$data = new rangbuocdangkytietnghilop();
				$data->malop = $key;
				$data->buoi = $buoi;
				$data->thu = $thu;
				$data->tiet = $tiet;
				$data->matruong = $matruong;
				$success = $data->save();
			} else {
				$rangbuocdangkytietnghilop->malop = $key;
				$rangbuocdangkytietnghilop->buoi = $buoi;
				$rangbuocdangkytietnghilop->thu = $thu;
				$rangbuocdangkytietnghilop->tiet = $tiet;
				$rangbuocdangkytietnghilop->matruong = $matruong;
				$success = $rangbuocdangkytietnghilop->save();
			}
		}

		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
}
