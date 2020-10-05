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


class tinhchinhController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('tinhchinh.index');
	}
	public function getdanhgiagv(){
		$matruong = Session::get('matruong');
		$data =  tochuyenmon::where('matruong',$matruong)->get();
		$tengv = danhsachgv::where('matruong',$matruong)->get();
		$danhgiagv = danhgiagv::where('matruong',$matruong)->get();
		$giaovien_chuyenmon = giaovien_chuyenmon::where('giaovien_chuyenmon.matruong',$matruong)->join('danhgiagv','danhgiagv.magiaovien','giaovien_chuyenmon.magiaovien')->get();
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
		$data = danhgiagv::find($rq->id);
		$data->magiaovien = $rq->magiaovien;
		$data->tochuyenmon = $rq->tochuyenmon;
		$data->hinhthuc = $rq->hinhthuc;
		$data->xeploai = $rq->xeploai;
		$data->created_at = $thoidiemdanhgia;
		$data->matruong = $matruong;
		$success = $data->save();
		return json_encode($success, JSON_UNESCAPED_UNICODE);
	}
	public function delldanhgiagv(Request $rq){
		$matruong = Session::get('matruong');
		$data = danhgiagv::destroy($rq->id);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
}
