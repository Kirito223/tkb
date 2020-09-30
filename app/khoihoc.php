<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khoihoc extends Model
{
    protected $table = 'khoihoc';

    public function danhsachlophoc()
	{	
		return $this->hasMany('App\danhsachlophoc','khoi','tenkhoi');
	}
}
