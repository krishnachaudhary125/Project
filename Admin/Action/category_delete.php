<?php
include '../../Database/connection.php';

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']); 

    $check_query = "SELECT COUNT(*) AS game_count FROM games WHERE category_id = ?";
    $check_stmt = $conn->prepare($check_query);

    if ($check_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $check_stmt->bind_param("i", $category_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();
    $check_stmt->close();

    if ($row['game_count'] > 0) {
        echo "<script>alert('There is a game with this category, it cannot be deleted.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?category';</script>";
        exit();
    }

    $delete_query = "DELETE FROM category WHERE category_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        echo "<script>alert('Category deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting category.');</script>";
    }

    $stmt->close();
    echo "<script>window.location.href = '../admin_panel.php?category';</script>";
} else {
    echo "<script>alert('No category ID specified.');</script>";
    echo "<script>window.location.href = '../admin_panel.php?category';</script>";
}
?>