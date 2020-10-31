<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class giaovien_chuyenmon extends Model
{
	protected $table = 'giaovien_chuyenmon';

	public function danhsachgv()
	{
		return $this->belongsTo('App\danhsachgv', 'magiaovien', 'id');
	}
	public function monhoc()
	{
		return $this->hasMany('App\monhoc', 'id','mamonhoc');
	}
	public function tochuyenmon()
	{
		return $this->hasMany('App\tochuyenmon', 'id','matochuyenmon');
	}
	public function mucrangbuoc()
	{
		return $this->hasMany('App\mucrangbuoc', 'id','mucrangbuoc');
	}
		public function danhgiagv()
	{
		return $this->belongsTo('App\danhgiagv', 'magiaovien','magiaovien');
	}
}
