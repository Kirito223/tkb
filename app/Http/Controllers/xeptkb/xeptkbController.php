<?php

namespace App\Http\Controllers\xeptkb;

use App\danhsachgv;
use App\danhsachlophoc;
use App\danhsachrangbuoc;
use App\giaovienchuyenmon;
use App\giaovienmonlop;
use App\monhoc;
use App\Objects\XepTKB;
use App\phancongchuyenmon;
use App\phonghoc;
use App\phongmonlop;
use App\sotietmonhoc;
use App\tietghep;
use App\tiethoc;
use App\tietnghigiaovien;
use App\tietcodinh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class xeptkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		return view('xeptkb.index');
	}
	public function uptcrangbuoc(Request $rq){
		$danhsachrangbuoc = danhsachrangbuoc::find($rq->id);
		$danhsachrangbuoc->muc1 = $rq->muc1;
		$danhsachrangbuoc->muc2 = $rq->muc2;
		$danhsachrangbuoc->muc3 = $rq->muc3;
		$success = $danhsachrangbuoc->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}

	public function nguontainguyen()
	{
		$giaovien = danhsachgv::all();
		$monhoc = monhoc::all();
		$danhsachrangbuoc = danhsachrangbuoc::all();
		$tiethoc = tiethoc::all();
		$tietnghigiaovien = tietnghigiaovien::all();
		$tietghep = tietghep::all();
		$sotietmonhoc = sotietmonhoc::all();
		$phonghoc = phonghoc::all();
		$phongmonlop = phongmonlop::all();
		$phancongchuyenmon = phancongchuyenmon::all();
		$giaovienmonlop = giaovienmonlop::all();
		$giaovienchuyenmon = giaovienchuyenmon::all();
		$lophoc = danhsachlophoc::all();
		$tietcodinh = tietcodinh::all();
		$tainguyen = new XepTKB($giaovien, $monhoc, $lophoc, $danhsachrangbuoc, $tiethoc, $tietnghigiaovien, $tietghep, $sotietmonhoc, $phonghoc, $phongmonlop, $phancongchuyenmon, $giaovienmonlop, $giaovienchuyenmon,$tietcodinh);

		return response()->json($tainguyen->jsonSerialize());
	}	
}
