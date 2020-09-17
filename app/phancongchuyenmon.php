<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phancongchuyenmon extends Model
{
	protected $table ='phancongchuyenmon';

	public function monhoc()
	{
		return $this->hasMany('App\monhoc','id','mamonhoc');
	}
}
