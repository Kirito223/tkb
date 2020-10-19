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
use App\tochuyenmon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\FuncCall;
use stdClass;
use ZipArchive;

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
        $list =  danhsachgv::where('matruong', '=', $matruong)
            ->select('danhsachgv.id', 'danhsachgv.hovaten as name')
            ->get();
        return response()->json($list);
    }

    public function listClass()
    {
        $list = danhsachlophoc::where('matruong', '=', $this->sessionInfo->getSchoolId())
            ->select('id', 'tenlop as name')
            ->orderBy('tenlop', 'ASC')
            ->get();
        return response()->json($list);
    }

    private function loadSheetExcel($excelFile)
    {
        if (!is_dir(storage_path('excel'))) {
            mkdir(storage_path('excel'));
        }
        $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/excel') . '/' . $excelFile);
        return $sheet;
    }

    private function saveExcel($sheet, $fileName)
    {
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sheet);
        if (!file_exists(public_path('export'))) {
            mkdir(public_path('export'));
        }
        $writer->save(public_path('export') . "/" . $fileName . ".xlsx");
    }

    public function export(Request $request)
    {
        $param = json_decode($request->param);
        $fileExport = array();
        if ($param->tkbtruong == 1) {
            // TKB trường
            $sheet = $this->loadSheetExcel('mautkbtruong.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetTKBSchool = $sheet->getActiveSheet();
            $this->exportTKBSchoolTwoColumn($sheetTKBSchool, $sheet);
            array_push($fileExport, "thoikhoabieutruong");
        }
        if ($param->tkblop == 1) {
            $classList = json_decode($param->arrSelect);
            $sheet = $this->loadSheetExcel('mautkbphonghoc.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetTKBTeacherClass = $sheet->getActiveSheet();
            $this->exportTKBClass($sheetTKBTeacherClass, $sheet, $classList);
        }
        if ($param->tkbGV == 1) {
            if ($param->exportAll == true) {
                $teacherList  = json_decode($param->arrSelect);
                $sheet = $this->loadSheetExcel('mautkbgiaovien.xlsx');
                $sheet->setActiveSheetIndex(0);
                $sheetTKBTeacherTypeTwo = $sheet->getActiveSheet();
                $this->exportTKBTecherTypeTwo($sheetTKBTeacherTypeTwo, $sheet, $teacherList);
            } else {
                $teacherList  = json_decode($param->arrSelect);
                $sheet = $this->loadSheetExcel('mautkbphonghoc.xlsx');
                $sheet->setActiveSheetIndex(0);
                $sheetTKBTeacherTypeTwo = $sheet->getActiveSheet();
                $this->exportTKBTeachers($sheetTKBTeacherTypeTwo, $sheet, $teacherList);
            }
        }
        if ($param->tkbphong == 1) {
            //tkb phong
            $sheet = $this->loadSheetExcel('mautkbphonghoc.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetTKBTeacherClass = $sheet->getActiveSheet();
            $this->exportTKBClass($sheetTKBTeacherClass, $sheet);
        }
        if ($param->tkbphancongcm == 1) {
            $sheet = $this->loadSheetExcel('mautkbtochuyenmon.xlsx');
            $this->exportTKBGroup($sheet);
        }
        // $zip = new ZipArchive();

        // $fileZip = public_path('export\\') . 'thoikhoabieu.zip';
        // if ($zip->open($fileZip, ZipArchive::CREATE)) {
        //     foreach ($fileExport as $file) {
        //         $f = public_path('export/') . $file . ".xlsx";
        //         $relativeNameInZipFile = basename($f);
        //         $zip->addFile($f, $relativeNameInZipFile);
        //     }
        //     $zip->close();
        // }


        return response()->json(Response::HTTP_OK);
    }
    private function autoSiezColumn($sheet)
    {
        // Auto-size columns for all worksheets
        foreach ($sheet->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getColumnIterator() as $column) {
                $worksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        }
    }

    public function downLoadTableTime($file)
    {
        return response()->download(public_path('export/') . $file);
    }

    private function exportTKBSchoolOneColumn($sheetTKBSchool)
    {
        $rowTitle = 5;
        $columnTitle = 3;
        $matruong = $this->sessionInfo->getSchoolId();
        $listClassRoom = danhsachlophoc::where('matruong', $matruong)->get();

        // Render Class at header
        foreach ($listClassRoom as $class) {
            $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, $class->tenlop);
            $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);
            $columnTitle++;
        }
        $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, "Giáo viên nghỉ");
        $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);

        $titleLenght = count($listClassRoom);
        $indexcolum = 3;


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

                $tableItem = $tableTime[$indexTable];
                if ($tableItem != null) {
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, "{$tableItem->getSubject()}- {$tableItem->getName()}");
                    $indexcolum++;
                } else {
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
            $sheetTKBSchool->mergeCellsByColumnAndRow($lastColumn + 3, $rowTeacher, $lastColumn + 3, $rowTeacher + 9);
            $sheetTKBSchool->setCellValueByColumnAndRow($lastColumn + 3, $rowTeacher, $restItem);
            $rowTeacher = $rowTeacher + 10;
        }
        $lastCellAddress = $sheetTKBSchool->getCellByColumnAndRow($lastColumn + 3, $totalRow - 4)->getCoordinate();

        $this->sign($sheetTKBSchool, $lastColumn, $totalRow);

        $this->headerRow($sheetTKBSchool, $lastColumn, $lastCellAddress);
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


    private function exportTKBSchoolSubject($sheetTKBSchool)
    {
        $rowTitle = 5;
        $columnTitle = 3;
        $matruong = $this->sessionInfo->getSchoolId();
        $listClassRoom = danhsachlophoc::where('matruong', $matruong)->get();

        // Render Class at header
        foreach ($listClassRoom as $class) {
            $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, $class->tenlop);
            $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);
            $columnTitle++;
        }
        $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, "Giáo viên nghỉ");
        $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);

        $titleLenght = count($listClassRoom);
        $indexcolum = 3;


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

                $tableItem = $tableTime[$indexTable];
                if ($tableItem != null) {
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, "{$tableItem->getSubject()}");
                    $indexcolum++;
                } else {
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
            $sheetTKBSchool->mergeCellsByColumnAndRow($lastColumn + 3, $rowTeacher, $lastColumn + 3, $rowTeacher + 9);
            $sheetTKBSchool->setCellValueByColumnAndRow($lastColumn + 3, $rowTeacher, $restItem);
            $rowTeacher = $rowTeacher + 10;
        }
        $lastCellAddress = $sheetTKBSchool->getCellByColumnAndRow($lastColumn + 3, $totalRow - 4)->getCoordinate();

        $this->sign($sheetTKBSchool, $lastColumn, $totalRow);

        $this->headerRow($sheetTKBSchool, $lastColumn, $lastCellAddress);
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

    private function exportTKBSchoolTwoRow($sheetTKBSchool)
    {
        $sheetTKBSchool->removeRow(7, 67);

        $sheetTKBSchool->unmergeCells('A7:A11');
        $sheetTKBSchool->unmergeCells('A12:A16');
        $sheetTKBSchool->unmergeCells('A17:A21');
        $sheetTKBSchool->unmergeCells('A22:A26');
        $sheetTKBSchool->unmergeCells('A27:A31');
        $sheetTKBSchool->unmergeCells('A32:A36');
        $sheetTKBSchool->unmergeCells('A37:A41');
        $sheetTKBSchool->unmergeCells('A42:A46');
        $sheetTKBSchool->unmergeCells('A47:A51');
        $sheetTKBSchool->unmergeCells('A52:A56');
        $sheetTKBSchool->unmergeCells('A57:A61');
        $sheetTKBSchool->unmergeCells('A62:A66');
        $rowDay = 7;
        for ($day = 2; $day < 8; $day++) {
            $sheetTKBSchool->mergeCellsByColumnAndRow(1, $rowDay, 1, $rowDay + 9);
            $sheetTKBSchool->setCellValueByColumnAndRow(1, $rowDay, "Thứ {$day}");
            $rowDay += 10;
            $sheetTKBSchool->mergeCellsByColumnAndRow(1, $rowDay, 1, $rowDay + 9);
            $sheetTKBSchool->setCellValueByColumnAndRow(1, $rowDay, "Thứ {$day}");
            $rowDay += 10;
        }
        $sheetTKBSchool->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $ss = 1;
        for ($rowSession = 7; $rowSession < 126; $rowSession += 2) {
            $sheetTKBSchool->mergeCells("B" . $rowSession . ":B" . ($rowSession + 1));
            $sheetTKBSchool->setCellValue("B" . $rowSession, $ss);
            if ($ss == 5) {
                $ss = 1;
            } else {
                $ss++;
            }
        }
        $rowTitle = 5;
        $columnTitle = 3;
        $matruong = $this->sessionInfo->getSchoolId();
        $listClassRoom = danhsachlophoc::where('matruong', $matruong)->get();

        // Render Class at header
        foreach ($listClassRoom as $class) {
            $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, $class->tenlop);
            $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);
            $columnTitle++;
        }
        $sheetTKBSchool->setCellValueByColumnAndRow($columnTitle, $rowTitle, "Giáo viên nghỉ");
        $sheetTKBSchool->mergeCellsByColumnAndRow($columnTitle, $rowTitle, $columnTitle, $rowTitle + 1);


        $titleLenght = count($listClassRoom);
        $indexcolum = 3;


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
        $totalRow = 126;
        $indexTable = 0;
        $lastColumn = 0;

        for ($indexRowbody = 7; $indexRowbody < $totalRow; $indexRowbody += 2) {
            // Loop follow class and insert data to cell in excel
            $indexcolum = 3;
            while ($indexcolum < $titleLenght) {

                $tableItem = $tableTime[$indexTable];
                if ($tableItem != null) {
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, "{$tableItem->getSubject()}");
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody + 1, "{$tableItem->getName()}");
                } else {
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody, "");
                    $sheetTKBSchool->setCellValueByColumnAndRow($indexcolum, $indexRowbody + 1, "");
                }
                $indexcolum++;
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
            $sheetTKBSchool->mergeCellsByColumnAndRow($lastColumn + 3, $rowTeacher, $lastColumn + 3, $rowTeacher + 19);
            $sheetTKBSchool->setCellValueByColumnAndRow($lastColumn + 3, $rowTeacher, $restItem);
            $rowTeacher = $rowTeacher + 20;
        }

        $lastCellAddress = $sheetTKBSchool->getCellByColumnAndRow($lastColumn + 3, $totalRow)->getCoordinate();
        $sheetTKBSchool->getStyle($lastCellAddress)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->sign($sheetTKBSchool, $lastColumn + 3, $totalRow + 4);
        $this->setBorder($sheetTKBSchool, "A5:", $lastCellAddress);
        $this->headerRow($sheetTKBSchool, $lastColumn + 3, $lastCellAddress);
    }


    private function exportTKBSchoolTwoColumn($sheetTKBSchool, $sheet)
    {
        $rowTitle = 5;
        $columnTitle = 3;
        $matruong = $this->sessionInfo->getSchoolId();
        $listClassRoom = danhsachlophoc::where('matruong', $matruong)->orderBy('tenlop', 'ASC')->get();
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
            $swicth = 0;
            $ss = 1;
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                if ($session == 6) {
                    $swicth = 1;
                    $ss = 1;
                }


                foreach ($listClassRoom as $class) {

                    // get table time of morning
                    $table = thoikhoabieu::where('malop', '=',  $class->id)
                        ->where('thu', $day)
                        ->where('buoi', $swicth)
                        ->where('tiet', $ss)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'thoikhoabieu.malop', 'thoikhoabieu.tiet')
                        ->first();

                    if ($table != null) {
                        $item = new TableTime($day, $session, $table->tenmonhoc, $table->hovaten);
                        array_push($tableTime, $item);
                    } else {
                        array_push($tableTime, null);
                    }
                }
                if ($session == 6) {
                    $f = 0;
                }
                $ss++;
            }
        }

        // Render content tabletime
        $totalRow = 70;
        $indexTable = 0;
        $lastColumn = 0;
        for ($indexRowbody = 7; $indexRowbody < $totalRow; $indexRowbody++) {
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

        $this->headerRow($sheetTKBSchool, $lastColumn, $lastCellAddress);
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
        $this->autoSiezColumn($sheet);
        $this->saveExcel($sheet, "thoikhoabieutruong");
    }

    private function exportTKBClass($sheetTKBClass, $sheet, $listClassRoom)
    {
        $tableTime = array();

        // construction tableTime;
        foreach ($listClassRoom as $room) {
            $arrMorning = array();
            $arrAfternoon = array();

            // Get morning
            $ss = 1;
            for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$MIDDAY; $sessionMorning++) {

                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {

                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 0)
                        ->where('tiet', $ss)
                        ->where('thoikhoabieu.malop', $room->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'danhsachlophoc.tenlop', 'thoikhoabieu.tiet')
                        ->first();
                    array_push($arrMorning, $table);
                }
                $ss++;
            }
            // Get afternoon
            $ss = 1;
            for ($sessionAfterNoon = Day::$MIDDAY; $sessionAfterNoon < Day::$AFTERNOON; $sessionAfterNoon++) {

                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {

                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 1)
                        ->where('tiet', $ss)
                        ->where('thoikhoabieu.malop', $room->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop', 'danhsachgv.hovaten', 'thoikhoabieu.tiet')
                        ->first();
                    array_push($arrAfternoon, $table);
                }
                $ss++;
            }
            $itemTeacher = new TableTimeTypeTwo($room->name, $arrMorning, $arrAfternoon);
            array_push($tableTime, $itemTeacher);
        }
        // Generate TimeTable

        $startRow = 3;
        $row = 3;

        $rowTableBody = 4;
        $rowName = 1;
        // Render Header Table
        foreach ($tableTime as $item) {
            if ($row > 12) {
                $rowName = $row - 4;
            }
            $startRow = $row;
            $sheetTKBClass->mergeCells("A" . $rowName . ":H" . $rowName);
            $sheetTKBClass->setCellValueByColumnAndRow(1, $rowName, "THỜI KHÓA BIỂU LỚP " . $item->getTeacher());

            $sheetTKBClass->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetTKBClass->getStyle("A" . $rowName)->getFont()->setBold(true);

            $rowName++;
            $sheetTKBClass->mergeCells("A" . $rowName . ":H" . $rowName);
            // $sheetTKBClass->setCellValueByColumnAndRow(1, $rowName, "Thực hiện từ ngày: ");

            $sheetTKBClass->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetTKBClass->getStyle("A" . $rowName)->getFont()->setBold(false);

            // Render Header

            $sheetTKBClass->setCellValueByColumnAndRow(1, $row, "Buổi");
            $sheetTKBClass->setCellValueByColumnAndRow(2, $row, "Tiết");
            $sheetTKBClass->setCellValueByColumnAndRow(3, $row, "Thứ 2");
            $sheetTKBClass->setCellValueByColumnAndRow(4, $row, "Thứ 3");
            $sheetTKBClass->setCellValueByColumnAndRow(5, $row, "Thứ 4");
            $sheetTKBClass->setCellValueByColumnAndRow(6, $row, "Thứ 5");
            $sheetTKBClass->setCellValueByColumnAndRow(7, $row, "Thứ 6");
            $sheetTKBClass->setCellValueByColumnAndRow(8, $row, "Thứ 7");

            for ($i = 1; $i < 9; $i++) {
                $cellPart = $sheetTKBClass->getCellByColumnAndRow($i, $row)->getCoordinate();
                $sheetTKBClass->getStyle($cellPart)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheetTKBClass->getStyle($cellPart)->getFont()->setBold(true);
            }



            // Render Body Table
            $row++;
            $sheetTKBClass->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetTKBClass->setCellValueByColumnAndRow(1, $row, "Sáng");

            $cell = $sheetTKBClass->getCellByColumnAndRow(1, $row)->getCoordinate();
            $sheetTKBClass->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheetTKBClass->getStyle($cell)->getFont()->setBold(true);

            $row += 5;
            $sheetTKBClass->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetTKBClass->setCellValueByColumnAndRow(1, $row, "Chiều");

            $cell = $sheetTKBClass->getCellByColumnAndRow(1, $row)->getCoordinate();
            $sheetTKBClass->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheetTKBClass->getStyle($cell)->getFont()->setBold(true);
            $sessions = 1;
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                if ($sessions == 6) {
                    $sessions = 1;
                }
                $sheetTKBClass->setCellValueByColumnAndRow(2, $rowTableBody, $sessions);

                $cellSesion = $sheetTKBClass->getCellByColumnAndRow(2, $rowTableBody)->getCoordinate();
                $sheetTKBClass->getStyle($cellSesion)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheetTKBClass->getStyle($cellSesion)->getFont()->setBold(true);
                $rowTableBody++;
                $sessions++;
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
            $endrow = $rowTableBody - 1;
            $sheetTKBClass->getStyle("A" . $startRow . ":H" . $endrow)->applyFromArray($styleArray);
            $row += 12;
            $rowTableBody = $rowTableBody + 8;
        }

        $columnTableTime = 3;
        $rowTableBody = 4;
        foreach ($tableTime as $item) {
            // Export Morning
            // if ($rowTableBody > 12) {
            //     $rowTableBody -= 7;
            // }
            $tableMorning = $item->getTableTimeMorning();
            foreach ($tableMorning as $key => $table) {
                if ($table != null) {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->hovaten);
                } else {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                }
                if ($columnTableTime == 8) {
                    $rowTableBody++;
                    $columnTableTime = 3;
                } else {
                    $columnTableTime++;
                }
            }
            // Export Afternoon
            $tableAfterNoon = $item->getTableTimeAfterNoon();
            $columnTableTime = 3;

            foreach ($tableAfterNoon as $key => $table) {
                if ($table != null) {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->hovaten);
                } else {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                }
                if ($columnTableTime == 8) {
                    $rowTableBody++;
                    $columnTableTime = 3;
                } else {
                    $columnTableTime++;
                }
            }
            $rowTableBody = $rowTableBody + 8;
        }
        $this->autoSiezColumn($sheet);
        $this->saveExcel($sheet, "tkblophoc");
    }

    private function exportTKBTeachers($sheetTKBClass, $sheet, $listTeacher)
    {
        $tableTime = array();

        // construction tableTime;
        foreach ($listTeacher as $teacher) {
            $arrMorning = array();
            $arrAfternoon = array();

            // Get morning
            $ss = 1;
            for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$MIDDAY; $sessionMorning++) {

                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {

                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 0)
                        ->where('tiet', $ss)
                        ->where('thoikhoabieu.magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'danhsachlophoc.tenlop', 'thoikhoabieu.tiet')
                        ->first();
                    array_push($arrMorning, $table);
                }
                $ss++;
            }
            // Get afternoon
            $ss = 1;
            for ($sessionAfterNoon = Day::$MIDDAY; $sessionAfterNoon < Day::$AFTERNOON; $sessionAfterNoon++) {

                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {

                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 1)
                        ->where('tiet', $ss)
                        ->where('thoikhoabieu.magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop', 'danhsachgv.hovaten', 'thoikhoabieu.tiet')
                        ->first();
                    array_push($arrAfternoon, $table);
                }
                $ss++;
            }
            $itemTeacher = new TableTimeTypeTwo($teacher->name, $arrMorning, $arrAfternoon);
            array_push($tableTime, $itemTeacher);
        }
        // Generate TimeTable

        $startRow = 3;
        $row = 3;

        $rowTableBody = 4;
        $rowName = 1;
        // Render Header Table
        foreach ($tableTime as $item) {
            if ($row > 12) {
                $rowName = $row - 4;
            }
            $startRow = $row;
            $sheetTKBClass->mergeCells("A" . $rowName . ":H" . $rowName);
            $sheetTKBClass->setCellValueByColumnAndRow(1, $rowName, "THỜI KHÓA BIỂU GIÁO VIÊN " . $item->getTeacher());

            $sheetTKBClass->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetTKBClass->getStyle("A" . $rowName)->getFont()->setBold(true);

            $rowName++;
            $sheetTKBClass->mergeCells("A" . $rowName . ":H" . $rowName);
            // $sheetTKBClass->setCellValueByColumnAndRow(1, $rowName, "Thực hiện từ ngày: ");

            $sheetTKBClass->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetTKBClass->getStyle("A" . $rowName)->getFont()->setBold(false);

            // Render Header

            $sheetTKBClass->setCellValueByColumnAndRow(1, $row, "Buổi");
            $sheetTKBClass->setCellValueByColumnAndRow(2, $row, "Tiết");
            $sheetTKBClass->setCellValueByColumnAndRow(3, $row, "Thứ 2");
            $sheetTKBClass->setCellValueByColumnAndRow(4, $row, "Thứ 3");
            $sheetTKBClass->setCellValueByColumnAndRow(5, $row, "Thứ 4");
            $sheetTKBClass->setCellValueByColumnAndRow(6, $row, "Thứ 5");
            $sheetTKBClass->setCellValueByColumnAndRow(7, $row, "Thứ 6");
            $sheetTKBClass->setCellValueByColumnAndRow(8, $row, "Thứ 7");

            for ($i = 1; $i < 9; $i++) {
                $cellPart = $sheetTKBClass->getCellByColumnAndRow($i, $row)->getCoordinate();
                $sheetTKBClass->getStyle($cellPart)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheetTKBClass->getStyle($cellPart)->getFont()->setBold(true);
            }



            // Render Body Table
            $row++;
            $sheetTKBClass->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetTKBClass->setCellValueByColumnAndRow(1, $row, "Sáng");

            $cell = $sheetTKBClass->getCellByColumnAndRow(1, $row)->getCoordinate();
            $sheetTKBClass->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheetTKBClass->getStyle($cell)->getFont()->setBold(true);

            $row += 5;
            $sheetTKBClass->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetTKBClass->setCellValueByColumnAndRow(1, $row, "Chiều");

            $cell = $sheetTKBClass->getCellByColumnAndRow(1, $row)->getCoordinate();
            $sheetTKBClass->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheetTKBClass->getStyle($cell)->getFont()->setBold(true);
            $sessions = 1;
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                if ($sessions == 6) {
                    $sessions = 1;
                }
                $sheetTKBClass->setCellValueByColumnAndRow(2, $rowTableBody, $sessions);

                $cellSesion = $sheetTKBClass->getCellByColumnAndRow(2, $rowTableBody)->getCoordinate();
                $sheetTKBClass->getStyle($cellSesion)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheetTKBClass->getStyle($cellSesion)->getFont()->setBold(true);
                $rowTableBody++;
                $sessions++;
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
            $endrow = $rowTableBody - 1;
            $sheetTKBClass->getStyle("A" . $startRow . ":H" . $endrow)->applyFromArray($styleArray);
            $row += 12;
            $rowTableBody = $rowTableBody + 8;
        }

        $columnTableTime = 3;
        $rowTableBody = 4;
        foreach ($tableTime as $item) {
            // Export Morning
            // if ($rowTableBody > 12) {
            //     $rowTableBody -= 7;
            // }
            $tableMorning = $item->getTableTimeMorning();
            foreach ($tableMorning as $key => $table) {
                if ($table != null) {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->tenlop);
                } else {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                }
                if ($columnTableTime == 8) {
                    $rowTableBody++;
                    $columnTableTime = 3;
                } else {
                    $columnTableTime++;
                }
            }
            // Export Afternoon
            $tableAfterNoon = $item->getTableTimeAfterNoon();
            $columnTableTime = 3;

            foreach ($tableAfterNoon as $key => $table) {
                if ($table != null) {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->tenlop);
                } else {
                    $sheetTKBClass->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                }
                if ($columnTableTime == 8) {
                    $rowTableBody++;
                    $columnTableTime = 3;
                } else {
                    $columnTableTime++;
                }
            }
            $rowTableBody = $rowTableBody + 8;
        }
        $this->autoSiezColumn($sheet);
        $this->saveExcel($sheet, "tkbgiaovien");
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

    private function headerRow($sheet, $lastColumn, $lastCellAddress)
    {

        $sheet->mergeCellsByColumnAndRow(1, 2, $lastColumn, 2);
        // $sheet->setCellValueByColumnAndRow(1, 2, "THỜI KHÓA BIỂU SỐ " . $no);
        $sheet->mergeCellsByColumnAndRow(1, 3, $lastColumn, 3);
        // $sheet->setCellValueByColumnAndRow(1, 3, "Ngày thực hiện " );

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

    // private function exportTKBTecherTypeOne($sheetTKBTeacher, $type = 1){
    //     $listTeacher = danhsachgv::where('matruong', $this->sessionInfo->getSchoolId())->get();
    //     $rowHead = 4;
    //     $indexColum = 3;
    //     $lastColumn = 0;
    //     // Render Header with list teacher
    //     foreach ($listTeacher as $teacher) {
    //         $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $rowHead, $teacher->hovaten);
    //         $indexColum++;
    //     }

    //     // Get data
    //     $tableTime = array();

    //     for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
    //         for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
    //             foreach ($listTeacher as $objTeacher) {
    //                 // get table time of morning
    //                 $table = thoikhoabieu::where('thu', $day)
    //                     ->where('tiet', $session)
    //                     ->where('magiaovien', $objTeacher->id)
    //                     ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
    //                     ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
    //                     ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
    //                     ->first();

    //                 if ($table != null) {
    //                     $item = new TableTime($day, $session, $table->tenmonhoc, $table->tenlop);
    //                     array_push($tableTime, $item);
    //                 } else {
    //                     array_push($tableTime, null);
    //                 }
    //             }
    //         }
    //     }

    //     // Render Tabletime
    //     $indexColum = 3;
    //     $totalRow = 64;
    //     $indexTable = 0;
    //     $titleLenght = count($listTeacher);

    //     for ($indexRowbody = 5; $indexRowbody < $totalRow; $indexRowbody++) {
    //         $indexColum = 3;
    //         while ($indexColum < $titleLenght) {
    //             if ($indexColum == 35) {
    //                 $p = 1;
    //             }
    //             $tableItem = $tableTime[$indexTable];
    //             if ($tableItem != null) {
    //                 if ($type == 1) {
    //                     $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $indexRowbody, $tableItem->getSubject() . "-" . $tableItem->getName());
    //                 } elseif ($type == 2) {
    //                     $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $indexRowbody, $tableItem->getName());
    //                 } elseif ($type == 2) {
    //                     $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $indexRowbody, $tableItem->getSubject());
    //                 }
    //                 $indexColum++;
    //             } else {
    //                 $sheetTKBTeacher->setCellValueByColumnAndRow($indexColum, $indexRowbody, "");
    //                 $indexColum++;
    //             }
    //             $lastColumn = $indexColum;
    //             if ($indexTable < count($tableTime)) {
    //                 $indexTable++;
    //             }
    //         }
    //     }
    //     $lastCellAddress = $sheetTKBTeacher->getCellByColumnAndRow($titleLenght, $totalRow)->getCoordinate();
    //     $this->headerRow($sheetTKBTeacher, $lastColumn, $lastCellAddress);
    //     $this->sign($sheetTKBTeacher, $lastColumn, $totalRow + 2);
    //     $this->setBorder($sheetTKBTeacher, "A4:", $lastCellAddress);
    // }

    # Ham xuat thoi khoa bieu cua giao vien
    private function exportTKBTecherTypeTwo($sheetTKBTeacherTypeTwo, $sheet, $listTeacher)
    {
        // Get data
        $tableTime = array();
        foreach ($listTeacher as $teacher) {
            $arrMorning = array();
            $arrAfternoon = array();
            for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
                // Get tabletime morning
                $ss = 1;
                for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$MIDDAY; $sessionMorning++) {
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 0)
                        ->where('tiet', $ss)
                        ->where('magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                        ->first();
                    array_push($arrMorning, $table);
                    $ss++;
                }

                $ss = 1;
                // Get tabletime afternoon
                for ($sessionAfterNoon = Day::$MIDDAY; $sessionAfterNoon < Day::$AFTERNOON; $sessionAfterNoon++) {
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 1)
                        ->where('tiet', $ss)
                        ->where('magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                        ->first();
                    array_push($arrAfternoon, $table);
                    $ss++;
                }
            }
            $itemTeacher = new TableTimeTypeTwo($teacher->name, $arrMorning, $arrAfternoon);
            array_push($tableTime, $itemTeacher);
        }
        // Export table
        $rowName = 7;
        $columnName = 2;
        $columnTableTime = 4;
        $rowTime = 7;
        foreach ($tableTime as $key => $item) {
            // set Name to cell Name
            if ($key == 2) {
                $f = 1;
            }
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
            $rowName += 2;
            $rowTime += 2;
            $columnTableTime = 4;
        }
        $this->autoSiezColumn($sheet);
        $this->saveExcel($sheet, "tkbgiaovien");
    }

    private function exportTKBTecherTypeThree($sheetTKBSchoolThree, $sheet)
    {
        $tableTime = array();
        $listTeacher = danhsachgv::where('matruong', $this->sessionInfo->getSchoolId())->get();

        // construction tableTime;
        foreach ($listTeacher as $teacher) {
            $arrMorning = array();
            $arrAfternoon = array();

            // Get morning
            for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$AFTERNOON; $sessionMorning++) {
                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 1)
                        ->where('tiet', $sessionMorning)
                        ->where('magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop', 'thoikhoabieu.tiet')
                        ->first();
                    array_push($arrMorning, $table);
                }
            }
            // Get afternoon
            for ($sessionAfterNoon = Day::$MORNING; $sessionAfterNoon < Day::$MIDDAY; $sessionAfterNoon++) {
                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 2)
                        ->where('tiet', $sessionAfterNoon)
                        ->where('magiaovien', $teacher->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop', 'thoikhoabieu.tiet')
                        ->first();
                    array_push($arrAfternoon, $table);
                }
            }
            $itemTeacher = new TableTimeTypeTwo($teacher->hovaten, $arrMorning, $arrAfternoon);
            array_push($tableTime, $itemTeacher);
        }
        // Generate TimeTable

        $startRow = 3;
        $row = 3;

        $rowTableBody = 4;
        $rowName = 1;
        // Render Header Table
        foreach ($tableTime as $item) {
            if ($row > 12) {
                $rowName = $row - 4;
            }
            $startRow = $row;
            $sheetTKBSchoolThree->mergeCells("A" . $rowName . ":H" . $rowName);
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(1, $rowName, $item->getTeacher());

            $sheetTKBSchoolThree->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetTKBSchoolThree->getStyle("A" . $rowName)->getFont()->setBold(true);

            $rowName++;
            $sheetTKBSchoolThree->mergeCells("A" . $rowName . ":H" . $rowName);
            // $sheetTKBSchoolThree->setCellValueByColumnAndRow(1, $rowName, "Thực hiện từ ngày: ");

            $sheetTKBSchoolThree->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetTKBSchoolThree->getStyle("A" . $rowName)->getFont()->setBold(false);

            // Render Header
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(1, $row, "Buổi");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(2, $row, "Tiết");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(3, $row, "Thứ 2");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(4, $row, "Thứ 3");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(5, $row, "Thứ 4");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(6, $row, "Thứ 5");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(7, $row, "Thứ 6");
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(8, $row, "Thứ 7");
            // Render Body Table
            $row++;
            $sheetTKBSchoolThree->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(1, $row, "Sáng");
            $row += 5;
            $sheetTKBSchoolThree->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetTKBSchoolThree->setCellValueByColumnAndRow(1, $row, "Chiều");
            // Render Morning
            // Redner session

            $sessions = 1;
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                if ($sessions == 6) {
                    $sessions = 1;
                }
                $sheetTKBSchoolThree->setCellValueByColumnAndRow(2, $rowTableBody, $sessions);
                $rowTableBody++;
                $sessions++;
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
            $endrow = $rowTableBody;
            $sheetTKBSchoolThree->getStyle("A" . $startRow . ":H" . $endrow)->applyFromArray($styleArray);
            $row += 12;
            $rowTableBody = $rowTableBody + 8;
        }

        $columnTableTime = 3;
        $rowTableBody = 4;
        foreach ($tableTime as $item) {
            // Export Morning
            if ($rowTableBody > 13) {
                $rowTableBody -= 3;
            }
            $tableMorning = $item->getTableTimeMorning();
            foreach ($tableMorning as $key => $table) {
                if ($table != null) {
                    $sheetTKBSchoolThree->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->tenlop);
                } else {
                    $sheetTKBSchoolThree->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                }
                if ($columnTableTime == 8) {
                    $rowTableBody++;
                    $columnTableTime = 3;
                } else {
                    $columnTableTime++;
                }
            }
            // Export Afternoon
            $tableAfterNoon = $item->getTableTimeAfterNoon();
            $columnTableTime = 3;

            foreach ($tableAfterNoon as $key => $table) {
                if ($table != null) {
                    $sheetTKBSchoolThree->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->tenlop);
                } else {
                    $sheetTKBSchoolThree->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                }
                if ($columnTableTime == 8) {
                    $rowTableBody++;
                    $columnTableTime = 3;
                } else {
                    $columnTableTime++;
                }
            }
            $row += 12;
            $rowTableBody = $rowTableBody + 8;
        }
        $this->autoSiezColumn($sheet);
        $this->saveExcel($sheet, "tkblop");
    }

    private function exportTKBGroup($spreadsheet)
    {

        $listGroup = tochuyenmon::where('matruong', '=', $this->sessionInfo->getSchoolId())->get();

        $numberSheet = 0;
        foreach ($listGroup as $group) {
            $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $group->tentocm);
            $spreadsheet->addSheet($sheet, $numberSheet);
            $spreadsheet->setActiveSheetIndex($numberSheet);
            $sheetSelect = $spreadsheet->getActiveSheet();
            // Render column default;
            $sheetSelect->setCellValue("A4", "Thứ");
            $sheetSelect->setCellValue("B4", "Tiết");


            $sheetSelect->mergeCells("A5:A9");
            $sheetSelect->setCellValue("A5", "Thứ 2");

            $sheetSelect->mergeCells("A10:A14");
            $sheetSelect->setCellValue("A10", "Thứ 2 chiều");


            $sheetSelect->mergeCells("A15:A19");
            $sheetSelect->setCellValue("A15", "Thứ 3");

            $sheetSelect->mergeCells("A20:A24");
            $sheetSelect->setCellValue("A20", "Thứ 3 chiều");



            $sheetSelect->mergeCells("A25:A29");
            $sheetSelect->setCellValue("A25", "Thứ 4 chiều");

            $sheetSelect->mergeCells("A30:A34");
            $sheetSelect->setCellValue("A30", "Thứ 4 chiều");


            $sheetSelect->mergeCells("A35:A39");
            $sheetSelect->setCellValue("A35", "Thứ 5");

            $sheetSelect->mergeCells("A40:A44");
            $sheetSelect->setCellValue("A40", "Thứ 5 chiều");

            $sheetSelect->mergeCells("A45:A49");
            $sheetSelect->setCellValue("A45", "Thứ 6");

            $sheetSelect->mergeCells("A50:A54");
            $sheetSelect->setCellValue("A50", "Thứ 6 chiều");


            $sheetSelect->mergeCells("A55:A59");
            $sheetSelect->setCellValue("A55", "Thứ 7");

            $sheetSelect->mergeCells("A60:A64");
            $sheetSelect->setCellValue("A60", "Thứ 7");

            $ss = 1;
            for ($rowSession = 5; $rowSession < 65; $rowSession++) {
                $sheetSelect->setCellValue("B" . $rowSession, $ss);
                if ($ss == 5) {
                    $ss = 1;
                } else {
                    $ss++;
                }
            }

            $listTeacher = danhsachgv::where('giaovien_chuyenmon.matochuyenmon', $group->id)
                ->join('giaovien_chuyenmon', 'giaovien_chuyenmon.magiaovien', 'danhsachgv.id')
                ->select('danhsachgv.id', 'danhsachgv.hovaten')
                ->get();
            $rowHead = 4;
            $indexColum = 3;
            $lastColumn = 0;
            // Render Header with list teacher
            foreach ($listTeacher as $teacher) {
                $sheetSelect->setCellValueByColumnAndRow($indexColum, $rowHead, $teacher->hovaten);
                $indexColum++;
            }

            // Get data
            $tableTime = array();

            foreach ($listTeacher as $teacher) {
                $table = new stdClass();
                $table->name = $teacher->id;
                $arrTable = array();
                for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
                    // Morning
                    for ($seesion = DAY::$MORNING; $seesion < Day::$MIDDAY; $seesion++) {
                        $tableMorning = thoikhoabieu::where('thu', $day)
                            ->where('buoi', 0)
                            ->where('tiet', $seesion)
                            ->where('magiaovien', $teacher->id)
                            ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                            ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                            ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                            ->first();
                        array_push($arrTable, $tableMorning);
                    }

                    // Afternoon
                    $ss = 1;
                    for ($seesion = DAY::$MIDDAY; $seesion < Day::$AFTERNOON; $seesion++) {
                        $tableAfterNoon = thoikhoabieu::where('thu', $day)
                            ->where('buoi', 1)
                            ->where('tiet', $ss)
                            ->where('magiaovien', $teacher->id)
                            ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                            ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                            ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
                            ->first();
                        array_push($arrTable, $tableAfterNoon);
                        $ss++;
                    }
                }
                $table->table = $arrTable;
                array_push($tableTime, $table);
            }


            //  Render Tabletime
            $indexColum = 3;
            $totalRow = 64;
            $indexTable = 0;
            $titleLenght = count($listTeacher);

            $indexColum = 3;
            while ($indexColum < $titleLenght) {
                $tableItem = $tableTime[$indexTable];
                $table = $tableItem->table;
                $row = 5;
                foreach ($table as $item) {
                    if ($item != null) {
                        $sheetSelect->setCellValueByColumnAndRow($indexColum, $row, $item->tenmonhoc . "-" . $item->tenlop);
                    } else {
                        $sheetSelect->setCellValueByColumnAndRow($indexColum, $row, "");
                    }
                    $row++;
                }
                $indexColum++;
                $indexTable++;
            }
            $lastCellAddress = $sheetSelect->getCellByColumnAndRow($titleLenght + 2, $totalRow)->getCoordinate();
            $this->setBorder($sheetSelect, "A4:", $lastCellAddress);

            $sheetSelect->mergeCellsByColumnAndRow(1, 1, $lastColumn, 1);
            $sheetSelect->setCellValueByColumnAndRow(1, 1, "THỜI KHÓA BIỂU " . strtoupper($group->tentocm));
            $sheetSelect->mergeCellsByColumnAndRow(1, 2, $lastColumn, 2);
            $sheetSelect->setCellValueByColumnAndRow(1, 2, "Ngày thực hiện ");

            $sheetSelect->getStyle("A1:" . $lastCellAddress)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $sheetSelect->getStyle("A1:" . $lastCellAddress)->getFont()->setBold(true);


            $sheetSelect->getStyle("A2:" . $lastCellAddress)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $sheetSelect->getStyle("A2:" . $lastCellAddress)->getFont()->setBold(true);
            $numberSheet++;
        }
        $this->autoSiezColumn($spreadsheet);
        $this->saveExcel($spreadsheet, "tkbpccm");
    }

    public function sendEmail(Request $request)
    {
        $listMail = json_decode($request->listMail);
        // Remove File to folder upload
        if (!is_dir(public_path('upload'))) {
            mkdir(public_path('upload'));
        }
        $arrFile = array();
        $files = $request->files->get("files");
        foreach ($files as $f) {
            $f->move(public_path('upload'), $f->getClientOriginalName());
            array_push($arrFile, $f->getClientOriginalName());
        }
        $arrFail = array();
        // Send email
        foreach ($listMail as $mail) {
            if ($mail != null) {
                Mail::send(array(), array(), function ($message) use ($mail, $arrFile) {
                    $message->to($mail, 'Phần mềm thời khóa biểu')->subject('Thời khóa biểu ' . $this->sessionInfo->getSchoolName());
                    foreach ($arrFile as $file) {
                        $message->attach(public_path('upload/') . $file);
                    }
                    $message->from('hacker11357@gmail.com', 'Thời khóa biểu ' . $this->sessionInfo->getSchoolName());
                });
            } else {
                array_push($arrFail, $mail);
            }
        }
        return response()->json(['msg' => "OK", 'fail' => $arrFail]);
    }

    public function viewDatabase()
    {
        $table = thoikhoabieu::where('malop', 1811)
            ->where('thu', 2)
            ->where('buoi', 1)
            ->where('tiet', 5)
            ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
            ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
            ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'thoikhoabieu.malop', 'thoikhoabieu.tiet')
            ->first();
        return response()->json($table);
    }
}
