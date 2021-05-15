<?php

namespace App\Http\Controllers;

use App\Lichsudaythay;
use App\thoikhoabieu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GiaoVienDayThayController extends Controller
{
    public function index()
    {
        return view('daythay\index');
    }

    public function getTKB(Request $request)
    {

        $date = new Carbon('01/' . $request->thang);
        $end = $date->lastOfMonth()->toDateString();
        $start = $date->firstOfMonth()->toDateString();

        $danhsach = thoikhoabieu::where('tuan', $request->tuan)
            ->where('malop', $request->lop)
            ->where('buoi', $request->buoi)
            ->where('tiet', $request->tiet)
            ->whereBetween('created_at', [$start, $end])
            ->with('giaovien')
            ->with('lophoc')
            ->with('monhoc')
            ->get();
        return $danhsach;
    }

    public function phanCongDayThay(Request $request)
    {
        try {
            $danhsach = json_decode($request->danhsach);

            foreach ($danhsach as $value) {
                $date = new Carbon($value->thang);
                $end = $date->lastOfMonth()->toDateString();
                $start = $date->firstOfMonth()->toDateString();
                $tkb = thoikhoabieu::find($value->tkb);
                if ($tkb != null) {
                    $giaovienPhanCong = thoikhoabieu::where('malop', $value->lop)
                        ->where('magiaovien', $value->giaovienthaythe)
                        ->where('tuan', $value->tuan)
                        ->where('buoi', $value->buoi)
                        ->where('tiet', $value->tiet)
                        ->where('thu', $value->thu)
                        ->whereBetween('created_at', [$start, $end])
                        ->first();
                    if ($giaovienPhanCong != null) {
                        thoikhoabieu::destroy($giaovienPhanCong->id);
                    }
                    $tkb->magiaovien = $value->giaovienthaythe;
                    if ($tkb->saveOrFail()) {

                        $lichsu = new Lichsudaythay();
                        $lichsu->magv = $value->giaovienhientai;
                        $lichsu->magvdoi = $value->giaovienthaythe;
                        $lichsu->tuan = $value->tuan;
                        $lichsu->thang = $value->thang;
                        $lichsu->malop = $value->lop;
                        $lichsu->buoi = $value->buoi;
                        $lichsu->thu = $value->thu;
                        $lichsu->tiet = $value->tiet;
                        $lichsu->mamon = $value->mon;
                        $lichsu->saveOrFail();
                    }
                }
            }
            return "OK";
        } catch (\Exception $th) {
            print($th);
        }
    }
}
