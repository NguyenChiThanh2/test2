<?php
include_once("controller/cSan.php");
$p = new cSan();
$maChuSan = $_SESSION['MaChuSan'];
$kq = $p->getAllSanBongByMaChuSan($maChuSan); // Lấy tất cả sân bóng của chủ sân

if ($kq) {
    echo "<div class='header-container'>
            <h1>Quản lý sân</h1>
            <a class='btn-add' href='?action=addSan'>Thêm sân mới</a>
        </div>";
    echo "<table>";
    echo "<tr>
            <th>Mã sân bóng</th>
            <th>Tên sân bóng</th>
            <th>Thời gian hoạt động</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Nhân viên quản lý</th>
            <th>Loại sân</th>
            <th>Tên cơ sở</th>
            <th>Hành động</th>
          </tr>";

    // Duyệt qua tất cả các sân bóng và hiển thị thông tin
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($r["MaSanBong"]) . "</td>"; // Sử dụng htmlspecialchars() để bảo vệ dữ liệu
        echo "<td>" . htmlspecialchars($r["TenSanBong"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["ThoiGianHoatDong"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["MoTa"]) . "</td>";
        echo "<td><img src='../img/SanBong/" . htmlspecialchars($r['HinhAnh']) . "' width='100px' height='80px'/></td>";
        echo "<td>" . htmlspecialchars($r["TenNhanVien"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["TenLoai"]) . "</td>";
        echo "<td>" . htmlspecialchars($r["TenCoSo"]) . "</td>";
        
        // Sửa và Xóa
        $maSanBong = htmlspecialchars($r['MaSanBong']); // An toàn hơn khi xử lý dữ liệu người dùng
        echo "<td>
                <a href='?action=updateSanBong&MaSanBong=$maSanBong&MaChuSan=$maChuSan' class='edit-button'>Sửa</a>

                <a href='deleteSanBong.php?MaSanBong=$maSanBong' class='delete-button' onclick='return confirm(\"Bạn chắc chắn muốn xóa sân này?\")'>Xóa</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu";
}
?>
