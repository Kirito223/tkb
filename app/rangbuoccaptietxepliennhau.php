<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rangbuoccaptietxepliennhau extends Model
{
    protected $table ='rangbuoccaptietxepliennhau';

	public function monhoc(){
		return $this->belongsTo('App\monhoc','mamonhoc');
	}
	public function lophoc(){
		return $this->belongsTo('App\danhsachlophoc','lop');
	}
}
