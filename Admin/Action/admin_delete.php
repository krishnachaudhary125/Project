<?php
include '../../Database/connection.php';
session_start(); // Start the session to access logged-in admin information

if (isset($_GET['id'])) {
    $admin_id = intval($_GET['id']); // Sanitize the input

    // Get logged-in admin ID from the session
    $logged_in_admin_id = $_SESSION['admin_id'] ?? null;


    if ($admin_id === $logged_in_admin_id) {
        echo "<script>alert('You cannot delete the logged-in admin.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?admin';</script>";
        exit();
    }


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