<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sân bóng</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header id="header">
        <div class="logo">
            <img src="../img/path_to_logo.png" alt="Sport Logo">
        </div>
        <nav id="menu">
            <ul>
                <li class="item active"><a href="trangchu.php" id="trangchu">Trang Chủ</a></li>
                <li class="item" id="dropdown">
                    <button class="dropbtn">Danh sách sân</button>
                    <div class="dropdown-content">
                        <?php
                            include_once("view/listLoaiSan.php");
                            echo "<a href='San.php'>Tất cả sân</a>";
                        ?>
                    </div>
                </li>
                <li class="item"><a href="admin.php">Quản lý</a></li>
                <li class="item"><a href="timkiem.php">Tìm Kiếm</a></li>
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

    <section id="product-list">
        <?php
            if (isset($_REQUEST["idsan"])) {
                include_once("View/chiTietSan.php");
            } else if (isset($_REQUEST["idloai"])) {
                include_once("View/listSan.php");
            } else if (isset($_REQUEST["btnTim"])) {
                include_once("View/timkiem.php");
            } else {
                include_once("view/listSan.php");
            }
        ?>
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
    </div>
    <script src="script.js"></script>
</body>

</html>
