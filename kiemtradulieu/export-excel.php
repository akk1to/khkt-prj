<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$searchType = $_POST['searchType'];
$searchInput = $_POST['searchInput'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];


$sql = "SELECT * FROM students WHERE ten_hoc_sinh WHERE 1 = 1";
$result = $conn->query($sql);

if ($searchType === 'ten_hoc_sinh') {
    $query .= " AND ten_hoc_sinh LIKE '%$searchInput'";
} elseif ($searchType === 'idlop') {
    $query .= " AND idlop LIKE '%$searchInput'";
} elseif ($searchType === 'biensoxe') {
    $query .= " AND bien_so_xe LIKE '%$searchinput%'";
}

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Mã số học sinh');
    $sheet->setCellValue('C1', 'Tên học sinh');
    $sheet->setCellValue('D1', 'Ngày sinh');
    $sheet->setCellValue('E1', 'Khối');
    $sheet->setCellValue('F1', 'Lớp');
    $sheet->setCellValue('G1', 'Biển số xe');
    $sheet->setCellValue('H1', 'Ngày vi phạm');
    $sheet->setCellValue('I1', 'Ghi chú');
    
    $row = 2; 
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
    
    $writer = new Xlsx($spreadsheet);
    $filename = "Danh sách học sinh vi phạm.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
} else {
    echo "Không tìm thấy dữ liệu cho học sinh có tên: " . $search_name;
}

$conn->close();
?>
