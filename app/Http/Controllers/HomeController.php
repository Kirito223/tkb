<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session; 
use App\thongbao;

class HomeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		$matruong = Session::get('matruong');
		\Assets::addScripts(['js-macdinh'])->addStyles(['style-macdinh'])->removeStyles(['style-dev'])->removeScripts(['js-dev','js-custom']);
		
		$thongbao = thongbao::where('truong_id',$matruong)->get();
		$thongbaocount = thongbao::where('trangthai',0)->where('truong_id',$matruong)->count();
		return view('home.index',compact('thongbao', 'thongbaocount'));
	}
}
