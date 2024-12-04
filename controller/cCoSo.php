<?php
include_once("model/mCoSo.php");

    class cCoSo{
        public function GetCoSoByMaChuSan($maChuSan){
            $p = new mCoSo();
            $kq =$p->SelectCosoByMaChuSan($maChuSan);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
    

        
    }
?>