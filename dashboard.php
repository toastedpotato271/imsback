<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role']; // Get the user's role (admin or user)

// Get the current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10; // Default to 10 rows per page

$start = ($page - 1) * $per_page; // Calculate the starting point

// Query to fetch incidents for the logged-in user or all incidents if the user is admin
if ($role == 'admin') {
    // Admin can see all incidents with pagination
    $query = "SELECT * FROM incidents LIMIT $start, $per_page";
} else {
    // Regular users can only see their own incidents with pagination
    $query = "SELECT * FROM incidents WHERE user_id = '$user_id' LIMIT $start, $per_page";
}

$result = $conn->query($query);

// Check if query executed successfully
if (!$result) {
    die("Error with the query: " . $conn->error);
}

// Query to get total number of incidents (to calculate pages)
$total_query = "SELECT COUNT(*) AS total FROM incidents";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $per_page); // Calculate total pages

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="src/css/dashboard.css">
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <nav>
            <a href="logout.php">Logout</a>
            <a href="report.php">Create Incident</a>
        </nav>
    </header>
    <main>
        <h2>Your Incidents</h2>
        
        <!-- Search Bar -->
        <div>
            <input type="text" id="search" placeholder="Search incidents..." onkeyup="searchIncidents()">
            <button onclick="searchIncidents()">Search</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="incident-table">
                <?php
                if ($result->num_rows > 0) {
                    $counter = $start + 1; // To number the rows
                    while ($incident = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>$counter</td>"; // Display row number
                        echo "<td>" . htmlspecialchars($incident['title']) . "</td>";
                        
                        // Admin can change the status
                        if ($role == 'admin') {
                            echo "<td>";
                            echo "<form method='POST' action='update_status.php'>";
                            echo "<select name='status' onchange='this.form.submit()'>";
                            echo "<option value='open'" . ($incident['status'] == 'open' ? ' selected' : '') . ">Open</option>";
                            echo "<option value='in-progress'" . ($incident['status'] == 'in-progress' ? ' selected' : '') . ">In Progress</option>";
                            echo "<option value='closed'" . ($incident['status'] == 'closed' ? ' selected' : '') . ">Closed</option>";
                            echo "</select>";
                            echo "<input type='hidden' name='incident_id' value='" . $incident['id'] . "'>";
                            echo "</form>";
                            echo "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($incident['status']) . "</td>";
                        }
                        
                        echo "<td><a href='view_incident.php?id=" . $incident['id'] . "'>View</a> | <a href='edit_incident.php?id=" . $incident['id'] . "'>Edit</a></td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='4'>No incidents found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <span>Rows per page:</span>
            <select onchange="changeRowsPerPage(this)">
                <option value="10" <?= $per_page == 10 ? 'selected' : '' ?>>10</option>
                <option value="25" <?= $per_page == 25 ? 'selected' : '' ?>>25</option>
                <option value="50" <?= $per_page == 50 ? 'selected' : '' ?>>50</option>
            </select>

            <div>
                <?php
                // Display pagination buttons
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='dashboard.php?page=$i&per_page=$per_page' class='pagination-button'>$i</a>";
                }
                ?>
            </div>
        </div>

    </main>
</body>
<script src="src/js/dashboard.js"></script>
</html>
