<?php
// Kết nối đến database
$servername = "sql105.ihostfull.com";
$username = "uoolo_36938243"; // Thay đổi nếu cần
$password = "anhtuan2k09";     // Thay đổi nếu cần
$dbname = "uoolo_36938243_school_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy giá trị từ form
$searchType = $_POST['searchType'] ?? '';
$searchInput = $_POST['searchInput'] ?? '';

$query = "SELECT * FROM students WHERE 1=1";

// Xử lý từng phương pháp tra cứu
if ($searchType === 'ten_hoc_sinh') {
    $query .= " AND ten_hoc_sinh LIKE '%$searchInput%'";
} elseif ($searchType === 'idlop') {
    $query .= " AND idlop = '$searchInput'";
} elseif ($searchType === 'bien_so_xe') {
    $query .= " AND bien_so_xe LIKE '%$searchInput%'";
}

$result = $conn->query($query);

// Chuẩn bị kết quả để trả về JSON
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

echo json_encode($rows);

$conn->close();
?>
