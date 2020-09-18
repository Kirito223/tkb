<?php

namespace App\Http\Controllers\export;

use App\danhsachgv;
use App\danhsachlophoc;
use App\Http\Controllers\Controller;
use App\Objects\TableTime;
use App\thoikhoabieu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use stdClass;

class exportExcelController extends Controller
{
    public function listTeacher()
    {
        $matruong = Session::get('matruong');
        $list =  danhsachgv::where('matruong', '=', $matruong)->get();
        return response()->json($list);
    }

    public function export(Request $request)
    {
        $param = json_decode($request->param);
        if (!is_dir(storage_path('excel'))) {
            mkdir(storage_path('excel'));
        }
        $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/excel') . '/mautkb.xlsx');

        // TKB School

        $sheet->setActiveSheetIndex(0);
        $sheetTKBSchool = $sheet->getActiveSheet();
        // export data to school timetabl
        $this->exportTKBSchool($sheetTKBSchool, $param->date, $param->tkbNo);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
        if (!file_exists(public_path('export'))) {
            mkdir(public_path('export'));
        }
        $writer->save(public_path('export') . "/thoikhoabieu{$param->tkbNo}.xlsx");
        return "done";
    }

    private function exportTKBSchool($sheetTKBSchool, $date, $no)
    {
        $rowTitle = 5;
        $columnTitle = 3;
        $matruong = Session::get('matruong');
        $listClassRoom = danhsachlophoc::where('matruong', $matruong)->get();
        // Render Class at header
        foreach ($listClassRoom as $class) {
            // Merge cell
            $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle + 1, $rowTitle);
            $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, $class->tenlop);

            $columnTitle = $columnTitle + 2;
        }

        $titleLenght = count($listClassRoom) * 2 + 2;
        $indexcolum = 3;
        while ($indexcolum < $titleLenght) {
            $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, 6, "Môn");
            $indexcolum++;
            $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, 6, "Giáo viên");
            $indexcolum++;
        }

        // Data synthesis for tabletime
        // day of week
        /***
         * 1 - monday
         * 2 - tuesday
         * 3 - Wednesday
         * 4 - Thursday
         * 5 - Friday
         * 6 - Saturday
         * 
         * session of the day
         * 1: morning
         * 2: afternoon
         */

        $tableTime = array();
        for ($day = 1; $day < 7; $day++) {
            for ($session = 1; $session < 11; $session++) {
                foreach ($listClassRoom as $class) {
                    // get table time of morning
                    $table = thoikhoabieu::where('malop', $class->id)
                        ->where('thu', $day)
                        ->where('tiet', $session)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')

                        ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'thoikhoabieu.malop')
                        ->first();
                    if ($table != null) {
                        $item = new TableTime($day, $session, $table->tenmonhoc, $table->hovaten);
                        array_push($tableTime, $item);
                    } else {
                        array_push($tableTime, null);
                    }
                }
            }
        }

        // Render content tabletime
        $totalRow = 120;
        $indexTable = 0;
        for ($indexRowbody = 7; $indexRowbody < $totalRow; $indexRowbody++) {
            // Loop follow class and insert data to cell in excel

            $indexcolum = 3;
            while ($indexcolum < $titleLenght) {
                // if indexTable == titleLenght/2 then new row and indexcolum == 24 indexRowbody + 1

                $tableItem = $tableTime[$indexTable];
                if ($tableItem != null) {
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, $tableItem->getSubject());
                    $indexcolum++;
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, $tableItem->getName());
                    $indexcolum++;
                } else {
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, "");
                    $indexcolum++;
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, "");
                    $indexcolum++;
                }
                if ($indexTable == 719) {
                    $p = "change";
                }
                if ($indexTable < count($tableTime) - 1) {
                    $indexTable++;
                }
            }
        }
    }

    private function exportTKBClass()
    {
    }

    private function exportTKBTecher()
    {
    }
    private function exportTKBRoomDepartment()
    {
    }
    private function exportTKBGroup()
    {
    }
}
