<?php session_start();
include '../../Database/connection.php';


if (isset($_GET['id'])) {

    $admin_id = $_GET['id']; 

    $logged_in_admin_id = $_SESSION['admin_id'] ?? null;

    // Debugging logs
    error_log("Logged-in Admin ID: " . $logged_in_admin_id);
    error_log("Requested Admin ID for Deletion: " . $admin_id);

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