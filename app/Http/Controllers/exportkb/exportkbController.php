<?php

namespace App\Http\Controllers\exportkb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class exportkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom'])->addStyles(['style-macdinh'])->removeStyles(['style-dev'])->removeScripts(['js-dev']);
		return view('exportkb.index');
	}
}
