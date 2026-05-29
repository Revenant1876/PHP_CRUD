<?php
include '../auth.php';
include '../config.php';

$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM registration WHERE id=$id");
header("Location: ../index.php?notify=deleted");
exit();
?>