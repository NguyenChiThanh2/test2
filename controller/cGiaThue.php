<?php

include_once("model/mGiaThue.php");

class cGiaThue {
    public function getGiaThueByLoaiSan($maLoaiSan) {
        $p = new mGiaThue();
        $kq =$p->getGiaThueSanByMaLoaiSan($maLoaiSan);
        if(mysqli_num_rows($kq)>0){
            return $kq;
        }else{
            return false;
        }
    }
}
?>
