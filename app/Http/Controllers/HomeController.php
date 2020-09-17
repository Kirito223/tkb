<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session; 

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
		return view('home.index');
	}
}
