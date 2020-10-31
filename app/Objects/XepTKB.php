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
	private $thututiet;
	private $rangbuoccaptietxepliennhau;
    //code 12-10-2020
    private $rangbuocdangkytietnghilop;
    private $rangbuoctiettranh;
    private $rangbuocsotiet5sangtiet1chieu;
    private $rangbuoctietgvbuocphaico;
    private $rangbuoctiethopcuato;
    private $rangbuoctranh2moncungbuoi;
    private $diemtruong;
    public function __construct($giaovien, $monhoc, $lophoc, $danhsachrangbuoc, $tiethoc, $tietnghigiaovien, $tietghep, $sotietmonhoc, $phonghoc, $phong_mon_lop, $phancongchuyenmon, $giaovienmonlop, $giaovienchuyenmon,$tietcodinh,$sotiettrongbuoi,$rangbuocdangkybuoitietnghigv,$caphoc,$thututiet,$rangbuoccaptietxepliennhau,$rangbuocdangkytietnghilop,$rangbuoctiettranh,$rangbuocsotiet5sangtiet1chieu,$rangbuoctietgvbuocphaico,$rangbuoctiethopcuato,$rangbuoctranh2moncungbuoi,$diemtruong)
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
		$this->thututiet=$thututiet;
		$this->rangbuoccaptietxepliennhau=$rangbuoccaptietxepliennhau;
        $this->rangbuocdangkytietnghilop=$rangbuocdangkytietnghilop;
        $this->rangbuoctiettranh=$rangbuoctiettranh;
        $this->rangbuocsotiet5sangtiet1chieu=$rangbuocsotiet5sangtiet1chieu;
        $this->rangbuoctietgvbuocphaico=$rangbuoctietgvbuocphaico;
        $this->rangbuoctiethopcuato=$rangbuoctiethopcuato;
        $this->rangbuoctranh2moncungbuoi=$rangbuoctranh2moncungbuoi;
        $this->diemtruong=$diemtruong;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
