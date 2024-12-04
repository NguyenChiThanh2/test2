<?php 
      include_once("mKetNoi.php");
      class ModelChuSan {
        public function selectAllNhanVien() {
            $p = new mKetNoi();
            $con = $p->moKetNoi();
            $sql = "select * from nhanvien";
            $kq = $con->query($sql);
            $p->dongKetNoi($con);
            return $kq;
        }

        public function selectALLNhanVienByMaChuSan($maChuSan) {
          $p = new mKetNoi();
          $con = $p->moKetNoi();
          $sql = "select * from nhanvien where MaChuSan = $maChuSan";
          $kq = mysqli_query($con, $sql);
          $p->dongKetNoi($con);
          return $kq; 
        }
        
        public function select01NhanVien($maNV){
          $p = new mKetNoi();
          $con = $p->moKetNoi();
          $sql = "select * from nhanvien where MaNhanVien = '$maNV'";
          $kq = mysqli_query($con, $sql);
          $p->dongKetNoi($con);
          return $kq;
        }

        public function selectALLEmailsAndPhones(){
          $p = new mKetNoi();
          $con = $p->moKetNoi();
          $sql = "select Email, SDT from nhanvien";
          $kq = mysqli_query($con, $sql);
          $p->dongKetNoi($con);
          return $kq;
        }

        public function insertNhanVien($tenNV, $email, $sdt, $diaChi, $sex, $pass, $maChuSan){
          $p = new mKetNoi();
          $con = $p->moKetNoi();
          // Mã hóa mật khẩu bằng MD5
          $hashedPass = md5($pass);
          // Truy vấn SQL
          $truyvan = "insert into nhanvien(TenNhanVien, Email, SDT, DiaChi, GioiTinh, MatKhau, MaChuSan) 
                      values (N'$tenNV', N'$email', N'$sdt', N'$diaChi', N'$sex', '$hashedPass', '$maChuSan')";
          $kq = mysqli_query($con, $truyvan);
          $p->dongKetNoi($con);
      
          return $kq;
        }
    
        public function updateNhanVien($maNV, $tenNV, $email, $sdt, $diaChi, $sex, $pass, $maChuSan){
          $p = new mKetNoi();
          $con = $p->moKetNoi();
          // Lấy mật khẩu hiện tại từ cơ sở dữ liệu
          $query = "select MatKhau from nhanvien where MaNhanVien = '$maNV'";
          $result = mysqli_query($con, $query);
          if ($result && $row = mysqli_fetch_assoc($result)) {
              $currentPass = $row['MatKhau'];
              // Mã hóa mật khẩu mới trước khi so sánh
              $hashedNewPass = md5($pass);
              // Kiểm tra nếu mật khẩu đã mã hóa mới khác với mật khẩu hiện tại
              if ($currentPass !== $hashedNewPass) {
                  // Nếu mật khẩu khác, sử dụng mật khẩu đã mã hóa
                  $pass = $hashedNewPass;
              } else {
                  // Nếu giống, giữ nguyên mật khẩu cũ
                  $pass = $currentPass;
              }
          }
          // Truy vấn cập nhật thông tin nhân viên
          $truyvan = "update nhanvien set TenNhanVien = N'$tenNV',Email = N'$email',SDT = N'$sdt',DiaChi = N'$diaChi',GioiTinh = N'$sex',MatKhau = '$pass',MaChuSan = '$maChuSan' where MaNhanVien = '$maNV'";
          $kq = mysqli_query($con, $truyvan);
          $p->dongKetNoi($con);
          return $kq;
        }
      
      

        public function deleteNhanVien($maNV){
          $p = new mKetNoi();
          $truyvan = "delete from nhanvien where MaNhanVien = $maNV";
          $con = $p -> moKetNoi();
          $kq = mysqli_query($con, $truyvan);
          $p -> dongKetNoi($con);
          return $kq;
        }
      }

?>