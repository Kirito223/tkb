<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
	public $timestamps = false;

	public function permissions()
	{
		return $this->belongsToMany('App\permissions');
	}
}
