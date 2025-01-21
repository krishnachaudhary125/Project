<?php
include '../../Database/connection.php';

if (isset($_GET['id'])) {
    $suggestion_id = intval($_GET['id']);

    $delete_query = "DELETE FROM suggestions WHERE suggestion_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $suggestion_id);

    if ($stmt->execute()) {
        echo "<script>alert('Suggestion deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting Suggestion.');</script>";
    }

    $stmt->close();
    echo "<script>window.location.href = '../admin_panel.php?suggestion';</script>";
} else {
    echo "<script>alert('No suggestion ID specified.');</script>";
    echo "<script>window.location.href = '../admin_panel.php?suggestion';</script>";
}