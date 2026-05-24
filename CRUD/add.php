<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

include '../config.php';

$error = '';

if (isset($_POST['save'])) {
    $name = trim($_POST['txt_name']);
    $email = trim($_POST['txt_email']);
    $course = trim($_POST['txt_course']);

    if ($name === '' || $email === '' || $course === '') {
        $error = 'Please fill in every field.';
    } else {
        mysqli_query(
            $conn,
            "INSERT INTO registration (full_name, email, course) VALUES ('$name', '$email', '$course')"
        );
        header('Location: ../index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="page-container">
        <div class="topbar">
            <h1>Add Student</h1>
            <div>
                <a href="../index.php">Student List</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>

        <div class="card">
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div>
                    <label for="txt_name">Name</label>
                    <input type="text" id="txt_name" name="txt_name" placeholder="Enter student name" required>
                </div>
                <div>
                    <label for="txt_email">Email</label>
                    <input type="email" id="txt_email" name="txt_email" placeholder="Enter student email" required>
                </div>
                <div>
                    <label for="txt_course">Course</label>
                    <input type="text" id="txt_course" name="txt_course" placeholder="Enter course name" required>
                </div>
                <button type="submit" name="save" class="primary">Save Student</button>
            </form>
        </div>
    </div>
</body>
</html>