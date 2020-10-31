<?php

namespace App\Http\Controllers\xemtkb;

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
use Session; 

class xemtkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable'])->addStyles(['style-macdinh','style-dev','style-datatable']);
		
		$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('xemtkb.index',compact('thongbao', 'thongbaocount'));
	}

	//lấy danh sách khối,gv,lớp
	public function getdskhoigvlop(){
		$matruong = Session::get('matruong');
		$data = [];
		$dstruong = new stdClass();
		$lop = danhsachlophoc::where('matruong', '=',  $matruong)->select('id','tenlop','khoi')->orderBy('tenlop','ASC')->get();
        $gv = danhsachgv::where('matruong','=', $matruong)->select('id','hovaten','bidanh','dienthoai','email')->get();
        $khoi = khoihoc::where('matruong','=', $matruong)->select('id','tenkhoi')->orderBy('tenkhoi','ASC')->get();
		$dstruong->danhsachlop = $lop;
		$dstruong->danhsachgv = $gv;
		$dstruong->danhsachkhoihoc = $khoi;
		array_push($data, $dstruong);
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//get thời khoá biểu trường
	public function gettkbtruong(){
		$matruong = Session::get('matruong');
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong')
	 	->where('thoikhoabieu.matruong',$matruong)
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
	public function getdslt(){
		$matruong = Session::get('matruong');
		$danhsachlophoc = danhsachlophoc::orderBy('tenlop', 'ASC')->where('matruong',$matruong)->get();
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
	public function gettkbgv(){
		$matruong = Session::get('matruong');
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong')
	 	->where('thoikhoabieu.matruong',$matruong)
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
	public function gettkblop(){
		$matruong = Session::get('matruong');
	 	$thoikhoabieu = DB::table('thoikhoabieu')
	 	->leftjoin('danhsachgv','danhsachgv.id','thoikhoabieu.magiaovien')
	 	->leftjoin('danhsachlophoc','danhsachlophoc.id','thoikhoabieu.malop')
	 	->leftjoin('monhoc','monhoc.id','thoikhoabieu.mamonhoc')
	 	->select('danhsachgv.bidanh','danhsachlophoc.tenlop','monhoc.tenmonhoc','thoikhoabieu.magiaovien','thoikhoabieu.malop','thoikhoabieu.mamonhoc','thoikhoabieu.buoi','thoikhoabieu.thu','thoikhoabieu.tiet','thoikhoabieu.maphong','thoikhoabieu.matruong')
	 	->where('thoikhoabieu.matruong',$matruong)
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

}
