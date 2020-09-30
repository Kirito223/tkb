<?php

namespace App\Http\Controllers\exportkb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session; 
use App\thoikhoabieuexcel;
use App\danhsachgv;
use App\monhoc;
use App\danhsachlophoc;

class exportkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('exportkb.index');
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




}
