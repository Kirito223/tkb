<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tiethopcuato extends Model
{
    protected $table = 'tiethopcuato';

    public function tochuyenmon()
	{
		return $this->belongsTo('App\tochuyenmon', 'matochuyenmon', 'id');
	}
}
