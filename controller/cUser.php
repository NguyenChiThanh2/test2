<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("..//model/mUser.php");
class ControllerUser {
    public function login($email, $password) {
        $p = new ModelUser();
        $user = $p->checkLogin($email, $password);
    
        if ($user) {
            // Lấy loại người dùng từ session
            $role = $user['loaiNguoiDung'];
            $welcomeMessage = "";
    
            switch ($role) {
                case 'chusan':
                    $welcomeMessage = "Hoan nghênh Chủ Sân. Chúc bạn một ngày kinh doanh hiệu quả và thành công.";
                    $_SESSION["MaChuSan"] = $user["MaChuSan"];
                    break;
                case 'nhanvien':
                    $welcomeMessage = "Đăng nhập thành công. Chúc bạn một ngày làm việc tràn đầy năng lượng.";
                    break;
                case 'khachhang':
                    $welcomeMessage = "Chào mừng Quý Khách. Hãy tận hưởng những dịch vụ tốt nhất từ chúng tôi.";
                    break;
                default:
                    $welcomeMessage = "Welcome Admin!";
            }
    
            // Hiển thị thông báo
            echo "<script>
                alert('$welcomeMessage');
                window.location.href = '../index.php';
            </script>";
        } else {
            // Đăng nhập thất bại
            echo "<script>
                alert('Đăng nhập thất bại! Vui lòng kiểm tra lại.');
                window.location.href = 'dangnhap.php';
            </script>";
        }
    }
    
}
?>
