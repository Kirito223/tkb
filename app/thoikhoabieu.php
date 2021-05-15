<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class thoikhoabieu extends Model
{
    protected $table = 'thoikhoabieu';


    public function giaovien()
    {
        return $this->belongsTo(danhsachgv::class, 'magiaovien');
    }

    public function lophoc()
    {
        return $this->belongsTo(danhsachlophoc::class, 'malop');
    }
    public function monhoc()
    {
        return $this->belongsTo(monhoc::class, 'mamonhoc');
    }
}
