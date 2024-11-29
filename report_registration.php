<?php
session_start();
include('config.php');

// Check if the form is submitted
if (isset($_POST['register_report'])) {
    // Get the data from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if the email already exists
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email already exists. Please log in.";
        } else {
            // Directly use the password without hashing
            // Insert the new user into the users table
            $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                // Get the user_id of the newly registered user
                $user_id = $stmt->insert_id;

                // Insert the report into the incidents table
                $query = "INSERT INTO incidents (user_id, title, description) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iss", $user_id, $title, $description);

                if ($stmt->execute()) {
                    header("Location: login.php"); // After submission, redirect to login
                    exit();
                } else {
                    $error_message = "Error submitting report.";
                }
            } else {
                $error_message = "Error registering user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/report_registration.css">
    <title>Report Incident</title>
</head>
<body>
    <div class="container">
        <h1>Report Incident</h1>

        <!-- Display error messages if any -->
        <?php if (isset($error_message)) { echo "<p style='color: red; text-align: center;'>$error_message</p>"; } ?>

        <!-- Report Form -->
        <form action="report_registration.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <p>A signup is required to be able to submit a report. Please register below:</p>

            <!-- Registration form fields -->
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit" name="register_report">Register and Submit Report</button>
        </form>
    </div>
</body>
</html>
