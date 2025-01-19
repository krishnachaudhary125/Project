<?php
include "header.php";
include "../Database/connection.php";

if (isset($_POST['submit'])) {
    $suggestion = $_POST['suggestion'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session during login

    if (empty($suggestion)) {
        $error = "Suggestion cannot be empty.";
    } else {
        // Insert suggestion into the database
        $query = "INSERT INTO suggestions (user_id, suggestion) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $user_id, $suggestion);

        if ($stmt->execute()) {
            echo "<script>alert('Suggestion submitted successfully.')</script>";
        } else {
            echo "<script>alert('Failed to submit suggestion. Please try again later.')</script>";
        }
    }
}
?>

<div class="suggestion-container">
    <form action="#" method="post" class="suggestion">
        <h1>Suggestion</h1>

        <div class="suggestion-field">
            <textarea name="suggestion" id="suggestion" placeholder="Enter Suggestion"></textarea>
        </div>
        <?php
            if (!empty($error)){
                    echo '<span class="error-msg">' . $error . '</span>';
            }
            ?>
        <button type="submit" id="submit" name="submit">Send</button>
    </form>
</div>

<?php
include "footer.php";
?>