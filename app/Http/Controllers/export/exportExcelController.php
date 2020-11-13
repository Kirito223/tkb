<?php

namespace App\Http\Controllers\export;

use App\danhsachgv;
use App\danhsachlophoc;
use App\diemtruong;
use App\Http\Controllers\Controller;
use App\Objects\Day;
use App\Objects\SessionInfo;
use App\Objects\TableTime;
use App\Objects\TableTimeTypeTwo;
use App\phonghoc;
use App\thoikhoabieu;
use App\tietnghigiaovien;
use App\tochuyenmon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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

        $startMonth = $param->startMonth;
        $endMonth = $param->endMonth;
        $week = $param->week;
        if ($param->tkbtruong == 1) {
            // TKB trường
            $sheet = $this->loadSheetExcel('mautkbtruong.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetTKBSchool = $sheet->getActiveSheet();
            $fullname = $param->tendaydu;
            $this->exportTKBSchoolTwoColumn($sheetTKBSchool, $sheet, $fullname, $startMonth, $endMonth, $week);
            array_push($fileExport, "thoikhoabieutruong");
        }
        if ($param->tkblop == 1) {
            $classList = json_decode($param->arrSelect);
            $sheet = $this->loadSheetExcel('mautkbphonghoc.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetTKBTeacherClass = $sheet->getActiveSheet();
            $this->exportTKBClass($sheetTKBTeacherClass, $sheet, $classList, $startMonth, $endMonth, $week);
        }
        if ($param->tkbGV == 1) {
            $teacherList  = json_decode($param->arrSelect);
            $sheet = $this->loadSheetExcel('mautkbphonghoc.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetTKBTeacherTypeTwo = $sheet->getActiveSheet();
            $this->exportTKBTeachers($sheetTKBTeacherTypeTwo, $sheet, $teacherList, $startMonth, $endMonth, $week);
        }
        if ($param->tkbphong == 1) {
            $roomList  = json_decode($param->arrSelect);
            $file =   $this->exportTKBRoom($startMonth, $endMonth, $week, $roomList);
            return  response()->json(['msg' => 'ok', 'data' => $file], Response::HTTP_OK);
        }
        if ($param->tkbphancongcm == 1) {
            $sheet = $this->loadSheetExcel('mautkbtochuyenmon.xlsx');
            $this->exportTKBGroup($sheet, $startMonth, $endMonth, $week);
        }

        if ($param->tkbdiemtruong == 1) {
            $locationList  = json_decode($param->arrSelect);
            $file =   $this->exportTKBSchoolLocaltion($startMonth, $endMonth, $week, $locationList);
            return  response()->json(['msg' => 'ok', 'data' => $file], Response::HTTP_OK);
        }

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

    public function listRoom()
    {
        $listRoom = phonghoc::where('matruong', $this->sessionInfo->getSchoolId())
            ->where('mamonhoc', '!=', null)
            ->where('trangthai', 1)
            ->select('id', 'tenphong as name')
            ->get();
        return response()->json($listRoom);
    }

    public function listLocation()
    {
        $listSchoolLocation = diemtruong::where('matruong', $this->sessionInfo->getSchoolId())->get();
        $listNameLocation = array();
        foreach ($listSchoolLocation as $nameLocation) {
            if ($this->existsInArray($nameLocation, $listNameLocation) == false) {
                array_push($listNameLocation, ['id' => 0, 'name' => $nameLocation->tendiemtruong]);
            }
        }
        return response()->json($listNameLocation);
    }

    function existsInArray($entry, $array)
    {
        if (count($array) == 0) {
            return false;
        } else {
            foreach ($array as $compare) {
                if ($compare['name'] == $entry->tendiemtruong) {
                    return true;
                }
            }
            return false;
        }
    }

    public function exportTKBRoom($startMonth, $endMonth, $week, $listRoom)
    {


        $tableTime = array();

        // construction tableTime;
        foreach ($listRoom as $room) {
            $arrMorning = array();
            $arrAfternoon = array();

            // Get morning

            for ($day = 2; $day < 8; $day++) {

                for ($tiet = 1; $tiet < 6; $tiet++) {

                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 0)
                        ->where('tiet', $tiet)
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
                        ->where('thoikhoabieu.maphong', $room->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'danhsachlophoc.tenlop', 'thoikhoabieu.tiet', 'thoikhoabieu.thu', 'thoikhoabieu.buoi')
                        ->first();

                    $item = new stdClass();
                    $item->day = $day;
                    $item->session = $tiet;
                    $item->time = 1;
                    if ($table != null) {
                        $item->assign = $table->hovaten . '-' . $table->tenlop;
                    } else {
                        $item->assign = null;
                    }
                    array_push($arrAfternoon, $item);
                    array_push($arrMorning, $item);
                }
            }

            // Get afternoon
            for ($day = 2; $day < 8; $day++) {

                for ($tiet = 1; $tiet < 6; $tiet++) {

                    $table = thoikhoabieu::where('thu', $day)
                        ->where('buoi', 1)
                        ->where('tiet', $tiet)
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
                        ->where('thoikhoabieu.maphong', $room->id)
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'danhsachgv.hovaten', 'danhsachlophoc.tenlop', 'thoikhoabieu.tiet', 'thoikhoabieu.thu', 'thoikhoabieu.buoi')
                        ->first();

                    $item = new stdClass();
                    $item->day = $day;
                    $item->session = $tiet;
                    $item->time = 1;
                    if ($table != null) {
                        $item->assign = $table->hovaten . '-' . $table->tenlop;
                    } else {
                        $item->assign = "";
                    }
                    array_push($arrAfternoon, $item);
                }
            }
            $itemTeacher = new TableTimeTypeTwo($room->name, $arrMorning, $arrAfternoon);
            array_push($tableTime, $itemTeacher);
        }
        // Generate TimeTable


        $arrFile = array();
        foreach ($listRoom as $room) {
            array_push($arrFile, $room->name);
        }


        // Render Header Table
        foreach ($tableTime as $item) {
            $startRow = 3;
            $row = 3;

            $rowTableBody = 4;
            $rowName = 1;

            $spreadsheet = new Spreadsheet();
            $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $item->getTeacher());
            $spreadsheet->addSheet($sheet, 0);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetSelect = $spreadsheet->getActiveSheet();
            $startRow = $row;
            $sheetSelect->mergeCells("A" . $rowName . ":H" . $rowName);
            $sheetSelect->setCellValueByColumnAndRow(1, $rowName, "THỜI KHÓA BIỂU PHÒNG " . $item->getTeacher());

            $sheetSelect->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetSelect->getStyle("A" . $rowName)->getFont()->setBold(true);

            $rowName++;
            $sheetSelect->mergeCells("A" . $rowName . ":H" . $rowName);

            $sheetSelect->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheetSelect->getStyle("A" . $rowName)->getFont()->setBold(false);

            // Render Header

            $sheetSelect->setCellValueByColumnAndRow(1, $row, "Buổi");
            $sheetSelect->setCellValueByColumnAndRow(2, $row, "Tiết");
            $sheetSelect->setCellValueByColumnAndRow(3, $row, "Thứ 2");
            $sheetSelect->setCellValueByColumnAndRow(4, $row, "Thứ 3");
            $sheetSelect->setCellValueByColumnAndRow(5, $row, "Thứ 4");
            $sheetSelect->setCellValueByColumnAndRow(6, $row, "Thứ 5");
            $sheetSelect->setCellValueByColumnAndRow(7, $row, "Thứ 6");
            $sheetSelect->setCellValueByColumnAndRow(8, $row, "Thứ 7");

            for ($i = 1; $i < 9; $i++) {
                $cellPart = $sheetSelect->getCellByColumnAndRow($i, $row)->getCoordinate();
                $sheetSelect->getStyle($cellPart)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheetSelect->getStyle($cellPart)->getFont()->setBold(true);
            }



            // Render Body Table
            $row++;
            $sheetSelect->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetSelect->setCellValueByColumnAndRow(1, $row, "Sáng");

            $cell = $sheetSelect->getCellByColumnAndRow(1, $row)->getCoordinate();
            $sheetSelect->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheetSelect->getStyle($cell)->getFont()->setBold(true);

            $row += 5;
            $sheetSelect->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
            $sheetSelect->setCellValueByColumnAndRow(1, $row, "Chiều");

            $cell = $sheetSelect->getCellByColumnAndRow(1, $row)->getCoordinate();
            $sheetSelect->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheetSelect->getStyle($cell)->getFont()->setBold(true);
            $sessions = 1;
            for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                if ($sessions == 6) {
                    $sessions = 1;
                }
                $sheetSelect->setCellValueByColumnAndRow(2, $rowTableBody, $sessions);

                $cellSesion = $sheetSelect->getCellByColumnAndRow(2, $rowTableBody)->getCoordinate();
                $sheetSelect->getStyle($cellSesion)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheetSelect->getStyle($cellSesion)->getFont()->setBold(true);
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
            $sheetSelect->getStyle("A" . $startRow . ":H" . $endrow)->applyFromArray($styleArray);
            //   $this->autoSiezColumn($sheet);

            $this->saveExcel($spreadsheet, $item->getTeacher());
        }


        foreach ($tableTime as $item) {



            $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('export') . "/" . $item->getTeacher() . '.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetSelect = $sheet->getActiveSheet();

            $tableMorning = $item->getTableTimeMorning();
            foreach ($tableMorning as $key => $table) {

                // 2th 
                if ($table->day == 2 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C4", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C4", "");
                    }
                }
                if ($table->day == 2 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C5", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C5", "");
                    }
                }

                if ($table->day == 2 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C6", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C6", "");
                    }
                }

                if ($table->day == 2 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C7", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C7", "");
                    }
                }
                if ($table->day == 2 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C8", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C8", "");
                    }
                }

                // 3th
                if ($table->day == 3 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D4", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D4", "");
                    }
                }
                if ($table->day == 3 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D5", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D5", "");
                    }
                }
                if ($table->day == 3 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D6", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D6", "");
                    }
                }
                if ($table->day == 3 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D7", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D7", "");
                    }
                }
                if ($table->day == 3 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D8", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D8", "");
                    }
                }
                // 4th 

                if ($table->day == 4 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E4", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E4", "");
                    }
                }
                if ($table->day == 4 && $table->session == 2) {

                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E5", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E5", "");
                    }
                }
                if ($table->day == 4 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E6", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E6", "");
                    }
                }
                if ($table->day == 4 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E7", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E7", "");
                    }
                }
                if ($table->day == 4 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E8", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E8", "");
                    }
                }
                // 5th 

                if ($table->day == 5 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F4", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F4", "");
                    }
                }
                if ($table->day == 5 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F5", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F5", "");
                    }
                }
                if ($table->day == 5 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F6", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F6", "");
                    }
                }
                if ($table->day == 5 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F7", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F7", "");
                    }
                }
                if ($table->day == 5 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F8", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F8", "");
                    }
                }

                // 6th

                if ($table->day == 6 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G4", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G4", "");
                    }
                }
                if ($table->day == 6 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G5", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G5", "");
                    }
                }
                if ($table->day == 6 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G6", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G6", "");
                    }
                }
                if ($table->day == 6 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G7", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G7", "");
                    }
                }
                if ($table->day == 6 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G8", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G8", "");
                    }
                }

                // 7th

                if ($table->day == 7 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H4", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H4", "");
                    }
                }
                if ($table->day == 7 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H5", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H5", "");
                    }
                }
                if ($table->day == 7 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H6", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H6", "");
                    }
                }
                if ($table->day == 7 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H7", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H7", "");
                    }
                }
                if ($table->day == 7 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H8", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H8", "");
                    }
                }
            }
            // Export Afternoon
            $tableAfterNoon = $item->getTableTimeAfterNoon();

            foreach ($tableAfterNoon as $key => $table) {
                // 2th 
                if ($table->day == 2 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C9", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C9", "");
                    }
                }
                if ($table->day == 2 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C10", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C10", "");
                    }
                }

                if ($table->day == 2 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C11", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C11", "");
                    }
                }

                if ($table->day == 2 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C12", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C12", "");
                    }
                }
                if ($table->day == 2 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("C13", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("C13", "");
                    }
                }

                // 3th
                if ($table->day == 3 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D9", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D9", "");
                    }
                }
                if ($table->day == 3 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D10", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D10", "");
                    }
                }
                if ($table->day == 3 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D11", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D11", "");
                    }
                }
                if ($table->day == 3 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D12", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D12", "");
                    }
                }
                if ($table->day == 3 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("D13", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("D13", "");
                    }
                }
                // 4th 

                if ($table->day == 4 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E9", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E9", "");
                    }
                }
                if ($table->day == 4 && $table->session == 2) {

                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E10", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E10", "");
                    }
                }
                if ($table->day == 4 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E11", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E11", "");
                    }
                }
                if ($table->day == 4 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E12", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E12", "");
                    }
                }
                if ($table->day == 4 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("E13", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("E13", "");
                    }
                }
                // 5th 

                if ($table->day == 5 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F9", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F9", "");
                    }
                }
                if ($table->day == 5 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F10", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F10", "");
                    }
                }
                if ($table->day == 5 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F11", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F11", "");
                    }
                }
                if ($table->day == 5 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F12", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F12", "");
                    }
                }
                if ($table->day == 5 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("F13", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("F13", "");
                    }
                }
                // 6th

                if ($table->day == 6 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G9", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G9", "");
                    }
                }
                if ($table->day == 6 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G10", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G10", "");
                    }
                }
                if ($table->day == 6 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G11", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G11", "");
                    }
                }
                if ($table->day == 6 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G12", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G12", "");
                    }
                }
                if ($table->day == 6 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("G13", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("G13", "");
                    }
                }

                // 7th

                if ($table->day == 7 && $table->session == 1) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H9", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H9", "");
                    }
                }
                if ($table->day == 7 && $table->session == 2) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H10", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H10", "");
                    }
                }
                if ($table->day == 7 && $table->session == 3) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H11", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H11", "");
                    }
                }
                if ($table->day == 7 && $table->session == 4) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H12", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H12", "");
                    }
                }
                if ($table->day == 7 && $table->session == 5) {
                    if ($table->assign != null) {
                        $sheetSelect->setCellValue("H13", $table->assign);
                    } else {
                        $sheetSelect->setCellValue("H13", "");
                    }
                }
            }
            $this->autoSiezColumn($sheet);
            $this->saveExcel($sheet, $item->getTeacher());
        }

        return $arrFile;
    }


    public function exportTKBSchoolLocaltion($startMonth, $endMonth, $week, $listSchoolLocation)
    {
        // get class of location
        $listLocation = array();
        foreach ($listSchoolLocation as $name) {
            $item = new stdClass();
            $item->nameLocation = $name->name;

            $class = diemtruong::where('matruong', $this->sessionInfo->getSchoolId())
                ->where('tendiemtruong',  $name->name)
                ->with('danhsachlophoc')
                ->get();

            $item->listClass = $class;
            array_push($listLocation, $item);
        }


        // make table time
        $tableTimeLocation = array();

        foreach ($listLocation as $location) {
            $itemTableTime = new stdClass;
            $itemTableTime->locationName = $location->nameLocation;

            $listClass =  $location->listClass;

            $tableTime = array();

            // construction tableTime;
            foreach ($listClass as $room) {
                $arrMorning = array();
                $arrAfternoon = array();
                // Get morning
                $ss = 1;
                for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$MIDDAY; $sessionMorning++) {

                    for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {

                        $table = thoikhoabieu::where('thu', $day)
                            ->where('buoi', 0)
                            ->where('tiet', $ss)
                            ->where('thoikhoabieu.malop', $room->malop)
                            ->where('tuan', $week)
                            ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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
                            ->where('thoikhoabieu.malop', $room->malop)
                            ->where('tuan', $week)
                            ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
                            ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                            ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
                            ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                            ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop', 'danhsachgv.hovaten', 'thoikhoabieu.tiet')
                            ->first();
                        array_push($arrAfternoon, $table);
                    }
                    $ss++;
                }
                $itemTeacher = new TableTimeTypeTwo($room->danhsachlophoc->tenlop, $arrMorning, $arrAfternoon);
                array_push($tableTime, $itemTeacher);
            }
            $itemTableTime->tableTime = $tableTime;
            array_push($tableTimeLocation, $itemTableTime);
        }

        // Export Tkb

        $arrFile = array();
        foreach ($listSchoolLocation as $name) {
            array_push($arrFile,  $name->name);
        }

        // Created file excel of school location
        foreach ($tableTimeLocation as $itemTable) {
            // Craeted Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $itemTable->locationName);

            $spreadsheet->addSheet($sheet, 0);
            $spreadsheet->setActiveSheetIndex(0);
            $sheetSelect = $spreadsheet->getActiveSheet();
            $tableTime = $itemTable->tableTime;
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
                $sheetSelect->mergeCells("A" . $rowName . ":H" . $rowName);
                $sheetSelect->setCellValueByColumnAndRow(1, $rowName, "THỜI KHÓA BIỂU LỚP " . $item->getTeacher());

                $sheetSelect->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheetSelect->getStyle("A" . $rowName)->getFont()->setBold(true);

                $rowName++;
                $sheetSelect->mergeCells("A" . $rowName . ":H" . $rowName);
                // $sheetTKBClass->setCellValueByColumnAndRow(1, $rowName, "Thực hiện từ ngày: ");

                $sheetSelect->getStyle("A" . $rowName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheetSelect->getStyle("A" . $rowName)->getFont()->setBold(false);

                // Render Header

                $sheetSelect->setCellValueByColumnAndRow(1, $row, "Buổi");
                $sheetSelect->setCellValueByColumnAndRow(2, $row, "Tiết");
                $sheetSelect->setCellValueByColumnAndRow(3, $row, "Thứ 2");
                $sheetSelect->setCellValueByColumnAndRow(4, $row, "Thứ 3");
                $sheetSelect->setCellValueByColumnAndRow(5, $row, "Thứ 4");
                $sheetSelect->setCellValueByColumnAndRow(6, $row, "Thứ 5");
                $sheetSelect->setCellValueByColumnAndRow(7, $row, "Thứ 6");
                $sheetSelect->setCellValueByColumnAndRow(8, $row, "Thứ 7");

                for ($i = 1; $i < 9; $i++) {
                    $cellPart = $sheetSelect->getCellByColumnAndRow($i, $row)->getCoordinate();
                    $sheetSelect->getStyle($cellPart)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheetSelect->getStyle($cellPart)->getFont()->setBold(true);
                }



                // Render Body Table
                $row++;
                $sheetSelect->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
                $sheetSelect->setCellValueByColumnAndRow(1, $row, "Sáng");

                $cell = $sheetSelect->getCellByColumnAndRow(1, $row)->getCoordinate();
                $sheetSelect->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheetSelect->getStyle($cell)->getFont()->setBold(true);

                $row += 5;
                $sheetSelect->mergeCellsByColumnAndRow(1, $row, 1, $row + 4);
                $sheetSelect->setCellValueByColumnAndRow(1, $row, "Chiều");

                $cell = $sheetSelect->getCellByColumnAndRow(1, $row)->getCoordinate();
                $sheetSelect->getStyle($cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheetSelect->getStyle($cell)->getFont()->setBold(true);
                $sessions = 1;
                for ($session = Day::$MORNING; $session < Day::$AFTERNOON; $session++) {
                    if ($sessions == 6) {
                        $sessions = 1;
                    }
                    $sheetSelect->setCellValueByColumnAndRow(2, $rowTableBody, $sessions);

                    $cellSesion = $sheetSelect->getCellByColumnAndRow(2, $rowTableBody)->getCoordinate();
                    $sheetSelect->getStyle($cellSesion)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheetSelect->getStyle($cellSesion)->getFont()->setBold(true);
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
                $sheetSelect->getStyle("A" . $startRow . ":H" . $endrow)->applyFromArray($styleArray);
                $row += 12;
                $rowTableBody = $rowTableBody + 8;
            }

            $this->saveExcel($spreadsheet, $itemTable->locationName);
        }


        // export data to file excel template

        foreach ($tableTimeLocation as $item) {
            $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('export') . "/" . $item->locationName . '.xlsx');
            $sheet->setActiveSheetIndex(0);
            $sheetSelect = $sheet->getActiveSheet();

            $columnTableTime = 3;
            $rowTableBody = 4;

            foreach ($item->tableTime as $itemTime) {
                // Export Morning

                $tableMorning = $itemTime->getTableTimeMorning();
                foreach ($tableMorning as $key => $table) {
                    if ($table != null) {
                        $sheetSelect->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->hovaten);
                    } else {
                        $sheetSelect->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
                    }
                    if ($columnTableTime == 8) {
                        $rowTableBody++;
                        $columnTableTime = 3;
                    } else {
                        $columnTableTime++;
                    }
                }
                // Export Afternoon
                $tableAfterNoon = $itemTime->getTableTimeAfterNoon();
                $columnTableTime = 3;

                foreach ($tableAfterNoon as $key => $table) {
                    if ($table != null) {
                        $sheetSelect->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, $table->tenmonhoc . "-" . $table->hovaten);
                    } else {
                        $sheetSelect->setCellValueByColumnAndRow($columnTableTime, $rowTableBody, "");
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
            $this->saveExcel($sheet, $item->locationName);
        }

        return $arrFile;
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


    private function exportTKBSchoolTwoColumn($sheetTKBSchool, $sheet, $fullname, $startMonth, $endMonth, $week)
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
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
                        ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
                        ->join('danhsachgv', 'danhsachgv.id', 'thoikhoabieu.magiaovien')
                        ->select('monhoc.tenmonhoc', 'monhoc.monhocviettat', 'danhsachgv.bidanh', 'thoikhoabieu.malop', 'thoikhoabieu.tiet')
                        ->first();

                    if ($table != null) {
                        $item = null;
                        if ($fullname == true) {
                            $item = new TableTime($day, $session, $table->tenmonhoc, $table->bidanh);
                        } else {
                            $item = new TableTime($day, $session, $table->monhocviettat, $table->bidanh);
                        }
                        array_push($tableTime, $item);
                    } else {
                        array_push($tableTime, null);
                    }
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

    private function exportTKBClass($sheetTKBClass, $sheet, $listClassRoom, $startMonth, $endMonth, $week)
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
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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

    private function exportTKBTeachers($sheetTKBClass, $sheet, $listTeacher, $startMonth, $endMonth, $week)
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
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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
                        ->where('tuan', $week)
                        ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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
        // foreach ($listTeacher as $teacher) {
        //     $arrMorning = array();
        //     $arrAfternoon = array();
        //     for ($day = Day::$MONDAY; $day < Day::$SUNDAY; $day++) {
        //         // Get tabletime morning
        //         $ss = 1;
        //         for ($sessionMorning = Day::$MORNING; $sessionMorning < Day::$MIDDAY; $sessionMorning++) {
        //             $table = thoikhoabieu::where('thu', $day)
        //                 ->where('buoi', 0)
        //                 ->where('tiet', $ss)
        //                 ->where('magiaovien', $teacher->id)
        //                 ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
        //                 ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
        //                 ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
        //                 ->first();
        //             array_push($arrMorning, $table);
        //             $ss++;
        //         }

        //         $ss = 1;
        //         // Get tabletime afternoon
        //         for ($sessionAfterNoon = Day::$MIDDAY; $sessionAfterNoon < Day::$AFTERNOON; $sessionAfterNoon++) {
        //             $table = thoikhoabieu::where('thu', $day)
        //                 ->where('buoi', 1)
        //                 ->where('tiet', $ss)
        //                 ->where('magiaovien', $teacher->id)
        //                 ->join('monhoc', 'monhoc.id', 'thoikhoabieu.mamonhoc')
        //                 ->join('danhsachlophoc', 'danhsachlophoc.id', 'thoikhoabieu.malop')
        //                 ->select('monhoc.tenmonhoc', 'danhsachlophoc.tenlop')
        //                 ->first();
        //             array_push($arrAfternoon, $table);
        //             $ss++;
        //         }
        //     }
        //     $itemTeacher = new TableTimeTypeTwo($teacher->name, $arrMorning, $arrAfternoon);
        //     array_push($tableTime, $itemTeacher);
        // }
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

        // Export table
        $rowName = 7;
        $columnName = 2;
        $columnTableTime = 4;
        $rowTime = 7;
        foreach ($tableTime as $key => $item) {
            // set Name to cell Name
            $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnName, $rowName, $item->getTeacher());
            // Render TableTime Morning
            $tableMorning = $item->getTableTimeMorning();
            $tableAfterNoon = $item->getTableTimeAfterNoon();
            $indexTable = 0;
            while ($columnTableTime < 31) {

                $itemTable = $tableMorning[$indexTable];
                $itemTableAfternoon = $tableAfterNoon[$indexTable];
                if ($itemTable != null) {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime, $itemTable->tenmonhoc . "-" . $itemTable->tenlop);
                } else {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime, "");
                }
                if ($itemTableAfternoon != null) {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime + 1, $itemTableAfternoon->tenmonhoc . "-" . $itemTableAfternoon->tenlop);
                } else {
                    $sheetTKBTeacherTypeTwo->setCellValueByColumnAndRow($columnTableTime, $rowTime + 1, "");
                }
                if ($indexTable < count($tableMorning)) {
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

    private function exportTKBGroup($spreadsheet, $startMonth, $endMonth, $week)
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
                            ->where('tuan', $week)
                            ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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
                            ->where('tuan', $week)
                            ->whereBetween('thoikhoabieu.created_at', [$startMonth, $endMonth])
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
}
