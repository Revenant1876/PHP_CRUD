<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

include 'config.php';
$result = mysqli_query($conn, "SELECT * FROM registration");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-container">
        <div class="topbar">
            <h1>Student List</h1>
            <div>
                <a href="CRUD/add.php">Add Student</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="card table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['course']); ?></td>
                            <td class="action-links">
                                <a href="CRUD/edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="CRUD/delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>