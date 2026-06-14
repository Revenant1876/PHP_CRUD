<?php
// Start the session to check whether the user is logged in.
session_start();

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Logout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-container">
        <div class="topbar">
            <h1>Confirm Logout</h1>
        </div>

        <div class="card">
            <p>Are you sure you want to logout? Your session will be closed and you will return to the login page.</p>
            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:20px;">
                <a href="index.php" class="button secondary" aria-label="Cancel logout"><span class="button-icon">✖️</span><span class="button-text">Cancel</span></a>
                <a href="logout.php?confirm=yes" class="button danger" aria-label="Confirm logout"><span class="button-icon">🚪</span><span class="button-text">Yes, logout</span></a>
            </div>
        </div>
    </div>
</body>
</html>