<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rangbuoctiethopcuato extends Model
{
    protected $table = 'rangbuoctiethopcuato';

    public function tochuyenmon()
	{
		return $this->belongsTo('App\tochuyenmon', 'matochuyenmon', 'id');
	}
}
