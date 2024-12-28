<?php
include '../../Database/connection.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); 

    $delete_query = "DELETE FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $admin_id);

    if ($stmt->execute()) {
        echo "<script>alert('Admin deleted successfully.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?admin';</script>";
    } else {
        echo "<script>alert('Error deleting admin.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?admin';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No admin ID specified.');</script>";
    echo "<script>window.location.href = '../admin_panel.php?admin';</script>";
}
?>