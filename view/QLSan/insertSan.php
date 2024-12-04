<?php 
  
  include_once("controller/cCoSo.php");
  $p = new cCoSo();
  $maChuSan = $_SESSION['MaChuSan'];
  $kq = $p->GetCoSoByMaChuSan($maChuSan);
    ob_start();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


?>
<h2 align="center">Thêm Sân Bóng</h2>
<form action="#" method="post" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label for="TenSan">Tên Sân Bóng</label>
        <input type="text" id="TenSan" name="TenSan" required>
        <small class="error-message" style="color: red; display: none;">Tên không hợp lệ!</small>
    </div>
    <div class="form-group">
        <label for="LoaiSan">Loại Sân</label>
        <select id="LoaiSan" name="LoaiSan" required onchange="updatePrice()">
        <?php
         
        
         include_once("controller/cLoaiSan.php");
         $pls = new cLoaiSan();
         $kqls = $pls->GetALLLoaiSan();
  
  
          if ($kqls) {
           // Lặp qua từng cơ sở và tạo các option
              while ($row = mysqli_fetch_assoc($kqls)) {
                 echo "<option value='{$row['MaLoaiSan']}'>{$row['TenLoai']}</option>";
          }
          } else {
                 echo "<option value=''>Không có loại sân nào</option>";
         }
  ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Giá thuê sân</label>
        <p>Sáng: <span id="GiaThueSang">...</span> VND</p>
        <p>Chiều: <span id="GiaThueChieu">...</span> VND</p>
    </div>
    <div class="form-group">
        <label for="MoTaSan">Mô Tả Sân</label>
        <textarea id="MoTaSan" name="MoTaSan" placeholder="Mô tả sân (ví dụ: có đèn chiếu sáng, phòng thay đồ...)"></textarea>
    </div>
    <div class="form-group">
        <label for="ThoiGianHoatDong">Thời Gian Hoạt Động</label>
        <input type="text" id="ThoiGianHoatDong" name="ThoiGianHoatDong" placeholder="Ví dụ: 6:00 AM - 10:00 PM" required>
    </div>
    <div class="form-group">
        <label for="MaNhanVien">Nhân Viên Quản Lí</label>
        <select id="MaNhanVien" name="MaNhanVien" required>
       
        <?php
         
        
       include_once("controller/cNhanVien.php");
       $pnv = new cNhanVien();
       $kqnv = $pnv->getNhanVienByMaChuSan($maChuSan);


        if ($kqnv) {
         // Lặp qua từng cơ sở và tạo các option
            while ($row = mysqli_fetch_assoc($kqnv)) {
               echo "<option value='{$row['MaNhanVien']}'>{$row['TenNhanVien']}</option>";
        }
        } else {
               echo "<option value=''>Không có nhân viên nào</option>";
       }
?>
        </select>
    </div>
    <div class="form-group">
    <label for="MaCoSo">Cơ Sở</label>
    <select id="MaCoSo" name="MaCoSo" required>
        <?php

        // Tạo đối tượng cCoSo và lấy danh sách cơ sở
      

        if ($kq) {
            // Lặp qua từng cơ sở và tạo các option
            while ($row = mysqli_fetch_assoc($kq)) {
                echo "<option value='{$row['MaCoSo']}'>{$row['TenCoSo']}</option>";
            }
        } else {
            echo "<option value=''>Không có cơ sở nào</option>";
        }
        ?>
    </select>
</div>

    <div class="form-group">
        <label for="AnhSan">Hình Ảnh Sân</label>
        <input type="file" id="AnhSan" name="AnhSan" accept="image/*">
    </div>
    <div class="form-group" style="display: flex; justify-content: space-between;">
        <input type="submit" name="btnThemSan" value="Thêm Sân">
        <input type="reset" value="Hủy">
    </div>
    <div id="ajaxResult" style="margin-top: 20px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;">
    <!-- Kết quả AJAX sẽ được hiển thị ở đây -->
</div>

</form>

<?php
include_once("controller/cGiaThue.php");

$psb = new cGiaThue();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ body của yêu cầu (là JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['maLoaiSan'])) {
        $maLoaiSan = $input['maLoaiSan'];
        
        // Lấy giá thuê dựa trên maLoaiSan
        include_once("controller/cGiaThue.php");
        $psb = new cGiaThue();
        $giaThueData = $psb->getGiaThueByLoaiSan($maLoaiSan);

        // Trả về dữ liệu dưới dạng JSON
        if ($giaThueData) {
            echo json_encode([
                'success' => true,
                'giaSang' => $giaThueData['GiaThueSang'],
                'giaChieu' => $giaThueData['GiaThueChieu']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy giá thuê'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Tham số maLoaiSan không hợp lệ'
        ]);
    }
    exit;
}

?>


