<?php
/**
 * Authentication file to be included in all protected pages
 * Ensures user is logged in before accessing any admin pages
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ' . (strpos($_SERVER['PHP_SELF'], '/CRUD/') ? '../' : '') . 'login.php');
    exit();
}

// Optional: Include database connection if needed
if (!isset($conn)) {
    include __DIR__ . '/config.php';
}
?>
