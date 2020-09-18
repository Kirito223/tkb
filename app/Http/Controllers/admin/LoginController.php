<?php

namespace App\Http\Controllers\admin;

use App\tbl_admin;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Session;
use Auth;

class LoginController extends Controller
{

	public function index()
	{
		return view('admin.login');
	}

	public function postLogin(Request $request) {
	// Kiểm tra dữ liệu nhập vào
		$rules = [
			'tentaikhoan' =>'required|string',
			'password' => 'required|min:6'
		];
		$messages = [
			'tentaikhoan.required' => 'Tên đăng nhập là trường bắt buộc',
			'tentaikhoan.required' => 'Tên đăng nhập không đúng định dạng',
			'password.required' => 'Mật khẩu là trường bắt buộc',
			'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự',
		];
		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
		// Điều kiện dữ liệu không hợp lệ sẽ chuyển về trang đăng nhập và thông báo lỗi
			return redirect('login')->withErrors($validator)->withInput();
		} else {
		// Nếu dữ liệu hợp lệ sẽ kiểm tra trong csdl
			$tentaikhoan = $request->get('tentaikhoan');
			$password = $request->get('password');

			if(Auth::attempt(['tentaikhoan' => $tentaikhoan, 'password' =>$password])) {
			// Kiểm tra đúng email và mật khẩu sẽ chuyển trang
				$user = Auth::user();
				Session::put('id', $user->id);
				Session::put('tentaikhoan', $user->tentaikhoan);
				Session::put('matruong', $user->matruong);
				Session::put('mahuyen', $user->mahuyen);
				Session::put('loaixa', $user->loaixa);
				Session::put('level', $user->level);
				// Auth::login($user, true);
				return redirect('/');
			} else {
			// Kiểm tra không đúng sẽ hiển thị thông báo lỗi
				Session::flash('error', 'Tài khoản hoặc mật khẩu không đúng!');
				return back();
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		Session::put('matruong', '0');
		return redirect()->route('login');
	}

}
