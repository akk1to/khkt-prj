<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$servername = "51.81.57.217:11462";
$username = "u2677855_S8AKQhTEwH";
$password = "z8.=tIJwQPlgN=p.e4Tm5q.d";
$dbname = "s2677855_schooldb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} elseif (empty($data)) {
    echo json_encode(['error' => 'No data found or query failed']);
}

$conn->close();
?>
