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
use App\sotiettrongbuoi;
use App\rangbuoctietcodinh;
use App\rangbuocdangkybuoitietnghigv;
use App\rangbuoccaptietxepliennhau;
use App\rangbuocdangkytietnghilop;
use App\rangbuoctiettranh;
use App\rangbuocsotiet5sangtiet1chieu;
use App\rangbuoctietgvbuocphaico;
use App\rangbuoctiethopcuato;
use App\rangbuoctranh2moncungbuoi;
use App\giaovien_chuyenmon;
use App\diemtruong;
use App\truong;
use App\thututiet;
use stdClass;
use Session; 
use App\thoikhoabieu;
use App\thongbao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class xeptkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('xeptkb.index',compact('thongbao', 'thongbaocount'));
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
		$matruong = Session::get('matruong');
		$giaovien = danhsachgv::where('matruong',$matruong)->get();
		$monhoc = monhoc::where('matruong',$matruong)->get();
		$danhsachrangbuoc = danhsachrangbuoc::all();
		$tiethoc = tiethoc::where('matruong',$matruong)->get();
		$tietnghigiaovien = tietnghigiaovien::where('matruong',$matruong)->get();
		$tietghep = tietghep::where('matruong',$matruong)->get();
		$sotietmonhoc = sotietmonhoc::where('matruong',$matruong)->get();
		$phonghoc = phonghoc::where('matruong',$matruong)->get();
		$phongmonlop = phongmonlop::where('matruong',$matruong)->get();
		$phancongchuyenmon = phancongchuyenmon::where('matruong',$matruong)->get();
		$giaovienmonlop = giaovienmonlop::where('matruong',$matruong)->get();
		$giaovienchuyenmon = giaovienchuyenmon::where('matruong',$matruong)->get();
		$lophoc = danhsachlophoc::where('matruong',$matruong)->get();
		$tietcodinh = rangbuoctietcodinh::where('matruong',$matruong)->get();
		$sotiettrongbuoi = sotiettrongbuoi::where('matruong',$matruong)->get();
		$rangbuocdangkybuoitietnghigv=rangbuocdangkybuoitietnghigv::where('matruong',$matruong)->get();
		$truonghoc=truong::where('matruong',$matruong)->first();
		$thututiet=thututiet::where('matruong',$matruong)->get();
		$rangbuoccaptietxepliennhau=rangbuoccaptietxepliennhau::where('matruong',$matruong)->get();
		$rangbuocdangkytietnghilop=rangbuocdangkytietnghilop::where('matruong',$matruong)->get();
		$rangbuoctiettranh=rangbuoctiettranh::where('matruong',$matruong)->get();

		$rangbuocsotiet5sangtiet1chieu=rangbuocsotiet5sangtiet1chieu::where('matruong',$matruong)->get();
		$rangbuoctietgvbuocphaico=rangbuoctietgvbuocphaico::where('matruong',$matruong)->get();
		$rangbuoctiethopcuato=rangbuoctiethopcuato::where('giaovien_chuyenmon.matruong',$matruong)
		->join('giaovien_chuyenmon','giaovien_chuyenmon.matochuyenmon','rangbuoctiethopcuato.matochuyenmon')
		->get();
		$rangbuoctranh2moncungbuoi=rangbuoctranh2moncungbuoi::where('matruong',$matruong)->get();
		$diemtruong=diemtruong::where('matruong',$matruong)->get();
		$caphoc=$truonghoc['caphoc'];
		if($caphoc==null)$caphoc=1;
		$tainguyen = new XepTKB($giaovien, $monhoc, $lophoc, $danhsachrangbuoc, $tiethoc, $tietnghigiaovien, $tietghep, $sotietmonhoc, $phonghoc, $phongmonlop, $phancongchuyenmon, $giaovienmonlop, $giaovienchuyenmon,$tietcodinh,$sotiettrongbuoi,$rangbuocdangkybuoitietnghigv,$caphoc,$thututiet,$rangbuoccaptietxepliennhau,$rangbuocdangkytietnghilop,$rangbuoctiettranh,$rangbuocsotiet5sangtiet1chieu,$rangbuoctietgvbuocphaico,$rangbuoctiethopcuato,$rangbuoctranh2moncungbuoi,$diemtruong);

		return response()->json($tainguyen->jsonSerialize());
	}	
		public function capnhatthoikhoabieu(Request $rq){
		$matruong = Session::get('matruong');	
		$tkbdell = thoikhoabieu::where('matruong',$matruong)->delete();	
		$request = $rq->request;
		foreach ($request as $data) {	
			foreach ($data as $key) {
				$datas = (object)$key;
				$magiaovien = $datas->magiaovien;
				$thu = $datas->thu;
				$mamon = $datas->mamon;
				$malop = $datas->malop;
				$buoi = $datas->buoi;
				$tiet = $datas->tiet;

				$thoikhoabieu = new thoikhoabieu();			
				$thoikhoabieu->magiaovien = $magiaovien;
				$thoikhoabieu->thu = $thu;
				$thoikhoabieu->mamonhoc = $mamon;
				$thoikhoabieu->malop = $malop;
				$thoikhoabieu->buoi = $buoi;
				$thoikhoabieu->tiet = $tiet;
				$thoikhoabieu->matruong = $matruong;
				$success = $thoikhoabieu->save();
			}
		}
	}
}
