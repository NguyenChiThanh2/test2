<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("mKetNoi.php");

class ModelUser {
    public function checkLogin($email, $password) {
        $p = new mKetNoi();
        $con = $p->moKetNoi();

        // Danh sách bảng và cột ID để kiểm tra đăng nhập
        $tables = [
            'khachhang' => 'MaKhachHang',
            'nhanvien' => 'MaNhanVien',
            'chusan' => 'MaChuSan'
        ];

        foreach ($tables as $table => $idColumn) {
            // Sử dụng Prepared Statements để tránh SQL Injection
            $stmt = $con->prepare("SELECT * FROM $table WHERE Email = ? AND MatKhau = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Thiết lập session sau khi đăng nhập thành công
                $_SESSION["dangnhap"] = $user[$idColumn];
                $_SESSION["loaiNguoiDung"] = $table; // Lưu loại người dùng
                
                // Thêm loại người dùng vào kết quả trả về
                $user['loaiNguoiDung'] = $table;

                $stmt->close();
                $p->dongKetNoi($con);
                return $user;
            }

            $stmt->close();
        }

        // Đóng kết nối và trả về false nếu không tìm thấy người dùng
        $p->dongKetNoi($con);
        return false;
    }
}
?>
