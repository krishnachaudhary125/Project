<?php 
    include "header.php"
?>
    <div class="sign-in-container">
        <form action="#" method="post" class="sign-in">
            <h1>Sign In</h1>
            <div class="sign-in-form">
                <div class="sign-in-field">
                    <input type="email" id="email" name="email" value="" placeholder="Email Address">
                </div>
                <div class="sign-in-field">
                    <input type="password" id="psw" name="psw" value="" placeholder="Password">
                </div>
                <button type="submit">SIGN IN</button>
            </div>
            <p class="sign-in-p">OR</p>
            <div class="sign-in-a">
                <a href="#" target="_self">Forgot Password</a>
            </div>
            <div class="sign-in-a">
                <a href="sign_up.php" target="_self">Create account</a>
            </div>
        </form>
    </div>

<?php 
    include "footer.php"
?>