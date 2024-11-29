<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the incident ID from the URL
    $incident_id = $_GET['id'];
    
    // Get the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Update the incident in the database
    $query = "UPDATE incidents SET title = ?, description = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $title, $description, $status, $incident_id);
    
    if ($stmt->execute()) {
        // Redirect to the updated incident view
        header("Location: view_incident.php?id=" . $incident_id);
        exit();
    } else {
        die("Error updating incident.");
    }
} else {
    die("Invalid request method.");
}
?>
