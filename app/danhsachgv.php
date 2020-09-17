<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class danhsachgv extends Model
{
	protected $table = 'danhsachgv';

	public function giaovien_chuyenmon()
	{
		return $this->hasMany('App\giaovien_chuyenmon','magiaovien');
	}
	public function phancongchuyenmon()
	{
		return $this->hasMany('App\phancongchuyenmon','magiaovien');
	}
	public function monhoc(){
		return $this->belongsToMany('App\monhoc','phancongchuyenmon','magiaovien','mamonhoc');
	}
	public function rangbuoctietgvbuocphaico()
	{
		return $this->hasMany('App\rangbuoctietgvbuocphaico','magiaovien');
	}

	public function rangbuocdangkybuoitietnghigv()
	{
		return $this->hasMany('App\rangbuocdangkybuoitietnghigv','magiaovien');
	}
	
	public function rangbuocsotiet5sangtiet1chieu()
	{
		return $this->hasMany('App\rangbuocsotiet5sangtiet1chieu','magiaovien');
	}
}
