<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class danhsachlophoc extends Model
{
	protected $table = 'danhsachlophoc';
	public function monhoc(){
		return $this->belongsToMany('App\monhoc','sotietmonhoc','malop','mamonhoc');
	}

	public function tiethoc(){
		return $this->hasMany('App\tiethoc','malop');
	}
	public function mucrangbuoc()
	{
		return $this->belongsToMany('App\mucrangbuoc','rangbuoctietcodinh','malop','mamucrangbuoc');
	}

	protected $hidden = ['pivot'];
}
