<?php
include "header.php";
include "../Database/connection.php";

if (isset($_POST['submit']) == true) {
    $email = $_POST['email'];
    $psw = $_POST['psw'];
    $pswHash = sha1($psw);

    $sql = "SELECT user_id AS id, fullname, role FROM users WHERE email='$email' && password='$pswHash'
    UNION
    SELECT admin_id AS id, fullname, role FROM admin WHERE email='$email' && password='$pswHash'
";

    
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn)); 
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['role'] == 'admin') {
            $_SESSION['role'] = $row['role'];
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['fullname'];
            header('location: ../Admin/admin_panel.php?dashboard');
        } elseif ($row['role'] == 'user') {
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['fullname'];
            header('location:index.php');
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>
<div class="sign-in-container">
    <form action="#" method="post" class="sign-in">
        <h1>Sign In</h1>
        <div class="sign-in-form">
            <?php
            if (isset($error)) {
                foreach ($error as $errormsg) {
                    echo '<span class="error-msg">' . $errormsg . '</span>';
                }
            }
            ?>
            <div class="sign-in-field">
                <input type="email" id="email" name="email" value="" placeholder="Email Address">
            </div>
            <div class="sign-in-field">
                <input type="password" id="psw" name="psw" value="" placeholder="Password">
            </div>
            <button type="submit" id="submit" name="submit">SIGN IN</button>
        </div>
        <p class="sign-in-p">OR</p>
        <div class="sign-in-a">
            <!-- <a href="forgot_psw.php" target="_self">Forgot Password</a> -->
        </div>
        <div class="sign-in-a">
            <a href="sign_up.php" target="_self">Create account</a>
        </div>
    </form>
</div>

<?php
include "footer.php";
?>