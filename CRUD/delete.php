<?php
// Ensure the user is authenticated before allowing a delete operation.
include '../auth.php';
include '../config.php';

// Read the student ID from the URL and delete that record.
$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM registration WHERE id=$id");

// Redirect back to the student list with a delete notification.
header("Location: ../index.php?notify=deleted&count=1");
exit();
?>