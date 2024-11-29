<?php
session_start();
include('config.php');

// Check if user is logged in
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
    <link rel="stylesheet" href="src/css/edit_incident.css">
    <title>Edit Incident</title>
</head>
<body>
    <header>
        <h1>Edit Incident</h1>
    </header>
    <main>
        <div class="edit-incident-container">
            <h2>Incident Details</h2>
            <form action="update_incident.php?id=<?php echo $incident['id']; ?>" method="POST">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($incident['title']); ?>" required>

                <label for="description">Description:</label>
                <textarea name="description" id="description" required><?php echo htmlspecialchars($incident['description']); ?></textarea>

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="open" <?php echo $incident['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                    <option value="in-progress" <?php echo $incident['status'] == 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="closed" <?php echo $incident['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>

                <button type="submit">Update Incident</button>
            </form>
        </div>
    </main>
</body>
</html>
