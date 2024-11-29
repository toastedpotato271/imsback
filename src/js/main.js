document.addEventListener("DOMContentLoaded", function() {
    // Login form validation
    const loginForm = document.querySelector('form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const username = document.querySelector('input[name="username"]').value;
            const password = document.querySelector('input[name="password"]').value;

            if (username === '' || password === '') {
                alert('Please fill out both fields');
                e.preventDefault();
            }
        });
    }

    // Signup form validation
    const signupForm = document.querySelector('form');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const username = document.querySelector('input[name="username"]').value;
            const password = document.querySelector('input[name="password"]').value;

            if (username === '' || password === '') {
                alert('Please fill out both fields');
                e.preventDefault();
            }
        });
    }

    // Fetch incidents dynamically for the dashboard
    function loadIncidents() {
        fetch('get_incidents.php')  // Assume get_incidents.php is a PHP script that returns incident data
            .then(response => response.json())
            .then(incidents => {
                const incidentTable = document.querySelector('#incidentTable');
                incidentTable.innerHTML = '';  // Clear the table before inserting new rows

                incidents.forEach(incident => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${incident.title}</td>
                        <td>${incident.status}</td>
                        <td>
                            <a href="#">View</a> |
                            <a href="#">Edit</a>
                        </td>
                    `;
                    incidentTable.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching incidents:', error));
    }

    // Load incidents when the page is ready
    if (document.querySelector('#incidentTable')) {
        loadIncidents();
    }

    // Submit report using AJAX
    function submitReport(event) {
        event.preventDefault();
        const title = document.querySelector('input[name="title"]').value;
        const description = document.querySelector('textarea[name="description"]').value;

        const data = new FormData();
        data.append('title', title);
        data.append('description', description);

        fetch('report.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.text())
        .then(result => {
            console.log(result);
            alert('Incident reported successfully!');
            window.location.href = 'dashboard.php';  // Redirect to the dashboard after submission
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error submitting report.');
        });
    }

    // Add event listener to the report form for AJAX submission
    const reportForm = document.querySelector('form');
    if (reportForm && reportForm.action === 'report.php') {
        reportForm.addEventListener('submit', submitReport);
    }
});
