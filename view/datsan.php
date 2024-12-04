<form action="#" method="POST" enctype="multipart/form-data">
    <table>
        <h1>Đặt sân</h1>
        <tr>
            <td>Tên sân bóng</td>
            <td><input type="text" name="txtTenSan"  required ></td>
        </tr>
        <tr>
            <td>Tên khách hàng</td>
            <td><input type="text" name="txtTenKH" required ></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><input type="text" name="txtSDT" required ></td>
        </tr>
        <tr>
            <td>Ngày đặt</td>
            <td><input type="date" name="txtNgayDat" required ></td>
        </tr>
        <tr>
            <td>Giờ bắt đầu</td>
            <td><input type="time" name="txtGioBatDau" required ></td>
        </tr>
        <tr>
            <td>Giờ kết thúc</td>
            <td><input type="time" name="txtGioKetThuc" required ></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Đặt sân" name="btnDat">
                <input type="reset" value="Nhap lai">
            </td>
        </tr>
    </table>

</form>