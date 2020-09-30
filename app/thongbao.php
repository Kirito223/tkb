<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class thongbao extends Model
{
	protected $table = 'thongbao';
	public function truong()
	{
		return $this->belongsTo('App\truong','truong_id','matruong');
	}
}
