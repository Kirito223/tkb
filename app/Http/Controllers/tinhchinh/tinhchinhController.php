<?php

namespace App\Http\Controllers\tinhchinh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class tinhchinhController extends Controller
{
	public function index()
	{
		// \Assets::addScripts(['js-macdinh','js-custom'])->addStyles(['style-macdinh'])->removeStyles(['style-dev'])->removeScripts(['js-dev']);
		return view('tinhchinh.index');
	}
}
