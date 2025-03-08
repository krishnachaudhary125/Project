<?php
include '../../Database/connection.php';

if (isset($_GET['id'])) {
    $game_id = intval($_GET['id']);

    $check_query = "SELECT COUNT(*) AS game_count FROM games WHERE game_id = ?";
    $check_stmt = $conn->prepare($check_query);

    if ($check_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $check_stmt->bind_param("i", $game_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();
    $check_stmt->close();

    if ($row['game_count'] == 0) {
        echo "<script>alert('Game not found.');</script>";
        echo "<script>window.location.href = '../admin_panel.php?games';</script>";
        exit();
    }

    // Proceed with deletion
    $delete_query = "DELETE FROM games WHERE game_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $game_id);

    if ($stmt->execute()) {
        echo "<script>alert('Game deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting game: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    echo "<script>window.location.href = '../admin_panel.php?games';</script>";
} else {
    echo "<script>alert('No game ID specified.');</script>";
    echo "<script>window.location.href = '../admin_panel.php?games';</script>";
}
?>