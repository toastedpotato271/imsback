<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id']; // Assume the user ID is stored in session

    // Insert the report into the database
    $query = "INSERT INTO incidents (user_id, title, description, status) VALUES (?, ?, ?, 'open')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $title, $description);

    if ($stmt->execute()) {
        // Redirect to the dashboard or view the newly created incident
        header("Location: dashboard.php");
        exit();
    } else {
        die("Error submitting the report: " . $stmt->error);
    }
} else {
    // If the form wasn't submitted properly, redirect to the report page
    header("Location: report.php");
    exit();
}
?>