<script>
    function updatePrice() {
    const maLoaiSan = document.getElementById("LoaiSan").value;
    
    // Kiểm tra nếu mã loại sân không trống
    if (maLoaiSan) {
        
        switch (maLoaiSan) {
            case '1': {
                document.getElementById("GiaThueSang").textContent = "100000";
                document.getElementById("GiaThueChieu").textContent = "120000";
                break;
            }
            case '2': {
                document.getElementById("GiaThueSang").textContent = "150000";
                document.getElementById("GiaThueChieu").textContent = "170000";
                break;
            }
            case '3': {
                document.getElementById("GiaThueSang").textContent = "200000";
                document.getElementById("GiaThueChieu").textContent = "250000";
                break;
            }
            default: {
                alert("Mã loại sân không hợp lệ");
                break;
            }
        }
    }
}


    // Gửi yêu cầu AJAX để lấy dữ liệu giá thuê




    // Regex cho từng loại kiểm tra
    const nameRegex = /^[A-ZÀÁÃẠẢĂẲẰẮẴẶÂẦẪẬẨẤÈẺÉẼẸÊỂẾỀỆỄÌỈÍỊĨÒỎÓỌÕÔỔỐỒỘỖỞƠỚỜỢỠÙÚỦŨỤĐƯỨỪỮỰỬỲỴÝỶỸ][a-zàáãạảăẳằắẵặâầẫậẩấèẻéẽẹêểếềệễìỉíịĩòỏóọõôổốồộỗởơớờợỡùúủũụđưứừữựửỳỵýỷỹ]*(\s[A-ZÀÁÃẠẢĂẲẰẮẴẶÂẦẪẬẨẤÈẺÉẼẸÊỂẾỀỆỄÌỈÍỊĨÒỎÓỌÕÔỔỐỒỘỖỞƠỚỜỢỠÙÚỦŨỤĐƯỪỨỮỰỬỲỴÝỶỸ][a-zàáãạảăẳằắẵặâầẫậẩấèẻéẽẹêểếềệễìỉíịĩòỏóọõôổốồộỗởơớờợỡùúủũụđưứừữựửỳỵýỷỹ]*)*$/u;


    // Hàm kiểm tra dữ liệu
    // function validateField(input, regex, errorMessage) {
    //     const value = input.value.trim(); // Loại bỏ khoảng trắng thừa
    //     const errorElement = input.nextElementSibling;

    //     if (!regex.test(value)) {
    //         input.style.border = "2px solid red"; // Viền đỏ
    //         errorElement.style.display = "block"; // Hiển thị thông báo lỗi
    //         errorElement.innerText = errorMessage;
    //     } else {
    //         input.style.border = "2px solid green"; // Viền xanh lá cây
    //         errorElement.style.display = "none"; // Ẩn thông báo lỗi
    //     }
    // }

    // Gán sự kiện blur cho từng ô nhập liệu
    document.getElementById("TenSan").addEventListener("blur", function () {
        validateField(this, nameRegex, "Tên không hợp lệ! Tên phải viết hoa chữ cái đầu và không chứa ký tự đặc biệt.");
    });

    document.getElementById("ThoiGianHoatDong").addEventListener("blur", function () {
        validateField(this, addressRegex, "Địa chỉ không hợp lệ! Vui lòng nhập địa chỉ hợp lệ.");
    });
</script>

<?php
include_once("controller/cSan.php");
$psb = new cSan();

if (isset($_POST['btnThemSan'])) {
    // Lấy dữ liệu từ form
    $tenSanBong = $_POST['TenSan'];
    $loaiSan = $_POST['LoaiSan'];
    $moTaSan = $_POST['MoTaSan'];
    $thoiGianHoatDong = $_POST['ThoiGianHoatDong'];
    $maNhanVien = $_POST['MaNhanVien'];
    $maCoSo = $_POST['MaCoSo'];

    // Xử lý file ảnh
    if (isset($_FILES['AnhSan']) && $_FILES['AnhSan']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "img/SanBong/"; // Thư mục lưu ảnh
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Tạo thư mục nếu chưa tồn tại
        }

        $fileTmpPath = $_FILES['AnhSan']['tmp_name'];
        $fileName = basename($_FILES['AnhSan']['name']);
        $fileSize = $_FILES['AnhSan']['size'];
        $fileType = $_FILES['AnhSan']['type'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Các loại file được phép

        // Kiểm tra loại file và kích thước
        if (in_array($fileExtension, $allowedExtensions) && $fileSize <= 5 * 1024 * 1024) { // Giới hạn 5MB
            $newFileName = $tenSanBong . '.' . $fileExtension; // Đổi tên file để tránh trùng lặp
            $targetFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                // Gọi phương thức thêm sân bóng với tên file ảnh
                $kq = $psb->insertSanBong($tenSanBong, $thoiGianHoatDong, $moTaSan, $newFileName, $maNhanVien, $loaiSan, $maCoSo);
               
                if ($kq) {
                    echo "<script>alert('Thêm sân bóng thành công!')</script>";
                    echo '<script>window.location.href="admin.php?sanbong";</script>';

                } else {
                    
                    echo "<script>alert('Thêm sân bóng thất bại')</script>";
                    echo '<script>window.location.href="admin.php?action=addSan";</script>';
           //         
                }
            } else {
                echo "<script>alert('Không thể di chuyển file!')</script>";
            }
        } else {
            echo "<script>alert('File không hợp lệ hoặc quá lớn (giới hạn 5MB)!')</script>";
        }
    } else {
        echo "<script>alert('Vui lòng chọn file ảnh!')</script>";
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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 400px;
        margin-left: 400px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        color: #333;
    }

    .form-group input[type="submit"],
    .form-group input[type="reset"] {
        width: 48%;
        cursor: pointer;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        padding: 10px;
        margin-right: 4%;
        background-color: #007bff;
        color: white;
        transition: background-color 0.3s ease;
    }

    .form-group input[type="reset"] {
        background-color: #6c757d;
    }

    .form-group input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .form-group input[type="reset"]:hover {
        background-color: #495057;
    }
</style>