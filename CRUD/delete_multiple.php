<?php
// Ensure the request is executed by an authenticated user.
include '../auth.php';
include '../config.php';

if (isset($_POST['btn_delete_bulk'])) {
    // Verify the checkbox array exists and contains IDs.
    if (!empty($_POST['ids'])) {
        $all_ids = $_POST['ids'];

        // Convert values to integers and avoid invalid input.
        $sanitized_ids = array_map('intval', $all_ids);
        $id_list = implode(',', $sanitized_ids);

        // Delete all selected rows in one query.
        $sql = "DELETE FROM registration WHERE id IN ($id_list)";

        if (mysqli_query($conn, $sql)) {
            $deletedCount = count($sanitized_ids);
            header('Location: ../index.php?notify=deleted&count=' . $deletedCount);
            exit();
        }
    } else {
        header('Location: ../index.php?notify=no_selection');
        exit();
    }
}
?>