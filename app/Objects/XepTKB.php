<?php

namespace App\Objects;

class XepTKB
{
    private $giaovien;
    private $monhoc;
    private $lophoc;
    private $danhsachrangbuoc;
    private $tiethoc;
    private $tietnghigiaovien;
    private $tietghep;
    private $sotietmonhoc;
    private $phonghoc;
    private $phong_mon_lop;
    private $phancongchuyenmon;
    private $giaovienmonlop;
    private $giaovienchuyenmon;
    private $tietcodinh;
	private $sotiettrongbuoi;
	private $rangbuocdangkybuoitietnghigv;
	private $caphoc;
    public function __construct($giaovien, $monhoc, $lophoc, $danhsachrangbuoc, $tiethoc, $tietnghigiaovien, $tietghep, $sotietmonhoc, $phonghoc, $phong_mon_lop, $phancongchuyenmon, $giaovienmonlop, $giaovienchuyenmon,$tietcodinh,$sotiettrongbuoi,$rangbuocdangkybuoitietnghigv,$caphoc)
    {
        $this->giaovien = $giaovien;
        $this->monhoc = $monhoc;
        $this->lophoc = $lophoc;
        $this->danhsachrangbuoc = $danhsachrangbuoc;
        $this->tiethoc = $tiethoc;
        $this->tietnghigiaovien = $tietnghigiaovien;
        $this->tietghep = $tietghep;
        $this->sotietmonhoc = $sotietmonhoc;
        $this->phonghoc = $phonghoc;
        $this->phong_mon_lop = $phong_mon_lop;
        $this->phancongchuyenmon = $phancongchuyenmon;
        $this->giaovienmonlop = $giaovienmonlop;
        $this->giaovienchuyenmon = $giaovienchuyenmon;
        $this->tietcodinh = $tietcodinh;
		$this->sotiettrongbuoi=$sotiettrongbuoi;
		$this->rangbuocdangkybuoitietnghigv=$rangbuocdangkybuoitietnghigv;
		$this->caphoc=$caphoc;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
