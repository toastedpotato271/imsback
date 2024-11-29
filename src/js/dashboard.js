// dashboard.js

// Example of AJAX to update incident status without reloading the page
document.addEventListener("DOMContentLoaded", function () {
    // Get all the status dropdown forms
    const forms = document.querySelectorAll('form');

    // Attach event listeners to each form
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            const status = form.querySelector('select').value;
            const incidentId = form.querySelector('input[name="incident_id"]').value;

            // Send the form data via AJAX to update the status
            const formData = new FormData();
            formData.append('status', status);
            formData.append('incident_id', incidentId);

            fetch('update_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Incident status updated successfully!');
                location.reload(); // Reload the page after updating
            })
            .catch(error => {
                console.error('Error updating status:', error);
                alert('Failed to update status.');
            });
        });
    });
});

function searchIncidents() {
    var input = document.getElementById('search');
    var filter = input.value.toUpperCase();
    var rows = document.getElementById('incident-table').getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var titleCell = rows[i].getElementsByTagName('td')[1];
        if (titleCell) {
            var title = titleCell.textContent || titleCell.innerText;
            if (title.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}

function changeRowsPerPage(select) {
    var perPage = select.value;
    var url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    window.location.href = url.toString();
}

