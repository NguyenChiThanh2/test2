<?php
include_once('controller/cSan.php');
$psb = new cSan();  // Kết nối với cơ sở dữ liệu

if (isset($_GET['MaSanBong'])) {
    $maSanBong = $_GET['MaSanBong'];
    $maChuSan = $_GET['MaChuSan'];

    $sanBong = $psb->getInfo1San($maSanBong, $maChuSan);  // Lấy thông tin sân bóng từ DB
    if ($sanBong) {
        $sanBongData = mysqli_fetch_assoc($sanBong); // Lấy dữ liệu từ kết quả truy vấn
        if ($sanBongData) {
            $tenSanBong = $sanBongData['TenSanBong'];
            $loaiSan = $sanBongData['MaLoaiSan'];
            $tenLoaiSan = $sanBongData['TenLoai'];
            $giathue1 = $sanBongData['Gia'];
            $moTaSan = $sanBongData['MoTa'];
            $thoiGianHoatDong = $sanBongData['ThoiGianHoatDong'];
            $maNhanVien = $sanBongData['MaNhanVien'];
            $tenNV = $sanBongData['TenNhanVien'];
            $HinhAnh = $sanBongData['HinhAnh'];
            $maCoSo = $sanBongData['MaCoSo'];
        }
    } else {
        echo "<script>alert('Sân bóng Không Tồn Tại !!!')</script>";
        header("refresh:0; url='admin.php'");
    }
}
?>
<h2 align="center">Cập Nhật Sân Bóng</h2>
<form action="" method="post" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label for="TenSan">Tên Sân Bóng</label>
        <input type="text" id="TenSan" name="TenSan" required value="<?php echo htmlspecialchars($tenSanBong ?? '', ENT_QUOTES); ?>">
    </div>
    <div class="form-group">
        <label for="LoaiSan">Loại Sân</label>
        <select id="LoaiSan" name="LoaiSan" required>
            <?php
            include_once("controller/cLoaiSan.php");
            $pls = new cLoaiSan();
            $kqls = $pls->GetALLLoaiSan();
            
            if ($kqls) {
                while ($row = mysqli_fetch_assoc($kqls)) {
                    $selected = ($row['MaLoaiSan'] == $loaiSan) ? "selected" : "";
                    echo "<option value='{$row['MaLoaiSan']}' $selected>{$row['TenLoai']}</option>";
                }
            } else {
                echo "<option value=''>Không có loại sân nào</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="GiaSan">Giá Thuê Sân (VND/giờ)</label>
        <input type="number" id="GiaSan" name="GiaSan" min="0" required value="<?php echo htmlspecialchars($giathue1 ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="MoTaSan">Mô Tả Sân</label>
        <textarea id="MoTaSan" name="MoTaSan"><?php echo htmlspecialchars($moTaSan ?? ''); ?></textarea>
    </div>
    <div class="form-group">
        <label for="ThoiGianHoatDong">Thời Gian Hoạt Động</label>
        <input type="text" id="ThoiGianHoatDong" name="ThoiGianHoatDong" required value="<?php echo htmlspecialchars($thoiGianHoatDong ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="MaNhanVien">Nhân Viên Quản Lí</label>
        <select id="MaNhanVien" name="MaNhanVien" required>
            <?php
            include_once("controller/cNhanVien.php");
            $pnv = new cNhanVien();
            $kqnv = $pnv->getNhanVienByMaChuSan($maChuSan);
            
            if ($kqnv) {
                while ($row = mysqli_fetch_assoc($kqnv)) {
                    $selected = ($row['MaNhanVien'] == $maNhanVien) ? "selected" : "";
                    echo "<option value='{$row['MaNhanVien']}' $selected>{$row['TenNhanVien']}</option>";
                }
            } else {
                echo "<option value=''>Không có nhân viên nào</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
    <label for="HinhAnh">Hình Ảnh Sân</label>
    <?php
    // Kiểm tra xem sân có ảnh hay không
    if (!empty($HinhAnh)) {
        echo "<img src='img/SanBong/$HinhAnh' alt='Ảnh Sân' style='max-width: 200px; margin-bottom: 10px;'>";
    }
    ?>
    <input type="file" id="HinhAnh" name="HinhAnh" accept="image/*">
</div>

    <div class="form-group" style="display: flex; justify-content: space-between;">
        <input type="submit" name="btnCapNhatSan" value="Cập Nhật Sân">
        <input type="reset" value="Hủy">
    </div>
</form>

<?php
if (isset($_POST['btnCapNhatSan'])) {
    // Lấy dữ liệu từ form
    $tenSanBong = $_POST['TenSan'];
    $loaiSan = $_POST['LoaiSan'];
    $giaSan = $_POST['GiaSan'];
    $moTaSan = $_POST['MoTaSan'];
    $thoiGianHoatDong = $_POST['ThoiGianHoatDong'];
    $maNhanVien = $_POST['MaNhanVien'];
    
    // Xử lý ảnh mới
    $newFileName = null;
    if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "img/SanBong/"; // Thư mục lưu ảnh
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Tạo thư mục nếu chưa tồn tại
        }

        $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
        $fileName = basename($_FILES['HinhAnh']['name']);
        $fileSize = $_FILES['HinhAnh']['size'];
        $fileType = $_FILES['HinhAnh']['type'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file ảnh
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            // Tạo tên file mới để tránh trùng
            $newFileName = uniqid('sanbong_') . '.' . $fileExtension;
            $destPath = $targetDir . $newFileName;

            // Di chuyển file vào thư mục
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Xóa ảnh cũ nếu có
                if (!empty($sanBongData['HinhAnh']) && file_exists($targetDir . $sanBongData['HinhAnh'])) {
                    unlink($targetDir . $sanBongData['HinhAnh']);
                }
            } else {
                echo "Lỗi khi tải ảnh lên.";
            }
        } else {
            echo "Chỉ cho phép tải lên các định dạng ảnh: jpg, jpeg, png, gif.";
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $newFileName = $sanBongData['HinhAnh'];
    }

    // Cập nhật thông tin sân bóng
    $result = $psb->updateSanBong($maSanBong, $tenSanBong, $loaiSan, $giaSan, $moTaSan, $thoiGianHoatDong, $maNhanVien, $newFileName, $maCoSo);

    if ($result) {
        echo "Cập nhật sân bóng thành công!";
        echo "<script>window.location.href = 'admin.php?sanbong';</script>";
        exit();
    } else {
        echo "Có lỗi xảy ra, vui lòng thử lại.";
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding-left: 0;
        align-items: center;
        height: 100vh;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .form-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
        margin: 0 auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-group input[type="submit"],
    .form-group input[type="reset"] {
        width: 48%;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .form-group input[type="submit"]:hover,
    .form-group input[type="reset"]:hover {
        background-color: #45a049;
    }

    .form-group input[type="file"] {
        padding: 5px;
        margin-top: 10px;
    }

    .form-group small {
        font-size: 12px;
        color: red;
    }
</style>
