-- Tạo cơ sở dữ liệu
USE s2677855_schooldb;

-- Bảng Khối

-- Bảng Loại Xe
CREATE TABLE IF NOT EXISTS loai_xe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Bảng Loại Vi Phạm
CREATE TABLE IF NOT EXISTS loai_vi_pham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Bảng Học Sinh và Thông Tin Vi Phạm
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_so_hoc_sinh CHAR(10) NOT NULL,
    ten_hoc_sinh VARCHAR(100) NOT NULL,
    ngay_sinh DATE NOT NULL,
    idlop TEXT,
    dia_chi VARCHAR(255) NOT NULL,
    ho_ten_cha VARCHAR(100) NOT NULL,
    sdt_cha CHAR(10) NOT NULL,
    ho_ten_me VARCHAR(100) NOT NULL,
    sdt_me CHAR(10) NOT NULL,
    bien_so_xe TEXT NOT NULL,
    co_giay_phep_lai_xe TINYINT(1) NOT NULL DEFAULT 0,
    ma_so_giay_phep_lai_xe CHAR(20),
    loai_xe_id INT NOT NULL,
    loai_vi_pham_id INT NOT NULL,
    ngay_vi_pham DATE NOT NULL,
    ghi_chu TEXT,
    FOREIGN KEY (loai_xe_id) REFERENCES loai_xe(id) ON DELETE CASCADE,
    FOREIGN KEY (loai_vi_pham_id) REFERENCES loai_vi_pham(id) ON DELETE CASCADE
);

-- Thêm dữ liệu vào bảng Loại Xe
INSERT INTO loai_xe (name) VALUES 
('Xe đạp điện'),
('Xe máy điện'),
('Xe 50cc'),
('Xe trên 50cc');

-- Thêm dữ liệu vào bảng Loại Vi Phạm
INSERT INTO loai_vi_pham (name) VALUES 
('Không đội mũ bảo hiểm'),
('Lái xe chưa đủ tuổi');
