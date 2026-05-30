<?php
include 'auth.php';
include 'config.php';

// Pagination and Search Logic
$items_per_page = isset($_GET['items']) ? (int)$_GET['items'] : 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Validate items per page
if (!in_array($items_per_page, [5, 10, 25, 50])) {
    $items_per_page = 10;
}

// Calculate offset
$offset = ($current_page - 1) * $items_per_page;

// Build query with search filter
$search_condition = '';
if (!empty($search_query)) {
    $search_query_escaped = mysqli_real_escape_string($conn, $search_query);
    $search_condition = " WHERE full_name LIKE '%$search_query_escaped%' 
                         OR email LIKE '%$search_query_escaped%' 
                         OR course LIKE '%$search_query_escaped%' 
                         OR student_id LIKE '%$search_query_escaped%'";
}

// Get total count for pagination
$count_query = "SELECT COUNT(*) as total FROM registration" . $search_condition;
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $items_per_page);

// Ensure current page is valid
if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $items_per_page;
}

// Get paginated results
$result = mysqli_query($conn, "SELECT * FROM registration" . $search_condition . " LIMIT $offset, $items_per_page");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .search-pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .search-box input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        .items-per-page {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .items-per-page select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }

        .pagination .active {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }

        .pagination .disabled {
            color: #ccc;
            cursor: not-allowed;
            background-color: #f5f5f5;
        }

        .page-info {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }

        .no-results {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            font-size: 16px;
        }
    </style>
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

        <?php if (isset($_GET['notify'])): ?>
            <?php if ($_GET['notify'] === 'added'): ?>
                <div class="notification success">
                    ✓ Student added successfully!
                </div>
            <?php elseif ($_GET['notify'] === 'deleted'): ?>
                <div class="notification success">
                    ✓ Student deleted successfully!
                </div>
            <?php elseif ($_GET['notify'] === 'updated'): ?>
                <div class="notification success">
                    ✓ Student updated successfully!
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="card">
            <!-- Search and Pagination Controls -->
            <div class="search-pagination-container">
                <div class="search-box">
                    <form method="GET" style="display: flex; gap: 10px;">
                        <input type="text" name="search" placeholder="Search by name, email, course, or student ID..." 
                               value="<?php echo htmlspecialchars($search_query); ?>" autocomplete="off">
                        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Search</button>
                        <?php if (!empty($search_query)): ?>
                            <a href="index.php" style="padding: 10px 20px; background-color: #999; color: white; border: none; border-radius: 4px; text-decoration: none; text-align: center;">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="items-per-page">
                    <label for="items">Show per page:</label>
                    <form method="GET" style="display: inline;">
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                        <select name="items" id="items" onchange="this.form.submit();">
                            <option value="5" <?php echo $items_per_page == 5 ? 'selected' : ''; ?>>5</option>
                            <option value="10" <?php echo $items_per_page == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $items_per_page == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $items_per_page == 50 ? 'selected' : ''; ?>>50</option>
                        </select>
                    </form>
                </div>
            </div>

            <?php if ($total_records > 0): ?>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Student ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td class="action-links">
                                        <a href="CRUD/edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                                        <a href="CRUD/delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <div class="page-info">
                    Showing <?php echo ($offset + 1); ?> to <?php echo min($offset + $items_per_page, $total_records); ?> of <?php echo $total_records; ?> students
                    <?php if (!empty($search_query)): ?>
                        (filtered from search)
                    <?php endif; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <!-- Previous Button -->
                        <?php if ($current_page > 1): ?>
                            <a href="?page=1&items=<?php echo $items_per_page; ?>&search=<?php echo urlencode($search_query); ?>">« First</a>
                            <a href="?page=<?php echo $current_page - 1; ?>&items=<?php echo $items_per_page; ?>&search=<?php echo urlencode($search_query); ?>">‹ Previous</a>
                        <?php else: ?>
                            <span class="disabled">« First</span>
                            <span class="disabled">‹ Previous</span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        if ($start_page > 1): ?>
                            <span>...</span>
                        <?php endif;

                        for ($i = $start_page; $i <= $end_page; $i++):
                            $active_class = ($i == $current_page) ? 'active' : '';
                        ?>
                            <a href="?page=<?php echo $i; ?>&items=<?php echo $items_per_page; ?>&search=<?php echo urlencode($search_query); ?>" class="<?php echo $active_class; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor;

                        if ($end_page < $total_pages): ?>
                            <span>...</span>
                        <?php endif; ?>

                        <!-- Next Button -->
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $current_page + 1; ?>&items=<?php echo $items_per_page; ?>&search=<?php echo urlencode($search_query); ?>">Next ›</a>
                            <a href="?page=<?php echo $total_pages; ?>&items=<?php echo $items_per_page; ?>&search=<?php echo urlencode($search_query); ?>">Last »</a>
                        <?php else: ?>
                            <span class="disabled">Next ›</span>
                            <span class="disabled">Last »</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-results">
                    <?php if (!empty($search_query)): ?>
                        No students found matching "<?php echo htmlspecialchars($search_query); ?>". Try a different search term.
                    <?php else: ?>
                        No students in the system yet.
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
