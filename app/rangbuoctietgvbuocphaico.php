<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rangbuoctietgvbuocphaico extends Model
{
   	protected $table = 'rangbuoctietgvbuocphaico';

   	public function danhsachgv()
	{
		return $this->belongsTo('App\danhsachgv', 'magiaovien', 'id');
	}

	public function mucrangbuoc()
	{
		return $this->belongsTo('App\mucrangbuoc', 'mamucrangbuoc', 'id');
	}

}
