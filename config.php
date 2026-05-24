<?php
$conn = mysqli_connect("localhost", "root", "", "StudentSystem");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>