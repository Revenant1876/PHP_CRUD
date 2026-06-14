<?php
// Ensure only authenticated users can add students.
include '../auth.php';
include '../config.php';

// Holds validation error messages for display.
$error = '';

// Handle form submission when the Save button is pressed.
if (isset($_POST['save'])) {
    $name = trim($_POST['txt_name']);
    $email = trim($_POST['txt_email']);
    $course = trim($_POST['txt_course']);
    $age = trim($_POST['txt_age']);
    $gender = trim($_POST['txt_gender']);
    $student_id = trim($_POST['txt_student_id']);

    // Verify that no required field is empty.
    if ($name === '' || $email === '' || $course === '' || $age === '' || $gender === '' || $student_id === '') {
        $error = 'Please fill in every field.';
    } else {
        // Add the new student record to the database.
        mysqli_query(
            $conn,
            "INSERT INTO registration (full_name, email, course, age, gender, student_id) VALUES ('$name', '$email', '$course', '$age', '$gender', '$student_id')"
        );

        // Redirect back to the list page and show a success notification.
        header('Location: ../index.php?notify=added&count=1');
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
                <a href="../index.php" class="button secondary" aria-label="Student list"><span class="button-icon">📋</span><span class="button-text">Student List</span></a>
                <a href="../logout.php" class="button warn" aria-label="Logout"><span class="button-icon">🔒</span><span class="button-text">Logout</span></a>
            </div>
        </div>

        <div class="card">
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- Student creation form -->
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
                <div>
                    <label for="txt_age">Age</label>
                    <input type="number" id="txt_age" name="txt_age" placeholder="Enter age" min="18" max="100" required>
                </div>
                <div>
                    <label for="txt_gender">Gender</label>
                    <select id="txt_gender" name="txt_gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="txt_student_id">Student ID</label>
                    <input type="text" id="txt_student_id" name="txt_student_id" placeholder="e.g., 2020-0000abc" required>
                </div>
                <button type="submit" name="save" class="primary">Save Student</button>
            </form>
        </div>
    </div>
</body>
</html>