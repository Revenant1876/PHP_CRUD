<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ' . (strpos($_SERVER['PHP_SELF'], '/CRUD/') ? '../' : '') . 'login.php');
    exit();
}

if (!isset($conn)) {
    include __DIR__ . '/config.php';
}
?>
