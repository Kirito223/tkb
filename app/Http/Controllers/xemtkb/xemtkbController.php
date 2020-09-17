<?php

namespace App\Http\Controllers\xemtkb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class xemtkbController extends Controller
{
	public function index()
	{
		\Assets::addScripts(['js-macdinh','js-custom','js-dev'])->addStyles(['style-macdinh','style-dev'])->removeStyles(['style-datatable'])->removeScripts(['js-datatable']);
		return view('xemtkb.index');
	}

}
