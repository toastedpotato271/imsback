<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Management System</title>
    <link rel="stylesheet" href="src/css/index.css">
</head>
<body>
    <header>
        <h1>Welcome to the Incident Management System</h1>
    </header>
    <main>
        <h2>Manage your incidents efficiently</h2>
        <p>Track, report, and resolve incidents effectively.</p>
        
        <!-- Button Container -->
        <div class="btn-container">
            <!-- Login Button -->
            <a href="login.php" class="auth-btn">Login</a>

            <!-- Sign Up Button -->
            <a href="signup.php" class="auth-btn">Sign Up</a>

            <!-- Report an Incident Button -->
            <a href="report_registration.php" class="auth-btn report-btn">Report an Incident</a>
        </div>
    </main>
</body>
</html>


