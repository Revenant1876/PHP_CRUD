<?php
// Require authentication for the student list page and open the database connection.
include 'auth.php';
include 'config.php';

// Handle pagination and search query values from URL parameters.
$items_per_page = isset($_GET['items']) ? (int)$_GET['items'] : 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Only allow a small set of valid page sizes.
if (!in_array($items_per_page, [5, 10, 25, 50])) {
    $items_per_page = 10;
}

// Calculate record offset for the current page.
$offset = ($current_page - 1) * $items_per_page;

// Build a search condition if the user has entered a query.
$search_condition = '';
if (!empty($search_query)) {
    $search_query_escaped = mysqli_real_escape_string($conn, $search_query);
    $search_condition = " WHERE full_name LIKE '%$search_query_escaped%' " .
                        "OR email LIKE '%$search_query_escaped%' " .
                        "OR course LIKE '%$search_query_escaped%' " .
                        "OR student_id LIKE '%$search_query_escaped%'";
}

// Count total matching records to render pagination correctly.
$count_query = "SELECT COUNT(*) as total FROM registration" . $search_condition;
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $items_per_page);

// If the current page is beyond the last page, adjust to the last page.
if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $items_per_page;
}

// Read the rows to display on the current page.
$result = mysqli_query($conn, "SELECT * FROM registration" . $search_condition . " LIMIT $offset, $items_per_page");
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
                <a href="CRUD/add.php" class="button primary" aria-label="Add student"><span class="button-icon">➕</span><span class="button-text">Add Student</span></a>
                <a href="logout.php" class="button warn" aria-label="Logout"><span class="button-icon">🔒</span><span class="button-text">Logout</span></a>
            </div>
        </div>

        <?php
            // Determine if a notification should be shown based on the URL parameter.
            $notification = null;
            $notificationCount = isset($_GET['count']) ? intval($_GET['count']) : 0;
            if (isset($_GET['notify'])) {
                if ($_GET['notify'] === 'added') {
                    if ($notificationCount > 1) {
                        $notification = ['class' => 'success', 'message' => "✓ {$notificationCount} students added successfully!"];
                    } else {
                        $notification = ['class' => 'success', 'message' => '✓ Student added successfully!'];
                    }
                } elseif ($_GET['notify'] === 'deleted') {
                    if ($notificationCount > 1) {
                        $notification = ['class' => 'danger', 'message' => "✓ {$notificationCount} students deleted successfully!"];
                    } else {
                        $notification = ['class' => 'danger', 'message' => '✓ Student deleted successfully!'];
                    }
                } elseif ($_GET['notify'] === 'updated') {
                    if ($notificationCount > 1) {
                        $notification = ['class' => 'info', 'message' => "✓ {$notificationCount} students updated successfully!"];
                    } else {
                        $notification = ['class' => 'info', 'message' => '✓ Student updated successfully!'];
                    }
                } elseif ($_GET['notify'] === 'no_selection') {
                    $notification = ['class' => 'danger', 'message' => 'Please select at least one student to delete.'];
                }
            }
        ?>

        <?php if ($notification): ?>
            <div class="notification <?php echo $notification['class']; ?>" id="pageNotification">
                <?php echo htmlspecialchars($notification['message']); ?>
                <button type="button" class="close-button" aria-label="Dismiss notification" onclick="dismissNotification()">×</button>
            </div>
        <?php endif; ?>

        <!-- Notification area displays messages after add/edit/delete actions. -->

        <div class="card">
            <!-- Search and Pagination Controls -->
            <div class="search-pagination-container">
                <div class="search-box">
                    <form method="GET" style="display: flex; gap: 10px;">
                        <input type="text" name="search" placeholder="Search by name, email, course, or student ID..." 
                               value="<?php echo htmlspecialchars($search_query); ?>" autocomplete="off">
                        <button type="submit" class="button info" aria-label="Search students"><span class="button-icon">🔎</span><span class="button-text">Search</span></button>
                        <?php if (!empty($search_query)): ?>
                            <a href="index.php" class="button secondary" aria-label="Clear search"><span class="button-icon">✖️</span><span class="button-text">Clear</span></a>
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

                <div class="bulk-actions">
                    <button type="button" class="button info" id="toggleSelectionModeBtn" onclick="toggleSelectionMode()" aria-label="Toggle selection mode"><span class="button-icon">☑️</span><span class="button-text">Select Items</span></button>
                    <button type="button" class="button danger hidden" id="bulkDeleteBtn" onclick="confirmBulkDelete()" disabled aria-label="Delete selected students"><span class="button-icon">🗑️</span><span class="button-text">Delete Selected</span></button>
                </div>
                <div class="selection-hint hidden" id="selectionHint">Select the checkboxes to delete multiple students.</div>
            </div>

            <?php if ($total_records > 0): ?>
                <div class="table-wrapper">
                    <form method="POST" action="CRUD/delete_multiple.php" id="bulkDeleteForm">
                        <input type="hidden" name="btn_delete_bulk" value="1">
                        <table id="studentTable">
                            <thead>
                                <tr>
                                    <th class="select-col">
                                        <label class="gl-checkbox gl-checkbox--compact" aria-label="Select all students">
                                            <input class="gl-checkbox__input" type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                                            <span class="gl-checkbox__box">
                                                <svg class="gl-checkbox__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span class="gl-checkbox__label sr-only">Select all students</span>
                                        </label>
                                    </th>
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
                                    <td class="select-col">
                                        <label class="gl-checkbox gl-checkbox--compact" aria-label="Select student">
                                            <input class="gl-checkbox__input row-checkbox" type="checkbox" name="ids[]" value="<?php echo $row['id']; ?>" onchange="updateBulkButton()">
                                            <span class="gl-checkbox__box">
                                                <svg class="gl-checkbox__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                            <span class="gl-checkbox__label sr-only">Select student</span>
                                        </label>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td class="action-links">
                                        <a href="CRUD/edit.php?id=<?php echo $row['id']; ?>" class="button secondary expanding-button" aria-label="Edit student" data-label="Edit"><span class="button-icon">✏️</span><span class="button-text">Edit</span></a>
                                        <button type="button" class="button danger expanding-button" onclick="confirmDelete('CRUD/delete.php?id=<?php echo $row['id']; ?>')" aria-label="Delete student" data-label="Delete"><span class="button-icon">🗑️</span><span class="button-text">Delete</span></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
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

    <div class="dialog-overlay hidden" id="confirmDialog" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="dialog-content" role="document">
            <div class="dialog-header">
                <h2 class="dialog-title">Confirm delete</h2>
                <p class="dialog-description" id="dialogMessage">Are you sure you want to delete this item? This action cannot be undone.</p>
            </div>
            <div class="dialog-footer">
                <button type="button" class="button secondary" onclick="hideDialog()" aria-label="Cancel"><span class="button-icon">✖️</span><span class="button-text">Cancel</span></button>
                <button type="button" class="button danger" id="confirmButton" aria-label="Confirm delete"><span class="button-icon">🗑️</span><span class="button-text">Delete</span></button>
            </div>
        </div>
    </div>

    <script src="main.js"></script>
</body>
</html>