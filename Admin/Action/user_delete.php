<?php
include '../../Database/connection.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); 

    $delete_query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?users';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?users';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No user ID specified.');</script>";
    echo "<script>window.location.href = '../admin_panel.php?users';</script>";
}
?>