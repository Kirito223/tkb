<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function(){
	Route::match(['get','post'],'login',['as' => 'login' , 'uses' => 'admin\LoginController@index']);//match sử dụng cho get với post
	Route::post('postlogin', [ 'as' => 'postlogin', 'uses' => 'admin\LoginController@postLogin']);
});




Route::group(['middleware' => 'auth'], function(){
	Route::match(['get','post'],'/','HomeController@index');//match sử dụng cho get với post 
	Route::get('getlogout', [ 'as' => 'getlogout', 'uses' => 'admin\LoginController@getLogout']);

//quản lý tài khoản
	Route::get('taikhoan','admin\AdminController@viewtaikhoan');
	Route::get('getlisttaikhoan','admin\AdminController@getlisttaikhoan');
	Route::get('getlisthuyen','admin\AdminController@getlisthuyen');
	Route::get('getlisttruong','admin\AdminController@getlisttruong');
	Route::get('getlistquyen','admin\AdminController@getlistquyen');
	Route::get('getlistxa','admin\AdminController@getlistxa');
	Route::post('addtaikhoan','admin\AdminController@addtaikhoan');
	Route::post('updatetaikhoan','admin\AdminController@updatetaikhoan');
	Route::post('deltaikhoan','admin\AdminController@deltaikhoan');
	Route::post('updatepassword','admin\AdminController@updatepassword');
	Route::post('resetpassword','admin\AdminController@resetpassword');
	Route::get('phanquyen','admin\AdminController@viewphanquyen');
	Route::post('addphanquyen','admin\AdminController@addphanquyen');
	Route::post('updatephanquyen','admin\AdminController@updatephanquyen');
	Route::post('delphanquyen','admin\AdminController@delphanquyen');
		//huyện
	Route::get('huyen','admin\AdminController@viewhuyen');
	Route::post('addhuyen','admin\AdminController@addhuyen');
	Route::post('updatehuyen','admin\AdminController@updatehuyen');
	Route::post('delhuyen','admin\AdminController@delhuyen');
	//xã
	Route::get('xa','admin\AdminController@viewxa');
	Route::post('addxa','admin\AdminController@addxa');
	Route::post('updatexa','admin\AdminController@updatexa');
	Route::post('delxa','admin\AdminController@delxa');
	//trường
	Route::get('truong','admin\AdminController@viewtruong');
	Route::post('addtruong','admin\AdminController@addtruong');
	Route::post('updatetruong','admin\AdminController@updatetruong');
	Route::post('deltruong','admin\AdminController@deltruong');
	
	


//xeptkb
	Route::get('xeptbk/dulieu', 'xeptkb\xeptkbController@nguontainguyen');
	Route::get('xeptkb','xeptkb\xeptkbController@index');
	Route::post('uptcrangbuoc','xeptkb\xeptkbController@uptcrangbuoc');

//tinhchinh
	Route::get('tinhchinh','tinhchinh\tinhchinhController@index');


//xemtkb
	Route::get('xemtkb','xemtkb\xemtkbController@index');

//tro giup
	Route::get('exportkb','exportkb\exportkbController@index');

//khaibao
	//import excel
	Route::post('importexcelbangphancongtkb','khaibao\khaibaoController@importexcelbangphancongtkb');


	Route::get('khaibao','khaibao\khaibaoController@index');
	//danh sách giáo viên
	Route::get('getdanhsachgv','khaibao\khaibaoController@getdanhsachgv');
	Route::post('adddanhsachgv','khaibao\khaibaoController@adddanhsachgv');
	Route::post('updatedanhsachgv','khaibao\khaibaoController@updatedanhsachgv');
	Route::post('deldanhsachgv','khaibao\khaibaoController@deldanhsachgv');
	Route::post('deltoanbodanhsachgv','khaibao\khaibaoController@deltoanbodanhsachgv');
	//danh sách môn học
	Route::get('getdanhsachmonhoc','khaibao\khaibaoController@getdanhsachmonhoc');
	Route::post('adddanhsachmonhoc','khaibao\khaibaoController@adddanhsachmonhoc');
	Route::post('updatedanhsachmonhoc','khaibao\khaibaoController@updatedanhsachmonhoc');
	Route::post('deldanhsachmonhoc','khaibao\khaibaoController@deldanhsachmonhoc');
	Route::post('deltoanbodanhsachmonhoc','khaibao\khaibaoController@deltoanbodanhsachmonhoc');

	//danh sách lớp học
	Route::get('getdanhsachlophoc','khaibao\khaibaoController@getdanhsachlophoc');
	Route::post('updatethutuhienthi','khaibao\khaibaoController@updatethutuhienthi');
	Route::post('adddanhsachlophoc','khaibao\khaibaoController@adddanhsachlophoc');
	Route::post('updatedanhsachlophoc','khaibao\khaibaoController@updatedanhsachlophoc');
	Route::post('deldanhsachlophoc','khaibao\khaibaoController@deldanhsachlophoc');
	Route::post('deltoanbodanhsachlophoc','khaibao\khaibaoController@deltoanbodanhsachlophoc');

	// danh sách tổ chuyên môn
	Route::get('getdanhsachtochuyenmon','khaibao\khaibaoController@getdanhsachtochuyenmon');
	Route::post('adddanhsachtochuyenmon','khaibao\khaibaoController@adddanhsachtochuyenmon');
	Route::post('updatedanhsachtochuyenmon','khaibao\khaibaoController@updatedanhsachtochuyenmon');
	Route::post('deldanhsachtochuyenmon','khaibao\khaibaoController@deldanhsachtochuyenmon');
	Route::post('deltoanbodanhsachtochuyenmon','khaibao\khaibaoController@deltoanbodanhsachtochuyenmon');

	//Danh sách giáo viên của tổ chuyên môn
	Route::get('getdanhsachgvcuatochuyenmon','khaibao\khaibaoController@getdanhsachgvcuatochuyenmon');
	Route::post('adddanhsachgvcuatochuyenmonloc','khaibao\khaibaoController@adddanhsachgvcuatochuyenmonloc');
	Route::post('updatedanhsachgvcuatochuyenmonloc','khaibao\khaibaoController@updatedanhsachgvcuatochuyenmonloc');


	// danh sách phòng học bộ môn
	Route::get('getdanhsachphonghocbomon','khaibao\khaibaoController@getdanhsachphonghocbomon');
	Route::post('adddanhsachphonghocbomon','khaibao\khaibaoController@adddanhsachphonghocbomon');
	Route::post('updatedanhsachphonghocbomon','khaibao\khaibaoController@updatedanhsachphonghocbomon');
	Route::post('deldanhsachphonghocbomon','khaibao\khaibaoController@deldanhsachphonghocbomon');
	Route::post('deltoanbodanhsachphonghocbomon','khaibao\khaibaoController@deltoanbodanhsachphonghocbomon');

	//danh sách giáo viên tham gia giảng dạy
	Route::get('getdanhsachgvthamgiagiangday','khaibao\khaibaoController@getdanhsachgvthamgiagiangday');
	Route::post('updatethutuhienthigvthamgiagiangday','khaibao\khaibaoController@updatethutuhienthigvthamgiagiangday');
	Route::post('updatetrangthaigvthamgiagiangday','khaibao\khaibaoController@updatetrangthaigvthamgiagiangday');

	//chọn mon hoc
	Route::post('updatechonbuoihoc','khaibao\khaibaoController@updatechonbuoihoc');

	//chọn lop hoc
	Route::post('updatechonthlophoc','khaibao\khaibaoController@updatechonthlophoc');

	//chon to cm
	Route::post('updatechonthtocm','khaibao\khaibaoController@updatechonthtocm');

	//chon phong hoc
	Route::post('updatechonthphonghoc','khaibao\khaibaoController@updatechonthphonghoc');

	//danh sách số tiết trong buổi của mỗi lớp
	Route::get('getdanhsachsotiettrongbuoi','khaibao\khaibaoController@getdanhsachsotiettrongbuoi');
	Route::get('getdssotiettrongbuoi','khaibao\khaibaoController@getdssotiettrongbuoi');
	Route::post('updatesotiettrongbuoi','khaibao\khaibaoController@updatesotiettrongbuoi');
	Route::get('addsotiettrongbuoi','khaibao\khaibaoController@addsotiettrongbuoi');


	//danh sách số tiết ở mỗi môn của mỗi lớp
	Route::get('getdanhsachsotietmoimon','khaibao\khaibaoController@getdanhsachsotietmoimon');
	Route::post('updatesotietmoimon','khaibao\khaibaoController@updatesotietmoimon');









//rangbuoc
	Route::get('rangbuoc','rangbuoc\rangbuocController@index');
	Route::get('getlistrangbuoc','rangbuoc\rangbuocController@getlistrangbuoc');
	Route::get('getlistdanhsachrangbuoc','rangbuoc\rangbuocController@getlistdanhsachrangbuoc');

	//ràng buộc tiết cố định
	Route::get('getkhoihoc','rangbuoc\rangbuocController@getkhoihoc');
	Route::get('getrangbuoctietcodinh','rangbuoc\rangbuocController@getrangbuoctietcodinh');
	Route::post('addrangbuoctietcodinhtiethoc','rangbuoc\rangbuocController@addrangbuoctietcodinhtiethoc');
	Route::post('updaterangbuoctietcodinhtiethoc','rangbuoc\rangbuocController@updaterangbuoctietcodinhtiethoc');
	Route::post('delrangbuoctietcodinh','rangbuoc\rangbuocController@delrangbuoctietcodinh');
	

	//tiết họp của tổ
	Route::get('gettiethopcuato','rangbuoc\rangbuocController@gettiethopcuato');
	Route::post('addtiethopcuato','rangbuoc\rangbuocController@addtiethopcuato');
	Route::post('updatetiethopcuato','rangbuoc\rangbuocController@updatetiethopcuato');
	Route::post('deltiethopcuato','rangbuoc\rangbuocController@deltiethopcuato');

	//ti?t giáo viên bu?c ph?i có
	Route::get('gettietgvbuocphaico','rangbuoc\rangbuocController@gettietgvbuocphaico');
	Route::post('addrangbuoctietgvbuocphaico','rangbuoc\rangbuocController@addrangbuoctietgvbuocphaico');

	//dang ký bu?i/ti?t ngh? c?a gv
	Route::get('getdangkybuoitietnghicuagv','rangbuoc\rangbuocController@getdangkybuoitietnghicuagv');
	Route::post('addrangbuocdangkytietnghigv','rangbuoc\rangbuocController@addrangbuocdangkytietnghigv');
	Route::post('addrangbuocdangkybuoinghigv','rangbuoc\rangbuocController@addrangbuocdangkybuoinghigv');

	
	//ràng bu?c s? ti?t 5 sáng (ti?t 1 chi?u)
	Route::get('getrangbuocsotiet5sangtiet1chieu','rangbuoc\rangbuocController@getrangbuocsotiet5sangtiet1chieu');
	Route::post('updatesotiet5sangtiet1chieu','rangbuoc\rangbuocController@updatesotiet5sangtiet1chieu');


	//ràng buộc tiết tránh của môn
	Route::get('getlistrangbuoctiettranh','rangbuoc\rangbuocController@getlistrangbuoctiettranh');
	Route::post('rangbuoctiettranhchontiet','rangbuoc\rangbuocController@rangbuoctiettranhchontiet');
	Route::post('rangbuoctiettranhchonlops','rangbuoc\rangbuocController@rangbuoctiettranhchonlops');
	Route::post('rangbuoctiettranhchonlopc','rangbuoc\rangbuocController@rangbuoctiettranhchonlopc');

	//ràng buộc tránh 2 môn cùng buổi
	Route::get('getlistrangbuoctranh2moncungbuoi','rangbuoc\rangbuocController@getlistrangbuoctranh2moncungbuoi');
	Route::post('rangbuoctranh2mon','rangbuoc\rangbuocController@rangbuoctranh2mon');

	//ràng buộc cặp tiết xếp liền nhau
	Route::get('getlistrangbuoccaptietxepliennhau','rangbuoc\rangbuocController@getlistrangbuoccaptietxepliennhau');
	Route::post('updaterangbuoccaptietxepliennhau','rangbuoc\rangbuocController@updaterangbuoccaptietxepliennhau');

	// # so tiet toi da ngay
	// Route::get('sotiettoidangay','rangbuoc\rangbuocController@index');
	// # so tiet toi da ngay
	// Route::get('sotiettoidabuoi','rangbuoc\rangbuocController@indexBuoi');
});

