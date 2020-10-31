<?php

namespace App\Http\Controllers\thongbao;

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

class thongbaoController extends Controller
{
	
	//thông báo
	public function thongbaotruong()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev','js-datatable','js-datepicker','js-moment'])->addStyles(['style-macdinh','style-dev','style-datatable','style-datepicker']);
		$matruong = Session::get('matruong');
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('thongbao.thongbao',compact('thongbao', 'thongbaocount'));
	}

	//lấy danh sách thông báo
	public function getdsthongbaotruong(){
		$matruong = Session::get('matruong');
		$thongbao = DB::table('thongbao')
		->join('tbl_admin','tbl_admin.id','=','thongbao.tbl_admin_id')
		->select('thongbao.id','thongbao.truong_id','thongbao.tbl_admin_id','thongbao.sohieu','thongbao.tieude','thongbao.loai','thongbao.ngaytao','thongbao.ngaygui','thongbao.file','thongbao.noidung','thongbao.gui','thongbao.trangthai','tbl_admin.tentaikhoan')
		->where('thongbao.gui',1)
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
			$idtruongtb = null;
			for($i=0;$i<count($datatruong);$i++){
				if($datatruong[$i] == $matruong){
					$idtruongtb = $datatruong[$i];
				}
			}
			$dstb->idtruong = $idtruongtb;
			array_push($data, $dstb);
		}

		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//cập nhật trạng thái xem thông báo pgd
	public function updatetrangthaixemthongbaotruong(Request $rq){
		$thongbao = thongbao::find($rq->idthongbao);
		$thongbao->trangthai = 1;
		$thongbao->update();
		$success = 1;
		return json_encode($success);
	}

}
