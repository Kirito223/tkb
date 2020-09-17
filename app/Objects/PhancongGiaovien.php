<?php

namespace App\Objects;

class PhancongGiaovien
{
    private $danhsachphancong;
    private $danhsachGiaovien;
    private $danhsachmonhoc;
    private $danhsachlop;
    private $sotietmonhoc;
    public function __construct($danhsachphancong, $danhsachGiaovien, $danhsachmonhoc, $danhsachlop, $sotietmonhoc)
    {
        $this->danhsachGiaovien = $danhsachGiaovien;
        $this->danhsachphancong = $danhsachphancong;
        $this->danhsachmonhoc = $danhsachmonhoc;
        $this->danhsachlop = $danhsachlop;
        $this->sotietmonhoc = $sotietmonhoc;
    }

    public function jsonSeriable()
    {
        return get_object_vars($this);
    }
}