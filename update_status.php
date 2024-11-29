<?php
session_start();
include('config.php');

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['status']) && isset($_POST['incident_id'])) {
    $status = $_POST['status'];
    $incident_id = $_POST['incident_id'];

    // Update the status of the incident in the database
    $query = "UPDATE incidents SET status = '$status' WHERE id = '$incident_id'";

    if ($conn->query($query)) {
        // Redirect back to the dashboard after the status is updated
        header("Location: dashboard.php");
        exit();
    } else {
        die("Error updating status: " . $conn->error);
    }
}
?>

<link rel="stylesheet" href="src/css/update_status.css">
