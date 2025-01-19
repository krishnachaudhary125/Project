<?php
include "header.php";
include "../Database/connection.php";

if (isset($_POST['submit']) == true) {
    $opsw = $_POST['opsw'];
    $npsw = $_POST['npsw'];
    $cnpsw = $_POST['cnpsw'];

    $pswHash = sha1($opsw);

    $userId = $_SESSION['user_id'];

    $error = []; 
    if (empty($opsw) || empty($npsw) || empty($cnpsw)) {
        $error[] = 'All fields are required.';
    } elseif ($npsw !== $cnpsw) {
        $error[] = 'New password and confirm password do not match.';
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $npsw)) {
        $error[] = 'Password must be at least 8 characters long and contain one uppercase, one number, and one symbol.';
    } else {
        $query = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['password'] === $pswHash) {
                
                $newPswHash = sha1($npsw);

                $updateQuery = "UPDATE users SET password = ? WHERE user_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $newPswHash, $userId);

                if ($updateStmt->execute()) {
                    echo "<script>alert('Password changed successfully.')</script>";
                } else {
                    $error[] = 'Could not update password. Please try again later.';
                }
            } else {
                $error[] = 'Old password is incorrect.';
            }
        } else {
            $error[] = 'Could not find user.';
        }
    }
}
?>
<div class="change-psw-container">
    <form action="#" method="post" class="change-psw" name="change_psw">
        <h1>Change Password</h1>
        <div class="change-psw-form">
            <?php
            if (!empty($error)) {
                foreach ($error as $errormsg) {
                    echo '<span class="error-msg">' . $errormsg . '</span>';
                }
            }
            ?>
            <div class="change-psw-field">
                <input type="password" id="opsw" name="opsw" placeholder="Old Password">
            </div>
            <div class="change-psw-field">
                <input type="password" id="npsw" name="npsw" placeholder="New Password">
            </div>
            <div class="change-psw-field">
                <input type="password" id="cnpsw" name="cnpsw" placeholder="Confirm New Password">
            </div>
            <button type="submit" id="submit" name="submit">Confirm</button>
        </div>
        <p class="sign-in-p">OR</p>
        <div class="change-psw-a">
            <a href="forgot_psw.php" target="_self">Forgot Password</a>
        </div>
    </form>
</div>

<?php
include "footer.php";
?>