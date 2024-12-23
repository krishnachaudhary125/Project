<?php
include "header.php";
include "/Project/Database/connection.php";

if (isset($_POST['submit']) == true) {
    $email = $_POST['email'];
    $psw = $_POST['psw'];
    if ($email != '' && $psw != '') {
        $sql = "SELECT id, fullname, email, password FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $sql);
        $sqli = "SELECT id, email, password FROM admin WHERE email='$email'";
        $result = mysqli_query($conn, $sqli);

        if ($res->num_rows > 0) {
            $pswHash = sha1($psw);
            while ($row = mysqli_fetch_assoc($res)) {
                // echo $pswHash . " + " . $row['password'];
                if ($pswHash == $row['password']) {
                    $_SESSION['fname'] = $row['fullname'];
                    $_SESSION['login_status'] = true;
                    $_SESSION['login_msg'] = "Login successfull.";
                    header("location: ./index.php");
                } else {
                    $_SESSION['psw_err'] = "Password not matched.";
                }
            }
        }
        if ($result->num_rows > 0) {
            $pswHash = sha1($psw);
            while ($row = mysqli_fetch_assoc($result)) {
                // echo $pswHash . " + " . $row['password'];
                if ($pswHash == $row['password']) {
                    $_SESSION['login_status'] = true;
                    $_SESSION['login_msg'] = "Login successfull.";
                    header("location: ./Admin/admin_panel.php?dashboard");
                } else {
                    $_SESSION['psw_err'] = "Password not matched.";
                }
            }
        } else {
            $_SESSION['user_err'] = "E-Mail not matched!";
        }
    }
}
?>
<div class="sign-in-container">
    <form action="#" method="post" class="sign-in">
        <h1>Sign In</h1>
        <div class="sign-in-form">
            <div class="sign-in-field">
                <input type="email" id="email" name="email" value="" placeholder="Email Address">
                <span><?php echo isset($_SESSION['user_err']) ? $_SESSION['user_err'] : ''; ?></span>
            </div>
            <div class="sign-in-field">
                <input type="password" id="psw" name="psw" value="" placeholder="Password">
                <span><?php echo isset($_SESSION['psw_err']) ? $_SESSION['psw_err'] : ''; ?></span>
            </div>
            <button type="submit" id="submit" name="submit">SIGN IN</button>
        </div>
        <p class="sign-in-p">OR</p>
        <div class="sign-in-a">
            <a href="forgot_psw.php" target="_self">Forgot Password</a>
        </div>
        <div class="sign-in-a">
            <a href="sign_up.php" target="_self">Create account</a>
        </div>
    </form>
</div>

<?php
include "footer.php";
?>