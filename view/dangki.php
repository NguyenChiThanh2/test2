<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../img/pexels-photo-61135.jpeg');
            background-size: cover; 
            background-position: center; 
            height: 100vh; 
        }
        .container {
            margin-top: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 70%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            position: relative; /* For positioning the close button */
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            color: #0062E6;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #0062E6;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <button class="close-btn" onclick="window.history.back();">&times;</button>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Đăng ký tài khoản</h2>
            <form>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" placeholder="Nhập họ và tên" required>
                </div>
                <div class="mb-3">
                    <label for="sdt" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="sdt" placeholder="Nhập Số điện thoại" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
            </form>
            <p class="text-center mt-3">
                Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
