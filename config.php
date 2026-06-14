<?php
// Establish a connection to the MySQL database used by the application.
$conn = mysqli_connect("localhost", "root", "", "StudentSystem");

// If the connection fails, stop execution and show an error message.
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>