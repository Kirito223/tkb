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


Route::group(['middleware' => 'guest'], function () {
	Route::match(['get', 'post'], 'login', ['as' => 'login', 'uses' => 'admin\LoginController@index']); //match sử dụng cho get với post
	Route::post('postlogin', ['as' => 'postlogin', 'uses' => 'admin\LoginController@postLogin']);
});




Route::group(['middleware' => 'auth'], function () {
	Route::match(['get', 'post'], '/', 'HomeController@index'); //match sử dụng cho get với post 
	Route::get('getlogout', ['as' => 'getlogout', 'uses' => 'admin\LoginController@getLogout']);

	//quản lý tài khoản
	Route::get('taikhoan', 'admin\AdminController@viewtaikhoan');
	Route::get('getlisttaikhoan', 'admin\AdminController@getlisttaikhoan');
	Route::get('getlisthuyen', 'admin\AdminController@getlisthuyen');
	Route::get('getlisttruong', 'admin\AdminController@getlisttruong');
	Route::get('getlistquyen', 'admin\AdminController@getlistquyen');
	Route::get('getlistxa', 'admin\AdminController@getlistxa');
	Route::post('addtaikhoan', 'admin\AdminController@addtaikhoan');
	Route::post('updatetaikhoan', 'admin\AdminController@updatetaikhoan');
	Route::post('deltaikhoan', 'admin\AdminController@deltaikhoan');
	Route::post('updatepassword', 'admin\AdminController@updatepassword');
	Route::post('resetpassword', 'admin\AdminController@resetpassword');
	Route::get('phanquyen', 'admin\AdminController@viewphanquyen');
	Route::post('addphanquyen', 'admin\AdminController@addphanquyen');
	Route::post('updatephanquyen', 'admin\AdminController@updatephanquyen');
	Route::post('delphanquyen', 'admin\AdminController@delphanquyen');
	Route::post('resetdata', 'admin\AdminController@resetdata');
	//huyện
	Route::get('huyen', 'admin\AdminController@viewhuyen');
	Route::post('addhuyen', 'admin\AdminController@addhuyen');
	Route::post('updatehuyen', 'admin\AdminController@updatehuyen');
	Route::post('delhuyen', 'admin\AdminController@delhuyen');
	//xã
	Route::get('xa', 'admin\AdminController@viewxa');
	Route::post('addxa', 'admin\AdminController@addxa');
	Route::post('updatexa', 'admin\AdminController@updatexa');
	Route::post('delxa', 'admin\AdminController@delxa');
	//trường
	Route::get('truong', 'admin\AdminController@viewtruong');
	Route::post('addtruong', 'admin\AdminController@addtruong');
	Route::post('updatetruong', 'admin\AdminController@updatetruong');
	Route::post('deltruong', 'admin\AdminController@deltruong');
	//import
	//import số tiết môn học temp
	Route::get('getDssotietmonhoctemp', 'admin\AdminController@getDssotietmonhoctemp');
	Route::get('importsotietmonhoctemp', 'admin\AdminController@viewimportsotietmonhoctemp');
	Route::post('postexcelsotietmonhoctemp', 'admin\AdminController@postexcelsotietmonhoctemp');
	Route::post('addsotietmonhoc_temp', 'admin\AdminController@addsotietmonhoc_temp');
	Route::post('updatesotietmonhoc_temp', 'admin\AdminController@updatesotietmonhoc_temp');
	Route::post('delsotietmonhoc_temp', 'admin\AdminController@delsotietmonhoc_temp');
	Route::post('delsotietmonhoc_tempall', 'admin\AdminController@delsotietmonhoc_tempall');




	//xeptkb
	Route::get('api/xeptbk/dulieu', 'xeptkb\xeptkbController@nguontainguyen');
	Route::get('xeptkb', 'xeptkb\xeptkbController@index');
	Route::post('uptcrangbuoc', 'xeptkb\xeptkbController@uptcrangbuoc');
	Route::post('capnhatthoikhoabieu', 'xeptkb\xeptkbController@capnhatthoikhoabieu');

	//tinhchinh
	Route::get('tinhchinh', 'tinhchinh\tinhchinhController@index');
	Route::get('getdanhgiagvtruong', 'tinhchinh\tinhchinhController@getdanhgiagvtruong');
	Route::post('adddanhgiagv', 'tinhchinh\tinhchinhController@adddanhgiagv');
	Route::post('updatedanhgiagv', 'tinhchinh\tinhchinhController@updatedanhgiagv');
	Route::post('delldanhgiagv', 'tinhchinh\tinhchinhController@delldanhgiagv');

	//xemtkb
	Route::get('xemtkb', 'xemtkb\xemtkbController@index');
	//lấy danh sách khối,gv,lớp
	Route::get('getdskhoigvlop', 'xemtkb\xemtkbController@getdskhoigvlop');
	//lấy thời khoá biểu trường
	Route::get('gettkbtruong', 'xemtkb\xemtkbController@gettkbtruong');
	//lây danh sách lớp từ trường
	Route::get('getdslt', 'xemtkb\xemtkbController@getdslt');
	//lấy danh sách tkb giáo viên
	Route::get('gettkbgv', 'xemtkb\xemtkbController@gettkbgv');
	//lấy danh sách tkb lớp
	Route::get('gettkblop', 'xemtkb\xemtkbController@gettkblop');


	//tro giup
	Route::get('exportkb', 'exportkb\exportkbController@index');

	//khaibao
	//import excel
	Route::post('importexcelbangphancongtkb', 'khaibao\khaibaoController@importexcelbangphancongtkb');
	Route::post('importexcelsotiettrongbuoi', 'khaibao\khaibaoController@importexcelsotiettrongbuoi');


	Route::get('khaibao', 'khaibao\khaibaoController@index');
	//danh sách giáo viên
	Route::get('getdanhsachgv', 'khaibao\khaibaoController@getdanhsachgv');
	Route::post('adddanhsachgv', 'khaibao\khaibaoController@adddanhsachgv');
	Route::post('updatedanhsachgv', 'khaibao\khaibaoController@updatedanhsachgv');
	Route::post('deldanhsachgv', 'khaibao\khaibaoController@deldanhsachgv');
	Route::post('deltoanbodanhsachgv', 'khaibao\khaibaoController@deltoanbodanhsachgv');
	//danh sách môn học
	Route::get('getdanhsachmonhoc', 'khaibao\khaibaoController@getdanhsachmonhoc');
	Route::post('adddanhsachmonhoc', 'khaibao\khaibaoController@adddanhsachmonhoc');
	Route::post('updatedanhsachmonhoc', 'khaibao\khaibaoController@updatedanhsachmonhoc');
	Route::post('deldanhsachmonhoc', 'khaibao\khaibaoController@deldanhsachmonhoc');
	Route::post('deltoanbodanhsachmonhoc', 'khaibao\khaibaoController@deltoanbodanhsachmonhoc');

	//danh sách lớp học
	Route::get('getdanhsachlophoc', 'khaibao\khaibaoController@getdanhsachlophoc');
	Route::post('updatethutuhienthi', 'khaibao\khaibaoController@updatethutuhienthi');
	Route::post('adddanhsachlophoc', 'khaibao\khaibaoController@adddanhsachlophoc');
	Route::post('updatedanhsachlophoc', 'khaibao\khaibaoController@updatedanhsachlophoc');
	Route::post('deldanhsachlophoc', 'khaibao\khaibaoController@deldanhsachlophoc');
	Route::post('deltoanbodanhsachlophoc', 'khaibao\khaibaoController@deltoanbodanhsachlophoc');

	// danh sách tổ chuyên môn
	Route::get('getdanhsachtochuyenmon', 'khaibao\khaibaoController@getdanhsachtochuyenmon');
	Route::post('adddanhsachtochuyenmon', 'khaibao\khaibaoController@adddanhsachtochuyenmon');
	Route::post('updatedanhsachtochuyenmon', 'khaibao\khaibaoController@updatedanhsachtochuyenmon');
	Route::post('deldanhsachtochuyenmon', 'khaibao\khaibaoController@deldanhsachtochuyenmon');
	Route::post('deltoanbodanhsachtochuyenmon', 'khaibao\khaibaoController@deltoanbodanhsachtochuyenmon');

	//Danh sách giáo viên của tổ chuyên môn
	Route::get('getdanhsachgvcuatochuyenmon', 'khaibao\khaibaoController@getdanhsachgvcuatochuyenmon');
	Route::post('adddanhsachgvcuatochuyenmonloc', 'khaibao\khaibaoController@adddanhsachgvcuatochuyenmonloc');
	Route::post('updatedanhsachgvcuatochuyenmonloc', 'khaibao\khaibaoController@updatedanhsachgvcuatochuyenmonloc');
	Route::post('deldanhsachgvphancong', 'khaibao\khaibaoController@deldanhsachgvphancong');
	Route::post('deldanhsachgvphancongall', 'khaibao\khaibaoController@deldanhsachgvphancongall');


	// danh sách phòng học bộ môn
	Route::get('getdanhsachphonghocbomon', 'khaibao\khaibaoController@getdanhsachphonghocbomon');
	Route::post('adddanhsachphonghocbomon', 'khaibao\khaibaoController@adddanhsachphonghocbomon');
	Route::post('updatedanhsachphonghocbomon', 'khaibao\khaibaoController@updatedanhsachphonghocbomon');
	Route::post('deldanhsachphonghocbomon', 'khaibao\khaibaoController@deldanhsachphonghocbomon');
	Route::post('deltoanbodanhsachphonghocbomon', 'khaibao\khaibaoController@deltoanbodanhsachphonghocbomon');
	Route::post('addmonphonghoc', 'khaibao\khaibaoController@addmonphonghoc');
	Route::post('updatemonphonghoc', 'khaibao\khaibaoController@updatemonphonghoc');
	Route::post('dellmonphonghoc', 'khaibao\khaibaoController@dellmonphonghoc');

	//danh sách giáo viên tham gia giảng dạy
	Route::get('getdanhsachgvthamgiagiangday', 'khaibao\khaibaoController@getdanhsachgvthamgiagiangday');
	Route::post('updatethutuhienthigvthamgiagiangday', 'khaibao\khaibaoController@updatethutuhienthigvthamgiagiangday');
	Route::post('updatetrangthaigvthamgiagiangday', 'khaibao\khaibaoController@updatetrangthaigvthamgiagiangday');

	//chọn mon hoc
	Route::post('updatechonbuoihoc', 'khaibao\khaibaoController@updatechonbuoihoc');

	//chọn lop hoc
	Route::post('updatechonthlophoc', 'khaibao\khaibaoController@updatechonthlophoc');

	//chon to cm
	Route::post('updatechonthtocm', 'khaibao\khaibaoController@updatechonthtocm');

	//chon phong hoc
	Route::post('updatechonthphonghoc', 'khaibao\khaibaoController@updatechonthphonghoc');

	//danh sách số tiết trong buổi của mỗi lớp
	Route::get('getdanhsachsotiettrongbuoi', 'khaibao\khaibaoController@getdanhsachsotiettrongbuoi');
	Route::get('getdssotiettrongbuoi', 'khaibao\khaibaoController@getdssotiettrongbuoi');
	Route::post('updatesotiettrongbuoi', 'khaibao\khaibaoController@updatesotiettrongbuoi');

	Route::get('addsotiettrongbuoi', 'khaibao\khaibaoController@addsotiettrongbuoi');


	//danh sách số tiết ở mỗi môn của mỗi lớp
	Route::get('getdanhsachsotietmoimon', 'khaibao\khaibaoController@getdanhsachsotietmoimon');
	Route::post('updatesotietmoimon', 'khaibao\khaibaoController@updatesotietmoimon');
	Route::post('capnhatsotietmoimon', 'khaibao\khaibaoController@capnhatsotietmoimon');

	//diem truong
	Route::get('getdanhsachdiemtruong', 'khaibao\khaibaoController@getdanhsachdiemtruong');
	Route::post('updatediemtruong', 'khaibao\khaibaoController@updatediemtruong');
	Route::post('adddiemtruong', 'khaibao\khaibaoController@adddiemtruong');
	Route::post('deldiemtruong', 'khaibao\khaibaoController@deldiemtruong');
	Route::post('updategvdiemtruong', 'khaibao\khaibaoController@updategvdiemtruong');
	Route::post('addgvdiemtruong', 'khaibao\khaibaoController@addgvdiemtruong');
	Route::post('delgvdiemtruong', 'khaibao\khaibaoController@delgvdiemtruong');









	//rangbuoc
	Route::get('rangbuoc', 'rangbuoc\rangbuocController@index');
	Route::get('getlistrangbuoc', 'rangbuoc\rangbuocController@getlistrangbuoc');
	Route::get('getlistdanhsachrangbuoc', 'rangbuoc\rangbuocController@getlistdanhsachrangbuoc');

	//ràng buộc tiết cố định
	Route::get('getkhoihoc', 'rangbuoc\rangbuocController@getkhoihoc');
	Route::get('getrangbuoctietcodinh', 'rangbuoc\rangbuocController@getrangbuoctietcodinh');
	Route::post('addrangbuoctietcodinhtiethoc', 'rangbuoc\rangbuocController@addrangbuoctietcodinhtiethoc');
	Route::post('updaterangbuoctietcodinhtiethoc', 'rangbuoc\rangbuocController@updaterangbuoctietcodinhtiethoc');
	Route::post('delrangbuoctietcodinh', 'rangbuoc\rangbuocController@delrangbuoctietcodinh');
	Route::post('delmonhocrangbuoctietcodinh', 'rangbuoc\rangbuocController@delmonhocrangbuoctietcodinh');


	//tiết họp của tổ
	Route::get('gettiethopcuato', 'rangbuoc\rangbuocController@gettiethopcuato');
	Route::post('addtiethopcuato', 'rangbuoc\rangbuocController@addtiethopcuato');
	Route::post('updatetiethopcuato', 'rangbuoc\rangbuocController@updatetiethopcuato');
	Route::post('deltiethopcuato', 'rangbuoc\rangbuocController@deltiethopcuato');
	Route::post('deltiethopcuatoall', 'rangbuoc\rangbuocController@deltiethopcuatoall');

	//ti?t giáo viên bu?c ph?i có
	Route::get('gettietgvbuocphaico', 'rangbuoc\rangbuocController@gettietgvbuocphaico');
	Route::post('addrangbuoctietgvbuocphaico', 'rangbuoc\rangbuocController@addrangbuoctietgvbuocphaico');
	
	//dang ký bu?i/ti?t ngh? c?a gv
	Route::get('getdangkybuoitietnghicuagv', 'rangbuoc\rangbuocController@getdangkybuoitietnghicuagv');
	Route::post('addrangbuocdangkytietnghigv', 'rangbuoc\rangbuocController@addrangbuocdangkytietnghigv');
	Route::post('addrangbuocdangkybuoinghigv', 'rangbuoc\rangbuocController@addrangbuocdangkybuoinghigv');
	//rang buoc buoi nghi giao vien all
	Route::post('addrangbuocbuoinghiall', 'rangbuoc\rangbuocController@addrangbuocbuoinghiall');
	//rang buoc tiet nghi giao vien all
	Route::post('addrangbuoctietnghiall', 'rangbuoc\rangbuocController@addrangbuoctietnghiall');


	//ràng bu?c s? ti?t 5 sáng (ti?t 1 chi?u)
	Route::get('getrangbuocsotiet5sangtiet1chieu', 'rangbuoc\rangbuocController@getrangbuocsotiet5sangtiet1chieu');
	Route::post('updatesotiet5sangtiet1chieu', 'rangbuoc\rangbuocController@updatesotiet5sangtiet1chieu');


	//ràng buộc tiết tránh của môn
	Route::get('getlistrangbuoctiettranh', 'rangbuoc\rangbuocController@getlistrangbuoctiettranh');
	Route::post('rangbuoctiettranhchontiet', 'rangbuoc\rangbuocController@rangbuoctiettranhchontiet');
	Route::post('rangbuoctiettranhchonlops', 'rangbuoc\rangbuocController@rangbuoctiettranhchonlops');
	Route::post('rangbuoctiettranhchonlopc', 'rangbuoc\rangbuocController@rangbuoctiettranhchonlopc');

	//ràng buộc tránh 2 môn cùng buổi
	Route::get('getlistrangbuoctranh2moncungbuoi', 'rangbuoc\rangbuocController@getlistrangbuoctranh2moncungbuoi');
	Route::post('rangbuoctranh2mon', 'rangbuoc\rangbuocController@rangbuoctranh2mon');

	//ràng buộc cặp tiết xếp liền nhau
	Route::get('getlistrangbuoccaptietxepliennhau', 'rangbuoc\rangbuocController@getlistrangbuoccaptietxepliennhau');
	Route::post('updaterangbuoccaptietxepliennhau', 'rangbuoc\rangbuocController@updaterangbuoccaptietxepliennhau');
	Route::post('dellrangbuoccaptietxepliennhau', 'rangbuoc\rangbuocController@dellrangbuoccaptietxepliennhau');
	Route::post('dellrangbuoccaptietxepliennhauall', 'rangbuoc\rangbuocController@dellrangbuoccaptietxepliennhauall');


	// # so tiet toi da ngay
	// Route::get('sotiettoidangay','rangbuoc\rangbuocController@index');
	// # so tiet toi da ngay
	// Route::get('sotiettoidabuoi','rangbuoc\rangbuocController@indexBuoi');


	//rang buoc thu tu tiet
	Route::get('getrangbuocthututiet', 'rangbuoc\rangbuocController@getrangbuocthututiet');
	Route::post('addrangbuocthututiet', 'rangbuoc\rangbuocController@addrangbuocthututiet');
	Route::post('updaterangbuocthututiet', 'rangbuoc\rangbuocController@updaterangbuocthututiet');
	Route::post('dellrangbuocthututiet', 'rangbuoc\rangbuocController@dellrangbuocthututiet');
	Route::post('dellrangbuocthututietall', 'rangbuoc\rangbuocController@dellrangbuocthututietall');
	Route::post('updatethututietthutuhienthi', 'rangbuoc\rangbuocController@updatethututietthutuhienthi');


	//rang buoc tiet nghi lop 
	Route::get('getrangbuoctietnghilop', 'rangbuoc\rangbuocController@getrangbuoctietnghilop');
	Route::post('addrangbuoctietnghilop', 'rangbuoc\rangbuocController@addrangbuoctietnghilop');
	Route::post('updaterangbuoctietnghilop', 'rangbuoc\rangbuocController@updaterangbuoctietnghilop');
	Route::post('dellrangbuoctietnghilop', 'rangbuoc\rangbuocController@dellrangbuoctietnghilop');
	Route::post('dellrangbuoctietnghilopall', 'rangbuoc\rangbuocController@dellrangbuoctietnghilopall');
	Route::post('addtietnghilopmulti', 'rangbuoc\rangbuocController@addtietnghilopmulti');

	//tài khoản trường
	Route::get('taikhoantruong', 'taikhoantruong\taiKhoantruongController@viewtaikhoantruong');
	Route::get('getlisttaikhoantruong', 'taikhoantruong\taiKhoantruongController@getlisttaikhoantruong');
	Route::post('updatepasswordtruong', 'taikhoantruong\taiKhoantruongController@updatepasswordtruong');


	// tài khoản tổng hợp

	// xem thời khoá biểu
	Route::get('xemthoikhoabieu', 'tonghop\tonghopController@xemthoikhoabieu');
	// lấy ds trường
	Route::get('getdstruong', 'tonghop\tonghopController@getdstruong');
	//lấy thời khoá biểu trường
	Route::get('getthoikhoabieutruong', 'tonghop\tonghopController@getthoikhoabieutruong');
	//lây danh sách lớp từ trường
	Route::get('getdsloptruong', 'tonghop\tonghopController@getdsloptruong');
	//lấy danh sách tkb giáo viên
	Route::get('getthoikhoabieugv', 'tonghop\tonghopController@getthoikhoabieugv');
	//lấy danh sách tkb lớp
	Route::get('getthoikhoabieulop', 'tonghop\tonghopController@getthoikhoabieulop');

	//thống kê
	Route::get('thongke', 'tonghop\tonghopController@thongke');
	//lấy ds gv phân công 
	Route::get('getdsgvpcgd', 'tonghop\tonghopController@getdsgvpcgd');

	//theo dõi
	// biến động tkb
	Route::get('theodoibiendongtkb', 'tonghop\tonghopController@theodoibiendongtkb');
	// báo cáo đơn vị
	Route::get('theodoibaocaodonvi', 'tonghop\tonghopController@theodoibaocaodonvi');
	//lấy danh sách báo cáo
	Route::get('getdsbaocaodonvi', 'tonghop\tonghopController@getdsbaocaodonvi');
	//cập nhật trạng thái xem báo cáo đơn vị
	Route::post('updatetrangthaixembaocaodonvi', 'tonghop\tonghopController@updatetrangthaixembaocaodonvi');
	// đánh giá giáo viên
	Route::get('theodoidanhgiagiaovien', 'tonghop\tonghopController@theodoidanhgiagiaovien');
	//lấy danh sách đánh giá giáo viên
	Route::get('getdanhgiagv', 'tonghop\tonghopController@getdanhgiagv');
	//lấy danh sách thời khoá biểu giáo viên theo thời gian
	Route::get('getthoikhoabieugvtime', 'tonghop\tonghopController@getthoikhoabieugvtime');
	//lấy danh sách thời khoá biểu lớp theo thời gian
	Route::get('getthoikhoabieuloptime', 'tonghop\tonghopController@getthoikhoabieuloptime');

	//thông báo	
	Route::get('thongbao', 'tonghop\tonghopController@thongbao');
	//lấy ds thông báo
	Route::get('getdsthongbao', 'tonghop\tonghopController@getdsthongbao');
	//thêm mới thông báo
	Route::post('addthongbao', 'tonghop\tonghopController@addthongbao');
	//Cập nhật thông báo
	Route::post('updatethongbao', 'tonghop\tonghopController@updatethongbao');
	//Xoá thông báo
	Route::post('delthongbao', 'tonghop\tonghopController@delthongbao');
	//Gửi thông báo
	Route::post('sendthongbao', 'tonghop\tonghopController@sendthongbao');
	//Thu hồi thông báo
	Route::post('thuhoithongbao', 'tonghop\tonghopController@thuhoithongbao');










	//tro giup
	Route::get('exportkb', 'exportkb\exportkbController@index');

	Route::get('qrcode', 'rangbuoc\rangbuocController@test');
	//lấy dah sách báo cáo
	Route::get('getdsbaocao', 'exportkb\exportkbController@getdsbaocao');
	//thêm mới báo cáo
	Route::post('addbaocao', 'exportkb\exportkbController@addbaocao');
	//cập nhật báo cáo
	Route::post('updatebaocao', 'exportkb\exportkbController@updatebaocao');
	//xoá báo cáo
	Route::post('delbaocao', 'exportkb\exportkbController@delbaocao');
	//gửi báo cáo
	Route::post('sendbaocao', 'exportkb\exportkbController@sendbaocao');
	//gửi báo cáo
	Route::post('thuhoibaocao', 'exportkb\exportkbController@thuhoibaocao');



	// tài khoản tổng hợp

	// xem thời khoá biểu
	Route::get('xemthoikhoabieu', 'tonghop\tonghopController@xemthoikhoabieu');
	// lấy ds trường
	Route::get('getdstruong', 'tonghop\tonghopController@getdstruong');
	//lấy thời khoá biểu trường
	Route::get('getthoikhoabieutruong', 'tonghop\tonghopController@getthoikhoabieutruong');
	//lây danh sách lớp từ trường
	Route::get('getdsloptruong', 'tonghop\tonghopController@getdsloptruong');
	//lấy danh sách tkb giáo viên
	Route::get('getthoikhoabieugv', 'tonghop\tonghopController@getthoikhoabieugv');
	//lấy danh sách tkb lớp
	Route::get('getthoikhoabieulop', 'tonghop\tonghopController@getthoikhoabieulop');

	//thống kê
	Route::get('thongke', 'tonghop\tonghopController@thongke');
	//lấy ds gv phân công 
	Route::get('getdsgvpcgd', 'tonghop\tonghopController@getdsgvpcgd');

	//theo dõi
	// biến động tkb
	Route::get('theodoibiendongtkb', 'tonghop\tonghopController@theodoibiendongtkb');
	// báo cáo đơn vị
	Route::get('theodoibaocaodonvi', 'tonghop\tonghopController@theodoibaocaodonvi');
	//lấy danh sách báo cáo
	Route::get('getdsbaocaodonvi', 'tonghop\tonghopController@getdsbaocaodonvi');
	//cập nhật trạng thái xem báo cáo đơn vị
	Route::post('updatetrangthaixembaocaodonvi', 'tonghop\tonghopController@updatetrangthaixembaocaodonvi');
	// đánh giá giáo viên
	Route::get('theodoidanhgiagiaovien', 'tonghop\tonghopController@theodoidanhgiagiaovien');
	//lấy danh sách đánh giá giáo viên
	Route::get('getdanhgiagv', 'tonghop\tonghopController@getdanhgiagv');
	//lấy danh sách thời khoá biểu giáo viên theo thời gian
	Route::get('getthoikhoabieugvtime', 'tonghop\tonghopController@getthoikhoabieugvtime');
	//lấy danh sách thời khoá biểu lớp theo thời gian
	Route::get('getthoikhoabieuloptime', 'tonghop\tonghopController@getthoikhoabieuloptime');

	//thông báo	
	Route::get('thongbao', 'tonghop\tonghopController@thongbao');
	//lấy ds thông báo
	Route::get('getdsthongbao', 'tonghop\tonghopController@getdsthongbao');
	//thêm mới thông báo
	Route::post('addthongbao', 'tonghop\tonghopController@addthongbao');
	//Cập nhật thông báo
	Route::post('updatethongbao', 'tonghop\tonghopController@updatethongbao');
	//Xoá thông báo
	Route::post('delthongbao', 'tonghop\tonghopController@delthongbao');
	//Gửi thông báo
	Route::post('sendthongbao', 'tonghop\tonghopController@sendthongbao');


	//thông báo	pgd gửi trường
	Route::get('thongbaotruong', 'thongbao\thongbaoController@thongbaotruong');
	//lấy ds thông báo
	Route::get('getdsthongbaotruong', 'thongbao\thongbaoController@getdsthongbaotruong');
	//cập nhật trạng thái xem thông báo của ogd
	Route::post('updatetrangthaixemthongbaotruong', 'thongbao\thongbaoController@updatetrangthaixemthongbaotruong');
	Route::post('uploadFileKysos', "tonghop\tonghopController@uploadFileKyso");
});
