<?php

namespace App\Http\Controllers\khaibao;

use App\danhsachgv;
use App\danhsachlophoc;
use App\Http\Controllers\Controller;
use App\monhoc;
use App\Objects\HTTPCode;
use App\Objects\PhancongGiaovien;
use App\phancongchuyenmon;
use App\sotietmonhoc;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class PhanconggiaovienDayController extends Controller
{
    public function index()
    {
        return view('phanconggiaovien\index');
    }

    public function all()
    {
        $danhsachphancong = phancongchuyenmon::all();
        $danhsachGiaovien = danhsachgv::all();
        $danhsachmonhoc = monhoc::all();
        $danhsachlop = danhsachlophoc::all();
        $sotiet = sotietmonhoc::all();

        $Result = new PhancongGiaovien($danhsachphancong, $danhsachGiaovien, $danhsachmonhoc, $danhsachlop, $sotiet);

        return response()->json($Result->jsonSeriable());
    }

    public function store(Request $request)
    {
        try {
            $danhsach = json_decode($request->data);
            $giaovien = $request->giaovien;
            $xoaPhancong = json_decode($request->xoaPhancong);

            //Xoa phan cong cac giao vien khac

            foreach ($xoaPhancong as $value) {
                $timphancong = phancongchuyenmon::where('magiaovien', $value->magiaovien)
                    ->where('malop', $value->malop)
                    ->where('mamonhoc', $value->mamonhoc)
                    ->first();
                phancongchuyenmon::destroy($timphancong->id);
            }

            // Tim danh sach phan cong giao vien lien quan
            $danhsachcu = phancongchuyenmon::where('magiaovien', $giaovien)->select('id')->get();
            phancongchuyenmon::destroy($danhsachcu->toArray());

            // Them data moi

            // Loc danh sach lay phan cong cua giao vien dang duoc chon 

            foreach ($danhsach as $key => $value) {
                if ($value->magiaovien != $giaovien) {
                    unset($danhsach[$key]);
                }
            }

            foreach ($danhsach as $key => $value) {
                $phancong = new phancongchuyenmon();
                $phancong->magiaovien = $value->magiaovien;
                $phancong->mamonhoc = $value->mamonhoc;
                $phancong->malop = $value->malop;
                $phancong->sotiet = $value->sotiet;
                $phancong->save();
            }
            return response()->json(["code" => HTTPCode::$CODE_SUCCESS, "message" => "Phân công giáo viên thành công"]);
        } catch (Exception $ex) {
            return response()->json(["code" => HTTPCode::$CODE_BADREQUEST, "message" => "Đã có lỗi xảy ra vui lòng kiểm tra lại"]);
        }
    }


    /**
     * Ham xoa toan bo cac phan mon cua giao vien
     */

    public function xoaToanBoPhanmonGiaovien($idGiaovien)
    {
        try {

            $danhsachcu = phancongchuyenmon::where('magiaovien', $idGiaovien)->select('id')->get();
            phancongchuyenmon::destroy($danhsachcu->toArray());
            return response()->json(["code" => HTTPCode::$CODE_SUCCESS, "message" => "Phân công giáo viên thành công"]);
        } catch (Exception $ex) {
            return response()->json(["code" => HTTPCode::$CODE_BADREQUEST, "message" => "Đã có lỗi xảy ra vui lòng kiểm tra lại"]);
        }
    }

    public function laydanhsachMonPhancong($monhoc)
    {
        $danhsachPhancong = phancongchuyenmon::where('phancongchuyenmon.mamonhoc', $monhoc)
            ->join('sotietmonhoc', 'sotietmonhoc.mamonhoc', 'phancongchuyenmon.mamonhoc')
            ->join('danhsachlophoc', 'danhsachlophoc.id', 'phancongchuyenmon.malop')
            ->join('danhsachgv', 'danhsachgv.id', 'phancongchuyenmon.magiaovien')
            ->select('danhsachlophoc.tenlop', 'sotietmonhoc.sotiet', 'danhsachgv.ten', 'phancongchuyenmon.sotiet as daphan')
            ->get();
        return response()->json($danhsachPhancong);
    }

    public function xoaPhancongchuyenmonTaimon(Request $request)
    {
        $mon = $request->mon;
        $giaovien = $request->giaovien;
        try {

            $danhsachPhancong = phancongchuyenmon::where('phancongchuyenmon.mamonhoc', $mon)
                ->where('phancongchuyenmon.magiaovien', $giaovien)
                ->select('id')
                ->get()->toArray();
            phancongchuyenmon::destroy($danhsachPhancong);
            return response()->json(["code" => HTTPCode::$CODE_SUCCESS, "message" => "Đã xóa tất cả phân môn thành công"]);
        } catch (Exception $exception) {
            return response()->json(["code" => HTTPCode::$CODE_BADREQUEST, "message" => "Đã có lỗi xảy ra vui lòng kiểm tra lại"]);
        }
    }

    public function xuatBangphancong()
    {
        if (!is_dir(storage_path('excel'))) {
            mkdir(storage_path('excel'));
        }
        $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/excel') . '/bangphancong.xlsx');
        $sheet->setActiveSheetIndex(0);
        $activeSheet = $sheet->getActiveSheet();

        $danhsachgv =  danhsachgv::all();
        $danhsachmonhoc = monhoc::all();
        $danhsachTonghop = array();
        foreach ($danhsachgv as $giaovien) {
            // lay danh sach phan mon cua giao vien
            $item = new stdClass();
            $item->hovaten = $giaovien->holot . $giaovien->ten;
            $arrDanhsachPhancong = array();
            $tongsotiet = 0;
            foreach ($danhsachmonhoc as $value) {
                $mon = "";
                $danhsachphanmon = phancongchuyenmon::where('magiaovien', $giaovien->id)
                    ->where('mamonhoc', $value->id)
                    ->get();
                $mon = $value->tenmonhoc;
                if (count($danhsachphanmon) > 0) {
                    $danhsachlop = "";
                    foreach ($danhsachphanmon as $pm) {
                        $lop = danhsachlophoc::find($pm->malop);
                        $danhsachlop .= $lop->tenlop . ":" . $pm->sotiet . ",";
                        $tongsotiet += $pm->sotiet;
                    }
                    array_push($arrDanhsachPhancong, $mon . " (" . rtrim($danhsachlop, ',') . ")");
                }
            }
            $item->tongsotiet = $tongsotiet;
            $item->phancong =  $arrDanhsachPhancong;
            array_push($danhsachTonghop, $item);
        }
        // Xuat danh sach da tong hop ra file excel
        $row = 6;
        $stt = 1;
        foreach ($danhsachTonghop as $th) {
            $activeSheet->insertNewRowBefore($row + 1, 1);
            // hien thi danh sach phan cong
            $ds = $th->phancong;
            $pc = "";
            foreach ($ds as $item) {
                $pc .= $item . PHP_EOL;
            }
            $activeSheet->setCellValue("A" . $row, $stt)
                ->setCellValue('B' . $row, $th->hovaten)
                ->setCellValue("C" . $row, $th->tongsotiet)
                ->setCellValue("D" . $row, $pc);
            $row++;
            $stt++;
        }
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                    'borderSize' => 1,
                ],
                'inside' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], 'borderSize' => 1,
                ),
            ],
        ];

        $activeSheet->getStyle('A6:' . "E" . $row)->applyFromArray($styleArray);
        if (!is_dir(public_path('download'))) {
            mkdir(public_path('download'));
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
        $writer->save(public_path('download/bangphancong.xlsx'));
        return response()->json("bangphancong.xlsx");
    }
}
