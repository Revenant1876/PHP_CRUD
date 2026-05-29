<?php
include '../auth.php';
include '../config.php';

$id = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM registration WHERE id=$id");
$row = mysqli_fetch_assoc($res);

if (isset($_POST['update'])) {
    $n = trim($_POST['u_name']);
    $e = trim($_POST['u_email']);
    $c = trim($_POST['u_course']);
    $a = trim($_POST['u_age']);
    $g = trim($_POST['u_gender']);
    $s = trim($_POST['u_student_id']);

    mysqli_query($conn, "UPDATE registration SET full_name='$n', email='$e', course='$c', age='$a', gender='$g', student_id='$s' WHERE id=$id");
    header("Location: ../index.php?notify=updated");
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
                <div>
                    <label for="u_age">Age</label>
                    <input type="number" id="u_age" name="u_age" value="<?php echo htmlspecialchars($row['age']); ?>" min="18" max="100" required>
                </div>
                <div>
                    <label for="u_gender">Gender</label>
                    <select id="u_gender" name="u_gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male" <?php echo ($row['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($row['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($row['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div>
                    <label for="u_student_id">Student ID</label>
                    <input type="text" id="u_student_id" name="u_student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>" required>
                </div>
                <button type="submit" name="update" class="primary">Update Student</button>
            </form>
        </div>
    </div>
</body>
</html>