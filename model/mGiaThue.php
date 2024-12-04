<?php
    include_once("mKetNoi.php");
    class mGiaThue{
        public function getGiaThueSanByMaLoaiSan($maLoaiSan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT * FROM giathue WHERE MaLoaiSanBong = $maLoaiSan";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

    }
?>