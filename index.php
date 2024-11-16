<?php
// Kết nối đến cơ sở dữ liệu
$servername = "51.81.57.217:3306";
$username = "u2677855_S8AKQhTEwH";
$password = "z8.=tIJwQPlgN=p.e4Tm5q.d";
$dbname = "s2677855_schooldb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách Loại Xe
$loai_xe_sql = "SELECT * FROM loai_xe";
$loai_xe_result = $conn->query($loai_xe_sql);

// Lấy danh sách Loại Vi Phạm
$loai_vi_pham_sql = "SELECT * FROM loai_vi_pham";
$loai_vi_pham_result = $conn->query($loai_vi_pham_sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Nhập Dữ Liệu Học Sinh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px 40px 40px;
            border-radius: 8px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .checkbox-group {
            margin-top: 15px;
        }
        .checkbox-group label {
            display: inline-block;
            margin-right: 10px;
            font-weight: normal;
        }
        .submit-btn {
            margin-top: 20px;
            text-align: center;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center; 
        }

        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }
    }
    </style>
    <script>
        // Hàm hiển thị/ẩn mã số giấy phép lái xe
        function toggleGiayPhep() {
            var checkbox = document.getElementById("co_giay_phep_lai_xe");
            var ma_giay_phep_div = document.getElementById("ma_giay_phep_div");
            if (checkbox.checked) {
                ma_giay_phep_div.style.display = "block";
            } else {
                ma_giay_phep_div.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Form nhập dữ liệu học sinh vi phạm</h2>
        <form action="process_form.php" method="post">
            <!-- Mã Số Học Sinh -->
            <label for="ma_so_hoc_sinh">Mã Số Học Sinh (10 số):</label>
            <input type="text" id="ma_so_hoc_sinh" name="ma_so_hoc_sinh" pattern="\d{10}" required>

            <!-- Tên Học Sinh -->
            <label for="ten_hoc_sinh">Tên Học Sinh:</label>
            <input type="text" id="ten_hoc_sinh" name="ten_hoc_sinh" required>

            <!-- Ngày Sinh -->
            <label for="ngay_sinh">Ngày Sinh:</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" required>

            <!-- Khối -->
            <label for="class">Lớp:</label>
            <input type="text" id="class" name="class" required>


            <!-- Địa Chỉ -->
            <label for="dia_chi">Địa Chỉ:</label>
            <input type="text" id="dia_chi" name="dia_chi" required>

            <!-- Họ Tên Cha -->
            <label for="ho_ten_cha">Họ Tên Cha:</label>
            <input type="text" id="ho_ten_cha" name="ho_ten_cha" required>

            <!-- SĐT Cha -->
            <label for="sdt_cha">SĐT Cha (10 số):</label>
            <input type="text" id="sdt_cha" name="sdt_cha" pattern="\d{10}" required>

            <!-- Họ Tên Mẹ -->
            <label for="ho_ten_me">Họ Tên Mẹ:</label>
            <input type="text" id="ho_ten_me" name="ho_ten_me" required>

            <!-- SĐT Mẹ -->
            <label for="sdt_me">SĐT Mẹ (10 số):</label>
            <input type="text" id="sdt_me" name="sdt_me" pattern="\d{10}" required>

            <!-- Biển Số Xe -->
            <label for="bien_so_xe">Biển Số Xe (10 ký tự):</label>
            <input type="text" id="bien_so_xe" name="bien_so_xe" maxlength="10" required>

            <!-- Giấy Phép Lái Xe -->
            <div class="checkbox-group">
                <input type="checkbox" id="co_giay_phep_lai_xe" name="co_giay_phep_lai_xe" onclick="toggleGiayPhep()">
                <label for="co_giay_phep_lai_xe">Có giấy phép lái xe</label>
            </div>

            <!-- Mã Số Giấy Phép Lái Xe -->
            <div id="ma_giay_phep_div" style="display:none;">
                <label for="ma_so_giay_phep_lai_xe">Mã Số Giấy Phép Lái Xe:</label>
                <input type="text" id="ma_so_giay_phep_lai_xe" name="ma_so_giay_phep_lai_xe">
            </div>

            <!-- Loại Xe -->
            <label for="loai_xe">Loại Xe:</label>
            <select id="loai_xe" name="loai_xe" required>
                <option value="">-- Chọn Loại Xe --</option>
                <?php
                if ($loai_xe_result->num_rows > 0) {
                    while($row = $loai_xe_result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id']);  
                        $name = htmlspecialchars($row['name']);  
                        echo "<option value='{$id}'> !! {$name} !!</option>";  
                    }
                }
                ?>
            </select>

            <!-- Loại Vi Phạm -->
            <label for="loai_vi_pham">Loại Vi Phạm:</label>
            <select id="loai_vi_pham" name="loai_vi_pham" required>
                <option value="">-- Chọn Loại Vi Phạm --</option>
                <?php
                if ($loai_vi_pham_result->num_rows > 0) {
                    while($row = $loai_vi_pham_result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id']);  
                        $name = htmlspecialchars($row['name']);  
                        echo "<option value='{$id}'> !! {$name} !!</option>"; 
                    }
                }
                ?>
            </select>

            <!-- Ngày Vi Phạm -->
            <label for="ngay_vi_pham">Ngày Vi Phạm:</label>
            <input type="date" id="ngay_vi_pham" name="ngay_vi_pham" required>

            <!-- Ghi Chú -->
            <label for="ghi_chu">Ghi Chú:</label>
            <textarea id="ghi_chu" name="ghi_chu" rows="4"></textarea>

            <!-- Nút Submit -->
            <div class="submit-btn">
                <input type="submit" value="Gửi">
            </div>
        </form>
        <div class="button-container">
            <button id="myBtn" class="myBtn">Open Modal</button>
        </div>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1>Hướng dẫn sử dụng hệ thống ghi nhận vi phạm ATGT</h1>
                <p></p>
            </div>
        </div>
    </div>
</body>
    <script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");

    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</html>
