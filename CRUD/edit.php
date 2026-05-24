<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

include '../config.php';

$id = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM registration WHERE id=$id");
$row = mysqli_fetch_assoc($res);

if (isset($_POST['update'])) {
    $n = trim($_POST['u_name']);
    $e = trim($_POST['u_email']);
    $c = trim($_POST['u_course']);

    mysqli_query($conn, "UPDATE registration SET full_name='$n', email='$e', course='$c' WHERE id=$id");
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="page-container">
        <div class="topbar">
            <h1>Edit Student</h1>
            <div>
                <a href="../index.php">Student List</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>

        <div class="card">
            <form method="POST">
                <div>
                    <label for="u_name">Name</label>
                    <input type="text" id="u_name" name="u_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" required>
                </div>
                <div>
                    <label for="u_email">Email</label>
                    <input type="email" id="u_email" name="u_email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                </div>
                <div>
                    <label for="u_course">Course</label>
                    <input type="text" id="u_course" name="u_course" value="<?php echo htmlspecialchars($row['course']); ?>" required>
                </div>
                <button type="submit" name="update" class="primary">Update Student</button>
            </form>
        </div>
    </div>
</body>
</html>