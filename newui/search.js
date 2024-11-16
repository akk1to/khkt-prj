document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("searchForm");
    const searchType = document.getElementById("searchType");
    const searchInput = document.getElementById("searchInput");
    const dateRange = document.getElementById("dateRange");
    const resultsTableBody = document.querySelector("#resultsTable tbody");

    // Hiển thị ô nhập ngày khi chọn phương pháp tra cứu theo khoảng ngày
    searchType.addEventListener("change", function () {
        if (searchType.value === "date_range") {
            dateRange.style.display = "block";
            searchInput.disabled = true; // Ẩn ô nhập thông tin khi chọn khoảng ngày
        } else {
            dateRange.style.display = "none";
            searchInput.disabled = false; // Bật lại ô nhập thông tin
        }
    });

    // Xử lý form submit với AJAX
    searchForm.addEventListener("submitsearch", function (event) {
        event.preventDefault();

        // Lấy giá trị từ form
        const formData = new FormData(searchForm);
        
        // Gửi yêu cầu AJAX tới PHP
        fetch("search_students.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json()) // Nhận dữ liệu JSON từ server
        .then(data => {
            // Xóa các kết quả cũ
            resultsTableBody.innerHTML = "";

            // Hiển thị kết quả lên bảng
            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.ten_hoc_sinh}</td>
                    <td>${row.idlop}</td>
                    <td>${row.bien_so_xe}</td>
                    <td>${row.ngay_vi_pham}</td>
                    <td>${row.ghi_chu}</td>
                    <button class="edit-button" onclick="openModal(this)"><i class="fa-solid fa-pen"></i></button>
                <button class="delete-button"><i class="fa-solid fa-circle-xmark"></i></button>
                `;
                resultsTableBody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});
