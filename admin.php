<?php
    session_start();
    if (!isset($_SESSION["dangnhap"]) || !isset($_SESSION["loaiNguoiDung"])) {
        echo '<script>alert("Bạn không có quyền truy cập!");</script>';
        header("refresh: 0; url=index.php");
        exit();
    }
    // Lấy loại người dùng từ session
    $loaiNguoiDung = $_SESSION["loaiNguoiDung"];
    // Chỉ cho phép chủ sân và nhân viên
    if ($loaiNguoiDung == "khachhang") {
        echo '<script>alert("Khách hàng không có quyền truy cập trang này!");</script>';
        header("refresh: 0; url=index.php");
        exit();
    }
    // Nếu là chủ sân hoặc nhân viên thì tiếp tục
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/styleql.css">
    <style>
            /* CSS cho phần session */

section {
    display: flex;
    padding: 20px 30px;
    gap: 20px;
    background-color: #f9f9f9; /* Màu nền sáng cho toàn bộ section */
}

/* Sidebar Navigation */
section nav {
    width: 200px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
}

section nav ul {
    list-style-type: none;
    padding: 0;
}

section nav ul li {
    margin-bottom: 10px;
}

section nav ul li a {
    color: #333;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 12px;
    display: block;
    border-radius: 4px;
    transition: background-color 0.3s;
}

section nav ul li a:hover {
    background-color: #f0f0f0; /* Màu nền nhạt khi hover */
}

/* Nội dung chính */
article {
    flex: 1;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    color: #333;
}

/* Tiêu đề của nội dung chính */
article h1, article h2 {
    font-size: 24px;
    color: #4CAF50;
    margin-bottom: 15px;
}

/* Đoạn văn trong nội dung chính */
article p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}

    </style>
</head>
<body>
    <header id="header">
        <div class="logo">
            <img src="../img/path_to_logo.png" alt="Sport Logo">
        </div>
        <nav id="menu">
            <ul>
                <li class="item active"><a href="trangchu.php" id="trangchu">Trang Chủ</a></li>
                <li class="item"><a href="San.php">Danh sách sân</a></li>
                <li class="item"><a href="admin.php">Quản lý</a></li>
                <li class="item"><a href="./view/timkiem.php">Tìm Kiếm</a></li>
            </ul>
        </nav>
        <div id="actions">
            <button class="btn-register"><a style="color: white;" href="./view/dangki.php">Đăng ký</a></button>
            <?php
                 if(isset($_SESSION["dangnhap"])){
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangxuat.php">Đăng xuất</a></button>';
                 }else{
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangnhap.php">Đăng nhập</a></button>';
                 }
            ?>
        </div>
    </header>

    <section>
        <nav>
            <ul>
            <?php
                echo "<li><a href='?sanbong'>Quản lý sân bóng</a></li>";
                if($loaiNguoiDung == "chusan"){
                    echo "<li><a href='?nhanvien'>Quản lý nhân viên</a></li>";
                    echo "<li><a href='?khachhang'>Quản lý khách hàng</a></li>";
                }else{
                    echo "<li><a href='?khachhang'>Quản lý khách hàng</a></li>";
                }
                echo "<li><a href='?dondat'>Quản lý đơn đặt sân</a></li>";
            ?>
            </ul>
        </nav>
        
        <article>
            <?php
            if(isset($_REQUEST["sanbong"])){
                include_once("View/QLSan/quanlysan.php");
            }elseif(isset($_REQUEST["nhanvien"])){
                include_once("View/QLNhanVien/quanlynhanvien.php");          
            }elseif (isset($_REQUEST["action"]) && $_REQUEST["action"] === "addNV"){
                include_once("View/QLNhanVien/insertNhanVien.php");          
            }elseif (isset($_REQUEST["action"]) && $_REQUEST["action"] === "deleteNV"){
                include_once("View/QLNhanVien/deleteNhanVien.php");          
            }elseif (isset($_REQUEST["action"]) && $_REQUEST["action"] === "updateNV"){
                include_once("View/QLNhanVien/updateNhanVien.php");          
            }elseif (isset($_REQUEST["action"]) && $_REQUEST["action"] === "addSan"){
                include_once("View/QLSan/insertSan.php");          
            }elseif (isset($_REQUEST["action"]) && $_REQUEST["action"] === "updateSanBong"){
                include_once("View/QLSan/updateSan.php");          
            }
                
            ?>
        </article>
    </section>

    <!-- Footer Section -->
    <footer id="footer">
        <div class="box">
            <h3>GIỚI THIỆU</h3>
            <div class="logo">
                <img src="assets/logo.png" alt="Logo">
            </div>
            <p>Cung cấp một nền tảng tiện lợi, giúp người dùng dễ dàng tìm kiếm, đặt chỗ và quản lý việc thuê sân bóng</p>
        </div>
        <div class="box">
            <h3>NỘI DUNG</h3>
            <ul class="quick-menu">
                <li class="item"><a href="index.php">Trang chủ</a></li>
                <li class="item"><a href="dssan.php">Danh sách sân</a></li>
                <li class="item"><a href="#">Dịch vụ</a></li>
                <li class="item"><a href="#">Liên hệ</a></li>
            </ul>
        </div>
        <div class="box">
            <h3>Thông tin</h3>
            <p><strong>Website đặt sân trực tuyến</strong></p>
            <p>Email: <a href="mailto:contact@datsan247.com">contact@datsan.com</a></p>
            <p>Địa chỉ: Nguyễn Văn Bảo, Phường 14, Gò Vấp</p>
            <p>Điện thoại: <a href="tel:+84355193363">0355193363</a></p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
