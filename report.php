<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit_report'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Sanitize inputs
    $title = $conn->real_escape_string($title);
    $description = $conn->real_escape_string($description);

    // Insert the incident into the database
    $query = "INSERT INTO incidents (user_id, title, description) VALUES ('$user_id', '$title', '$description')";
    if ($conn->query($query)) {
        echo "Incident reported successfully.";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/report.css">
    <title>Report Incident</title>
</head>
<body>
    <div class="container">
        <h1>Report Incident</h1>
        <form action="report.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <button type="submit" name="submit_report">Submit Report</button>
        </form>
    </div>
</body>
</html>
