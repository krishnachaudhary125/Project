<?php
include '../../Database/connection.php';

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']); 

    $delete_query = "DELETE FROM category WHERE category_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        echo "<script>alert('Category deleted successfully.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?category';</script>";
    } else {
        echo "<script>alert('Error deleting category.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?category';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No category ID specified.');</script>";
    echo "<script>window.location.href = '../admin_panel.php?category';</script>";
}
?>