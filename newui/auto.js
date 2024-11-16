function fetchStudentData() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "./manual.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                // Attempt to parse JSON response
                const response = JSON.parse(xhr.responseText);

                if (response.error) {
                    console.error(response.error);
                    document.getElementById("resultsTable").getElementsByTagName("tbody")[0].innerHTML = `<tr><td colspan="9">${response.error}</td></tr>`;
                    return;
                }

                const students = response;
                const tableBody = document.getElementById("studentsTable").getElementsByTagName("tbody")[0];
                tableBody.innerHTML = ""; // Clear any existing rows

                students.forEach(student => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${student.id ?? ''}</td>
                        <td>${student.ten_hoc_sinh ?? ''}</td>
                        <td>${student.idlop ?? ''}</td>
                        <td>${student.bien_so_xe ?? ''}</td>
                        <td>${student.ngay_vi_pham ?? ''}</td>
                        <td>${student.ghi_chu ?? ''}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } catch (e) {
                // If parsing fails, log the raw response
                console.error("Response is not valid JSON:", xhr.responseText);
            }
        } else {
            console.error("Failed to fetch data.");
        }
    };
    xhr.onerror = function() {
        console.error("Request error...");
    };
    xhr.send();
}

window.onload = fetchStudentData;
