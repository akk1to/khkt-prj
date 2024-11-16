<?php
// Include Composer autoload (bao gồm cả thư viện PhpSpreadsheet)
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Kết nối cơ sở dữ liệu
$servername = "sql105.ihostfull.com";
$username = "uoolo_36938243"; // Thay đổi nếu cần
$password = "anhtuan2k09";     // Thay đổi nếu cần
$dbname = "uoolo_36938243_school_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchType = validate_input($_POST['searchType']); // Ví dụ lấy tên học sinh từ form tìm kiếm
    $searchInput = validate_input($_POST['searchInput']);
    $startDate = validate_input($_POST['startDate']);
    $endDate = validate_input($_POST['endDate']);
}

// // Lấy dữ liệu tìm kiếm từ người dùng
// $searchType = $_POST['searchType']; // Ví dụ lấy tên học sinh từ form tìm kiếm
// $searchInput = $_POST['searchInput'];
// $startDate = $_POST['startDate'];
// $endDate = $_POST['endDate'];


// Truy vấn dữ liệu theo tên học sinh
$sql = "SELECT * FROM students WHERE ten_hoc_sinh WHERE 1 = 1";
$result = $conn->query($sql);

if ($searchType === 'ten_hoc_sinh') {
    $query .= " AND ten_hoc_sinh LIKE '%$searchInput'";
} elseif ($searchType === 'idlop') {
    $query .= " AND idlop = '%$searchInput'";
} elseif ($searchInput === 'bien_so_xe') {
    $query .= " AND bien_so_xe LIKE '%$searchInput'";
} elseif ($searchType === 'ngay_vi_pham') {
    $query .= " AND ngay_vi_pham = '$searchInput'";
} elseif ($searchType === 'date_range') {
    $query .= " AND ngay_vi_pham BETWEEN '$startDate' AND '$endDate'";
}

// Kiểm tra nếu có kết quả
if ($result->num_rows > 0) {
    // Khởi tạo Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Thiết lập tiêu đề cột
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Mã số học sinh');
    $sheet->setCellValue('C1', 'Tên học sinh');
    $sheet->setCellValue('D1', 'Ngày sinh');
    $sheet->setCellValue('E1', 'Khối');
    $sheet->setCellValue('F1', 'Lớp');
    $sheet->setCellValue('G1', 'Biển số xe');
    $sheet->setCellValue('H1', 'Ngày vi phạm');
    $sheet->setCellValue('I1', 'Ghi chú');
    
    // Duyệt dữ liệu và ghi vào Excel
    $row = 2; // Bắt đầu từ hàng thứ 2 để tránh tiêu đề
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['ma_so_hoc_sinh']);
        $sheet->setCellValue('C' . $row, $data['ten_hoc_sinh']);
        $sheet->setCellValue('D' . $row, $data['ngay_sinh']);
        $sheet->setCellValue('E' . $row, $data['khoi_id']);
        $sheet->setCellValue('F' . $row, $data['lop_id']);
        $sheet->setCellValue('G' . $row, $data['bien_so_xe']);
        $sheet->setCellValue('H' . $row, $data['ngay_vi_pham']);
        $sheet->setCellValue('I' . $row, $data['ghi_chu']);
        $row++;
    }
    
    // Tạo file Excel và tải về
    $writer = new Xlsx($spreadsheet);
    $filename = "ket_qua_tim_kiem_" . $search_name . ".xlsx";

    // Gửi header để tải file về
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output'); // Xuất file ra trình duyệt
    exit;
} else {
    echo "Không tìm thấy dữ liệu cho học sinh có tên: " . $search_name;
}

$conn->close();
?>
