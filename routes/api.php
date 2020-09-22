<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('phanconggiaovien/all', 'khaibao\PhanconggiaovienDayController@all');

Route::get('phanconggiaovien/laydanhsachMonPhancong/{monhoc}', 'khaibao\PhanconggiaovienDayController@laydanhsachMonPhancong');

Route::post('phanconggiaovien/luu', 'khaibao\PhanconggiaovienDayController@store');

Route::get('phanconggiaovien/xoaToanBoPhanmonGiaovien/{idGiaovien}', 'khaibao\PhanconggiaovienDayController@xoaToanBoPhanmonGiaovien');

Route::post('phanconggiaovien/xoaPhancongchuyenmonTaimon', 'khaibao\PhanconggiaovienDayController@xoaPhancongchuyenmonTaimon');

Route::get('phanconggiaovien/xuatBangphancong', 'khaibao\PhanconggiaovienDayController@xuatBangphancong');



# so tiet trong ngay
Route::get('sotietngay/getdata', 'rangbuoc\rangbuocController@getData');
Route::post('sotietngay/savedata', 'rangbuoc\rangbuocController@saveData');
# so tiet trong buoi

Route::get('sotietbuoi/getdata', 'rangbuoc\rangbuocController@getDataBuoi');
Route::post('sotietbuoi/savedata', 'rangbuoc\rangbuocController@saveDataBuoi');

// Xuat excel

Route::get('xuattkb/listTeacher', 'export\exportExcelController@listTeacher');
Route::post('xuattkb/export', 'export\exportExcelController@export');
Route::get('xuattkb/export/{tkbNo}', 'export\exportExcelController@downLoadTableTime');
