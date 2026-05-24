<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

include '../config.php';

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM registration WHERE id=$id");
header("Location: ../index.php");
exit();
?>