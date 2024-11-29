<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $incident_id = $_GET['id'];

    // Query to fetch the incident details
    $query = "SELECT * FROM incidents WHERE id = '$incident_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $incident = $result->fetch_assoc();
    } else {
        die("Incident not found.");
    }
} else {
    die("No incident ID specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/view_incident.css">
    <title>View Incident</title>
</head>
<body>
<div class="incident-details">
    <h1>Incident Details</h1>
    <p><strong>Title:</strong> <?php echo htmlspecialchars($incident['title']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($incident['description']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($incident['status']); ?></p>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
