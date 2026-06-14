<?php
// Start or resume the current PHP session so we can validate whether the user is logged in.
session_start();

// If the admin is not logged in, redirect to the login page.
// The relative path changes when this file is included from inside the CRUD folder.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ' . (strpos($_SERVER['PHP_SELF'], '/CRUD/') ? '../' : '') . 'login.php');
    exit();
}

// Ensure there is an active database connection available to the page.
if (!isset($conn)) {
    include __DIR__ . '/config.php';
}
?>
