<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monhoc extends Model
{
	protected $table = 'monhoc';

	public function tochuyenmon()
	{
		return $this->belongsTo('App\tochuyenmon','matochuyenmon','id');
	}


	public function danhsachlophoc(){
		// return $this->hasMany('App\danhsachlophoc','malop');
		return $this->belongsTo('App\danhsachlophoc','malop','id');

		// return $this->belongsToMany('App\danhsachlophoc','phancongchuyenmon','mamonhoc','malop');
		// ->withPivot('magiaovien');
	}

	public function danhsachlophocrb(){
		return $this->belongsToMany('App\danhsachlophoc','rangbuoctietcodinh','mamonhoc','malop');

	// protected $hidden = ['pivot'];
	}
}
