<?php
    include_once("mKetNoi.php");
    class mCoSo{
        public function SelectCosoByMaChuSan($machusan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT * FROM `coso` WHERE MaChuSan = $machusan";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

    }
?>