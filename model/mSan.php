<?php
    include_once("mKetNoi.php");
    class mSan{
        public function SelectALLSan(){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT sanbong.*, loaisan.TenLoai
                            FROM sanbong JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function Select1San($idsan){
            $p = new mKetNoi();
            $con=$p->moKetNoi();
            if($con){
                $truyvan = "SELECT sanbong.*, coso.*, loaisan.*  ,giathue.* ,nhanvien.*
                            FROM sanbong 
                            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                            JOIN giathue ON giathue.MaLoaiSanBong = loaisan.MaLoaiSan
                            JOIN nhanvien ON nhanvien.MaNhanVien = sanbong.MaNhanVien
                            WHERE MaSanBong = '$idsan'";
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            }else{
                return false;
            }
        }

        public function SelectSanbyType($idloai){
            $p = new mKetNoi();
            $con = $p->moKetNoi();
            if ($con) {
                $truyvan = "SELECT sanbong.*, loaisan.TenLoai 
                            FROM sanbong 
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan 
                            WHERE sanbong.MaLoaiSan = '$idloai'";
                            
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con);
                return $kq;
            } else {
                return false;
            }
        }
        
        // public function SelectSanbyName($tenSanBong){
        //     $p = new mKetNoi();
        //     $con = $p->moKetNoi();
        //     if ($con) {
        //         $truyvan = "SELECT sanbong.*, loaisan.TenLoai 
        //                     FROM sanbong 
        //                     JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan 
        //                     WHERE sanbong.MaLoaiSan = '$idloai'";
                            
        //         $kq = mysqli_query($con, $truyvan);
        //         $p->dongKetNoi($con);
        //         return $kq;
        //     } else {
        //         return false;
        //     }
        // }
        public function SelectSanByNameAndAddress($name, $diachi) {
            $p = new mKetNoi();
            $con = $p->moKetNoi();
            
            if ($con) {
                // Tạo truy vấn cơ bản
                $truyvan = "SELECT sanbong.*, coso.DiaChi
                            FROM sanbong 
                            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                            WHERE 1=1"; 
        
                if (!empty($name)) {
                    $name = mysqli_real_escape_string($con, $name);
                    $truyvan .= " AND sanbong.TenSanBong LIKE '%$name%'";
                }
        
                if (!empty($diachi)) {
                    $diachi = mysqli_real_escape_string($con, $diachi); 
                    $truyvan .= " AND coso.DiaChi LIKE '%$diachi%'";
                }
        
                $kq = mysqli_query($con, $truyvan);
                $p->dongKetNoi($con); 
                return $kq; 
            } else {
                return false; 
            }
        }   

        public function selectALLSanBongByMaChuSan($maChuSan) {
            $p = new mKetNoi();
            $con = $p->moKetNoi();
            $sql = "SELECT sanbong.* ,coso.* , chusan.*,loaisan.* ,nhanvien.TenNhanVien
            FROM sanbong
            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
            JOIN chusan ON coso.MaChuSan = chusan.MaChuSan
            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
            JOIN nhanvien ON sanbong.MaNhanVien = nhanvien.MaNhanVien
            WHERE chusan.MaChuSan = $maChuSan;";

            $kq = mysqli_query($con, $sql);
            $p->dongKetNoi($con);
            return $kq; 
          }


          public function selectInfo1San($maSanBong,$maChuSan) {
            $p = new mKetNoi();
            $con = $p->moKetNoi();
                $sql = "SELECT sanbong.*, coso.*, loaisan.*  ,giathue.* ,nhanvien.*
                            FROM sanbong 
                            JOIN coso ON sanbong.MaCoSo = coso.MaCoSo
                            JOIN loaisan ON sanbong.MaLoaiSan = loaisan.MaLoaiSan
                            JOIN giathue ON giathue.MaLoaiSanBong = loaisan.MaLoaiSan
                            JOIN nhanvien ON nhanvien.MaNhanVien = sanbong.MaNhanVien
                            WHERE MaSanBong = '$maSanBong' AND nhanvien.MaChuSan = '$maChuSan';
                ";

            $kq = mysqli_query($con, $sql);
            $p->dongKetNoi($con);
            return $kq; 
          }
          
        
        public function insertSanBong($tenSanBong, $thoiGianHoatDong, $moTa, $hinhAnh, $maNhanVien, $maLoaiSan, $maCoSo) {
            $p = new mKetNoi(); // Đảm bảo class mKetNoi có phương thức moKetNoi() và dongKetNoi()
            $con = $p->moKetNoi();
        
            // Chuẩn bị câu truy vấn SQL
            $truyvan = "INSERT INTO sanbong (TenSanBong, ThoiGianHoatDong, MoTa, HinhAnh, MaNhanVien, MaLoaiSan, MaCoSo) 
                        VALUES (N'$tenSanBong', N'$thoiGianHoatDong', N'$moTa', N'$hinhAnh', '$maNhanVien', '$maLoaiSan', '$maCoSo')";
        
            // Thực thi truy vấn
            $kq = mysqli_query($con, $truyvan);
        
            // Đóng kết nối
            $p->dongKetNoi($con);
        
            // Trả về kết quả
            return $kq;
        }

        // public function updateSanBong($maSanBong, $tenSanBong, $loaiSan, $giaSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan,$macoso) {
        //     $p = new mKetNoi(); // Đảm bảo class mKetNoi có phương thức moKetNoi() và dongKetNoi()
        //     $con = $p->moKetNoi();
        //     $sql = "UPDATE `sanbong`
        //             SET 

        //             `TenSanBong` = '$tenSanBong',
        //             `ThoiGianHoatDong` = '$thoiGianHoatDong',
        //             `MoTa` = '$moTaSan',
        //             `HinhAnh` = '$anhSan',
        //             `MaNhanVien` = '$maNhanVien',
        //             `MaLoaiSan` = '$loaiSan',
        //             `MaCoSo` = '$macoso'
        //             WHERE `MaSanBong` = '$maSanBong';
        //             ";
        //     $stmt = $this->$con->prepare($sql);

        //     return $stmt->execute();
        // }

        public function updateSanBong($maSanBong, $tenSanBong, $loaiSan, $giaSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $anhSan, $macoso) {
            $p = new mKetNoi(); // Đảm bảo class mKetNoi có phương thức moKetNoi() và dongKetNoi()
            $con = $p->moKetNoi(); // Mở kết nối cơ sở dữ liệu
        
            // Chuẩn bị câu lệnh SQL với tham số binding để bảo vệ khỏi SQL injection
            $sql = "UPDATE `sanbong`
                    SET `TenSanBong` = ?, 
                        `ThoiGianHoatDong` = ?, 
                        `MoTa` = ?, 
                        `HinhAnh` = ?, 
                        `MaNhanVien` = ?, 
                        `MaLoaiSan` = ?, 
                        `MaCoSo` = ? 
                    WHERE `MaSanBong` = ?";
        
            // Chuẩn bị truy vấn SQL
            if ($stmt = $con->prepare($sql)) {
                // Gán các tham số vào câu lệnh chuẩn bị
                $stmt->bind_param("sssssiss", $tenSanBong, $thoiGianHoatDong, $moTaSan, $anhSan, $maNhanVien, $loaiSan, $macoso, $maSanBong);
        
                // Thực thi câu lệnh
                $result = $stmt->execute();
        
                // Đóng câu lệnh và kết nối
                $stmt->close();
                $con->close();
        
                return $result; // Trả về kết quả của câu lệnh (true nếu thành công, false nếu có lỗi)
            } else {
                // Nếu không thể chuẩn bị câu lệnh, trả về false
                return false;
            }
        }
        


        public function deleteSanBong($masanbong){
            $p = new mKetNoi();
            $truyvan = "DELETE FROM `sanbong` WHERE MaSanBong = $masanbong";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi($con);
            return $kq;
          }

        
        

        
    }
?>