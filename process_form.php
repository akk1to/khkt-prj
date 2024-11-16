<?php
// Kết nối đến cơ sở dữ liệu
$servername = "51.81.57.217:3306";
$username = "u2677855_S8AKQhTEwH";
$password = "z8.=tIJwQPlgN=p.e4Tm5q.d";
$dbname = "s2677855_schooldb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
// if ($conn->connect_error) {
//     die("Kết nối thất bại: " . $conn->connect_error);
// }

// Hàm để kiểm tra dữ liệu nhập vào
function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Kiểm tra nếu form đã được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận và xác thực dữ liệu từ form
    $ma_so_hoc_sinh = validate_input($_POST['ma_so_hoc_sinh']);
    $ten_hoc_sinh = validate_input($_POST['ten_hoc_sinh']);
    $ngay_sinh = validate_input($_POST['ngay_sinh']);
    $idlop = validate_input($_POST['class']);
    $dia_chi = validate_input($_POST['dia_chi']);
    $ho_ten_cha = validate_input($_POST['ho_ten_cha']);
    $sdt_cha = validate_input($_POST['sdt_cha']);
    $ho_ten_me = validate_input($_POST['ho_ten_me']);
    $sdt_me = validate_input($_POST['sdt_me']);
    $bien_so_xe = validate_input($_POST['bien_so_xe']);
    $co_giay_phep_lai_xe = isset($_POST['co_giay_phep_lai_xe']) ? 1 : 0;
    $ma_so_giay_phep_lai_xe = $co_giay_phep_lai_xe ? validate_input($_POST['ma_so_giay_phep_lai_xe']) : NULL;
    $loai_xe_id = intval($_POST['loai_xe']);
    $loai_vi_pham_id = intval($_POST['loai_vi_pham']);
    $ngay_vi_pham = validate_input($_POST['ngay_vi_pham']);
    $ghi_chu = validate_input($_POST['ghi_chu']);

    // Kiểm tra định dạng dữ liệu
    $errors = [];

    if($conn->connect_error){
        $errors[] = " Đã có lỗi khi kết nối tới cơ sở dữ liệu!";
    }
    if (!preg_match('/^\d{10}$/', $ma_so_hoc_sinh)) {
        $errors[] = " Mã số học sinh phải có 10 chữ số!";
    }

    if (!preg_match('/^\d{10}$/', $sdt_cha)) {
        $errors[] = " SĐT phải có 10 chữ số!";
    }

    if (!preg_match('/^\d{10}$/', $sdt_me)) {
        $errors[] = " SĐT phải có 10 chữ số!";
    }

    if ($co_giay_phep_lai_xe && empty($ma_so_giay_phep_lai_xe)) {
        $errors[] = " Mã số giấy phép lái xe không được để trống! (nếu không có giấy phép, vui lòng không tích chọn ô 'Giấy phép lái xe'!";
    }

    if(empty($idlop)) {
        $errors[] = " Lớp không được để trống!";
    }

    // Nếu có lỗi, hiển thị và dừng quá trình
    if (count($errors) > 0) {
        echo "<h3>Đã có lỗi xảy ra, vui lòng kiểm tra lại! Các lỗi xảy ra: </h3><ul>";
        foreach($errors as $error) {
            echo "<li>{$error}</li>";
        }
        echo "</ul><a href='index.php'>Quay lại form</a>";
        exit();
    }

    if($co_giay_phep_lai_xe){
        // Chuyển đổi định dạng ngày từ DD-MM-YYYY sang YYYY-MM-DD cho MySQL
        $ngay_sinh_formatted = date("Y-m-d", strtotime($ngay_sinh));
        $ngay_vi_pham_formatted = date("Y-m-d", strtotime($ngay_vi_pham));
        $ma_so_hoc_sinh = $conn->real_escape_string($ma_so_hoc_sinh);
        $ten_hoc_sinh = $conn->real_escape_string($ten_hoc_sinh);
        $ngay_sinh_formatted = $conn->real_escape_string($ngay_sinh_formatted);
        $idlop = $conn->real_escape_string($idlop); // Giá trị dạng text cho lớp và khối
        $dia_chi = $conn->real_escape_string($dia_chi);
        $ho_ten_cha = $conn->real_escape_string($ho_ten_cha);
        $sdt_cha = $conn->real_escape_string($sdt_cha);
        $ho_ten_me = $conn->real_escape_string($ho_ten_me);
        $sdt_me = $conn->real_escape_string($sdt_me);
        $bien_so_xe = $conn->real_escape_string($bien_so_xe);
        $co_giay_phep_lai_xe = (int)$co_giay_phep_lai_xe; // ép kiểu cho giá trị số
        $ma_so_giay_phep_lai_xe = $conn->real_escape_string($ma_so_giay_phep_lai_xe);
        $loai_xe_id = (int)$loai_xe_id; // ép kiểu cho giá trị số
        $loai_vi_pham_id = (int)$loai_vi_pham_id; // ép kiểu cho giá trị số
        $ngay_vi_pham_formatted = $conn->real_escape_string($ngay_vi_pham_formatted);
        $ghi_chu = $conn->real_escape_string($ghi_chu);

        // Câu lệnh SQL chèn dữ liệu
        $sql = "INSERT INTO students (
                    ma_so_hoc_sinh, ten_hoc_sinh, ngay_sinh, lop, dia_chi,
                    ho_ten_cha, sdt_cha, ho_ten_me, sdt_me, bien_so_xe,
                    co_giay_phep_lai_xe, ma_so_giay_phep_lai_xe, loai_xe_id, 
                    loai_vi_pham_id, ngay_vi_pham, ghi_chu
                ) VALUES (
                    '$ma_so_hoc_sinh', '$ten_hoc_sinh', '$ngay_sinh_formatted', '$idlop', '$dia_chi',
                    '$ho_ten_cha', '$sdt_cha', '$ho_ten_me', '$sdt_me', '$bien_so_xe',
                    $co_giay_phep_lai_xe, '$ma_so_giay_phep_lai_xe', $loai_xe_id, 
                    $loai_vi_pham_id, '$ngay_vi_pham_formatted', '$ghi_chu'
                )";

        // Thực hiện truy vấn
        if ($conn->query($sql) === TRUE) {
            echo "Thêm dữ liệu thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Chuyển đổi định dạng ngày từ DD-MM-YYYY sang YYYY-MM-DD cho MySQL
        $ngay_sinh_formatted = date("Y-m-d", strtotime($ngay_sinh));
        $ngay_vi_pham_formatted = date("Y-m-d", strtotime($ngay_vi_pham));
        $ma_so_hoc_sinh = $conn->real_escape_string($ma_so_hoc_sinh);
        $ten_hoc_sinh = $conn->real_escape_string($ten_hoc_sinh);
        $ngay_sinh_formatted = $conn->real_escape_string($ngay_sinh_formatted);
        $idlop = $conn->real_escape_string($idlop); // Giá trị dạng text cho lớp và khối
        $dia_chi = $conn->real_escape_string($dia_chi);
        $ho_ten_cha = $conn->real_escape_string($ho_ten_cha);
        $sdt_cha = $conn->real_escape_string($sdt_cha);
        $ho_ten_me = $conn->real_escape_string($ho_ten_me);
        $sdt_me = $conn->real_escape_string($sdt_me);
        $bien_so_xe = $conn->real_escape_string($bien_so_xe);
        $co_giay_phep_lai_xe = (int)$co_giay_phep_lai_xe; // ép kiểu cho giá trị số
        $loai_xe_id = (int)$loai_xe_id; // ép kiểu cho giá trị số
        $loai_vi_pham_id = (int)$loai_vi_pham_id; // ép kiểu cho giá trị số
        $ngay_vi_pham_formatted = $conn->real_escape_string($ngay_vi_pham_formatted);
        $ghi_chu = $conn->real_escape_string($ghi_chu);

        // Câu lệnh SQL chèn dữ liệu
        $sql = "INSERT INTO students (
                    ma_so_hoc_sinh, ten_hoc_sinh, ngay_sinh, idlop, dia_chi,
                    ho_ten_cha, sdt_cha, ho_ten_me, sdt_me, bien_so_xe,
                    co_giay_phep_lai_xe, ma_so_giay_phep_lai_xe, loai_xe_id, 
                    loai_vi_pham_id, ngay_vi_pham, ghi_chu
                ) VALUES (
                    '$ma_so_hoc_sinh', '$ten_hoc_sinh', '$ngay_sinh_formatted', '$idlop', '$dia_chi',
                    '$ho_ten_cha', '$sdt_cha', '$ho_ten_me', '$sdt_me', '$bien_so_xe',
                    $co_giay_phep_lai_xe, '$ma_so_giay_phep_lai_xe', $loai_xe_id, 
                    $loai_vi_pham_id, '$ngay_vi_pham_formatted', '$ghi_chu'
                )";
                
        // Thực hiện truy vấn
        if ($conn->query($sql) === TRUE) {
            echo "Thêm dữ liệu thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
    // Đóng kết nối
    $conn->close();
} else {
    // Nếu truy cập không phải POST, chuyển hướng về form
    header("Location: index.php");
    exit();
}
?>
