<?php

namespace App\Http\Controllers\tinhchinh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tochuyenmon;
use DB;
use Session; 
use stdClass;
use App\danhsachgv;
use App\monhoc;
use App\giaovien_chuyenmon;
use App\danhgiagv;
use App\thongbao;


class tinhchinhController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		
				$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('tinhchinh.index',compact('thongbao', 'thongbaocount'));
	}
	public function getdanhgiagvtruong(){
		$matruong = Session::get('matruong');
		$data =  tochuyenmon::where('matruong',$matruong)->get();
		$tengv = danhsachgv::where('matruong',$matruong)->get();
		$danhgiagv = danhgiagv::where('danhgiagv.matruong',$matruong)->get();
		$giaovien_chuyenmon = giaovien_chuyenmon::with('danhgiagv')->where('giaovien_chuyenmon.matruong',$matruong)->get();
		return json_encode([$data,$tengv,$giaovien_chuyenmon,$danhgiagv], JSON_UNESCAPED_UNICODE);
	}
	public function adddanhgiagv(Request $rq){
		$matruong = Session::get('matruong');
		$thoidiemdanhgia = date('Y-m-d', strtotime($rq->created_at));
		$data =  new danhgiagv();
		$data->magiaovien = $rq->magiaovien;
		$data->tochuyenmon = $rq->tochuyenmon;
		$data->hinhthuc = $rq->hinhthuc;
		$data->xeploai = $rq->xeploai;
		$data->created_at = $thoidiemdanhgia;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function updatedanhgiagv(Request $rq){
		$matruong = Session::get('matruong');
		$thoidiemdanhgia = date('Y-m-d', strtotime($rq->created_at));
		if($rq->id == null){
			$data =  new danhgiagv();
			$data->magiaovien = $rq->magiaovien;
			$data->tochuyenmon = $rq->tochuyenmon;
			$data->hinhthuc = $rq->hinhthuc;
			$data->xeploai = $rq->xeploai;
			$data->created_at = $thoidiemdanhgia;
			$data->matruong = $matruong;
			$success = $data->save();
		}else{
			$data = danhgiagv::find($rq->id);
			$data->magiaovien = $rq->magiaovien;
			$data->tochuyenmon = $rq->tochuyenmon;
			$data->hinhthuc = $rq->hinhthuc;
			$data->xeploai = $rq->xeploai;
			$data->created_at = $thoidiemdanhgia;
			$data->matruong = $matruong;
			$success = $data->save();	
		}
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function delldanhgiagv(Request $rq){
		$matruong = Session::get('matruong');
		$data = danhgiagv::destroy($rq->id);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
}
