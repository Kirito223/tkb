<?php

namespace App\Http\Controllers\export;

use App\danhsachgv;
use App\danhsachlophoc;
use App\Http\Controllers\Controller;
use App\Objects\Day;
use App\Objects\SessionInfo;
use App\Objects\TableTime;
use App\Objects\TableTimeTypeTwo;
use App\thoikhoabieu;
use App\tietnghigiaovien;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use stdClass;

class exportExcelController extends Controller
{

    private $sessionInfo;
    public function __construct()
    {
        $this->sessionInfo = new SessionInfo();
    }
    public function listTeacher()
    {
        $matruong = $this->sessionInfo->getSchoolId();
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

        // $sheet->setActiveSheetIndex(0);

        // $sheetTKBSchool = $sheet->getActiveSheet();

        // // export data to school timetable

        // $this->exportTKBSchool($sheetTKBSchool, $param->date, $param->tkbNo);

        // $sheet->setActiveSheetIndex(1);
        // $sheetTKBTeacherTypeOne = $sheet->getActiveSheet();
        // $this->exportTKBTecherTypeOne($sheetTKBTeacherTypeOne, $param->date, $param->tkbNo);


        $sheet->setActiveSheetIndex(2);
        $sheetTKBTeacherTypeTwo = $sheet->getActiveSheet();
        $this->exportTKBTecherTypeTwo($sheetTKBTeacherTypeTwo, $param->date, $param->tkbNo);


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
        $matruong = $this->sessionInfo->getSchoolId();
        $listClassRoom = danhsachlophoc::where('matruong', $matruong)->get();
        // Render Class at header
        foreach ($listClassRoom as $class) {
            // Merge cell
            $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle + 1, $rowTitle);
            $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, $class->tenlop);

