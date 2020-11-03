<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class diemtruong extends Model
{
	protected $table = 'diemtruong';


	public function danhsachlophoc()
	{
		return $this->belongsTo('App\danhsachlophoc', 'malop');
	}
}
