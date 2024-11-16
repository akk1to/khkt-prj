// script.js
function openModal(button) {
    // Get row data from the clicked button
    if (!button || !(button instanceof HTMLElement)) {
        console.error('Invalid button element');
        return;
    }

    // Get row data from the clicked button
    const row = button.closest("tr");
    if (!row) {
        console.error('Could not find the parent row');
        return;
    }
    
    const id = row.getAttribute("data-id");
    const name = row.children[1].textContent;
    const studentClass = row.children[2].textContent;
    const plate = row.children[3].textContent;
    const date = row.children[4].textContent;
    const note = row.children[5].textContent;

    // Populate modal fields with row data
    document.getElementById("rowId").value = id;
    document.getElementById("name").value = name;
    document.getElementById("class").value = studentClass;
    document.getElementById("plate").value = plate;
    document.getElementById("date").value = date;
    document.getElementById("note").value = note;

    // Display the modal
    document.getElementById("editModal").style.display = "block";
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

function submitEditForm(event) {
    event.preventDefault(); // Prevent form from reloading the page

    const formData = new FormData(document.getElementById("editForm"));

    // Send data to PHP for updating the database
    fetch("update.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert("Data updated successfully");
        closeModal();
        location.reload(); // Reload page to see updated data
    })
    .catch(error => {
        console.error("Error updating data:", error);
    });
}