            $columnTitle = $columnTitle + 2;
        }
        $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, "Giáo viên nghỉ");
        $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);

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
         * 1-5: morning
         * 6-10: afternoon
         */

        $tableTime = array();
        for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
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
        $totalRow = 70;
        $indexTable = 0;
        $lastColumn = 0;
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
                $lastColumn = $indexcolum;
                if ($indexTable < count($tableTime) - 1) {
                    $indexTable++;
                }
            }
        }

        //get list teacher rest
        $arrteacherRest = array();
        for ($day = 1; $day < 7; $day++) {
            $teacherRest = tietnghigiaovien::where('thu', $day)
                ->join('danhsachgv', 'danhsachgv.id', 'tietnghigiaovien.magiaovien')
                ->select('danhsachgv.hovaten')
                ->get();
            $teacher = "";
            if ($teacherRest != null) {
                foreach ($teacherRest as $item) {
                    $teacher .= $item->hovaten . ",";
                }
            }
            array_push($arrteacherRest, $teacher);
        }

        // Render
        $rowTeacher = 7;
        foreach ($arrteacherRest as $restItem) {
            // Merge row
            $sheetTKBSchool->mergeCellsByColumnAndRow($lastColumn, $rowTeacher, $lastColumn, $rowTeacher + 9);
            $sheetTKBSchool->setCellValueByColumnAndRow($lastColumn, $rowTeacher, $restItem);
            $rowTeacher = $rowTeacher + 10;
        }
        $lastCellAddress = $sheetTKBSchool->getCellByColumnAndRow($lastColumn, $totalRow - 4)->getCoordinate();

        $this->sign($sheetTKBSchool, $lastColumn, $totalRow);

        $this->headerRow($sheetTKBSchool, $lastColumn, $lastCellAddress, $no, $date);
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

        $sheetTKBSchool->getStyle('A5:' . $lastCellAddress)->applyFromArray($styleArray);

        $sheetTKBSchool->mergeCells("A1:G1");
        $sheetTKBSchool->setCellValue("A1", $this->sessionInfo->getSchoolName());

        $sheetTKBSchool->getStyle("A1")->getFont()->setBold(true);
    }

    private function exportTKBClass($sheetTKBSchool, $date, $no)
    {
    }

    private function setBorder($sheet, $cellFrist,  $lastCellAddress)
    {
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

        $sheet->getStyle($cellFrist . $lastCellAddress)->applyFromArray($styleArray);
    }

    private function headerRow($sheet, $lastColumn, $lastCellAddress, $no, $date)
    {

        $sheet->mergeCellsByColumnAndRow(1, 2, $lastColumn, 2);
        $sheet->setCellValueByColumnAndRow(1, 2, "THỜI KHÓA BIỂU SỐ " . $no);
        $sheet->mergeCellsByColumnAndRow(1, 3, $lastColumn, 3);
        $sheet->setCellValueByColumnAndRow(1, 3, "Ngày thực hiện " . $date);

        $sheet->getStyle("A2:" . $lastCellAddress)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A2:" . $lastCellAddress)->getFont()->setBold(true);


        $sheet->getStyle("A3:" . $lastCellAddress)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A3:" . $lastCellAddress)->getFont()->setBold(true);
    }

    private function sign($sheet, $lastColumn, $totalRow)
    {
        $sheet->mergeCellsByColumnAndRow($lastColumn - 3, $totalRow, $lastColumn,  $totalRow);
        $sheet->setCellValueByColumnAndRow($lastColumn - 3,  $totalRow, "KT. HIỆU TRƯỞNG");

        $cellPrincipal = $sheet->getCellByColumnAndRow($lastColumn - 3, $totalRow)->getCoordinate();
        $sheet->getStyle($cellPrincipal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($cellPrincipal)->getFont()->setBold(true);

        $totalRow++;
        $sheet->mergeCellsByColumnAndRow($lastColumn - 3, $totalRow, $lastColumn,  $totalRow);
        $sheet->setCellValueByColumnAndRow($lastColumn - 3,  $totalRow, "PHÓ HIỆU TRƯỞNG");

        $cellPrincipal = $sheet->getCellByColumnAndRow($lastColumn - 3, $totalRow)->getCoordinate();
        $sheet->getStyle($cellPrincipal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($cellPrincipal)->getFont()->setBold(true);
    }

    private function exportTKBTecherTypeOne($sheetTKBTeacher, $date, $no)
    {
        $listTeacher = danhsachgv::where('matruong', $this->sessionInfo->getSchoolId())->get();
        $rowHead = 4;
        $indexColum = 3;
        $lastColumn = 0;
        // Render Header with list teacher
        foreach ($listTeacher as $teacher) {
            $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $rowHead, $teacher->hovaten);
            $indexColum++;
        }

        // Get data
        $tableTime = array();

        for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                foreach ($listTeacher as $objTeacher) {
                    // get table time of morning
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('tiet', $session)
                        ->where('magiaovien', $objTeacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                        ->first();

                    if ($table != null) {
                        $item = new TableTime($day, $session, $table->tenmonhoc, $table->tenlop);
                        array_push($tableTime, $item);
                    } else {
                        array_push($tableTime, null);
                    }
                }
            }
        }

        // Render Tabletime
        $indexColum = 3;
        $totalRow = 64;
        $indexTable = 0;
        $titleLenght = count($listTeacher);

        for ($indexRowbody = 5; $indexRowbody < $totalRow; $indexRowbody++) {
            $indexColum = 3;
            while ($indexColum < $titleLenght) {
                if ($indexColum == 35) {
                    $p = 1;
                }
                $tableItem = $tableTime[$indexTable];
                if ($tableItem != null) {
                    $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $indexRowbody, $tableItem->getSubject() . "-" . $tableItem->getName());
                    $indexColum++;
                } else {
                    $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $indexRowbody, "");
                    $indexColum++;
                }
                $lastColumn = $indexColum;
                if ($indexTable < count($tableTime)) {
                    $indexTable++;
                }
            }
        }
        $lastCellAddress = $sheetTKBTeacher->getCellByColumnAndRow($titleLenght, $totalRow)->getCoordinate();
        $this->headerRow($sheetTKBTeacher, $lastColumn, $lastCellAddress, $no, $date);
        $this->sign($sheetTKBTeacher, $lastColumn, $totalRow + 2);
        $this->setBorder($sheetTKBTeacher, "A4:", $lastCellAddress);
    }

    private function exportTKBTecherTypeTwo($sheetTKBTeacherTypeTwo, $date, $no)
    {
        $listTeacher = danhsachgv::where('matruong', $this->sessionInfo->getSchoolId())->get();
        // Get data
        $tableTime = array();
        foreach ($listTeacher as $teacher) {
            $arrMorning = array();
            $arrAfternoon = array();
            for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
                // Get tabletime morning

                for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$AFTERNOON; $sessionMorning++) {
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('tiet', $sessionMorning)
                        ->where('magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                        ->first();
                    array_push($arrMorning, $table);
                }

                // Get tabletime afternoon

                for ($sessionAfterNoon = Day::$MORNING; $sessionAfterNoon < Day::$MIDDAY; $sessionAfterNoon++) {
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('tiet', $sessionAfterNoon)
                        ->where('magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                        ->first();
                    array_push($arrAfternoon, $table);
                }
            }
            $itemTeacher = new TableTimeTypeTwo($teacher->hovaten, $arrMorning, $arrAfternoon);
            array_push($tableTime, $itemTeacher);
        }
        // Export table
        $rowName = 7;
        $columnName = 2;
        $columnTableTime = 4;
        $rowTime = 7;
        foreach ($tableTime as $item) {
            // set Name to cell Name
            $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnName, $rowName, $item->getTeacher());
            // Render TableTime Morning
            $tableMorning = $item->getTableTimeMorning();
            $indexTable = 0;

            while ($columnTableTime < 31) {

                $itemTable = $tableMorning[$indexTable];
                if ($itemTable != null) {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime, $itemTable->tenmonhoc . "-" . $itemTable->tenlop);
                } else {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime, "");
                }
                if ($indexTable < count($tableMorning)) {
                    $indexTable++;
                }
                $columnTableTime++;
            }
            // Render TableTime AfterNoon
            $indexTable = 0;
            $columnTableTime = 4;
            $tableAfterNoon = $item->getTableTimeAfterNoon();
            while ($columnTableTime < 31) {
                $itemTable = $tableAfterNoon[$indexTable];
                if ($itemTable != null) {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime + 1, $itemTable->tenmonhoc . "-" . $itemTable->tenlop);
                } else {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime + 1, "");
                }
                if ($indexTable < count($tableAfterNoon)) {
                    $indexTable++;
                }
                $columnTableTime++;
            }
            $rowName++;
            $rowTime++;
        }
        $sheetTKBTeacherTypeTwo->setCellValue("A3", "Thời gian thực hiện " . $date);
    }

    private function exportTKBTecherTypeThree($sheetTKBSchool, $date, $no)
    {
    }

    private function exportTKBRoomDepartment($sheetTKBSchool, $date, $no)
    {
    }
    private function exportTKBGroup($sheetTKBSchool, $date, $no)
    {
    }
}
