<?php 
    include "header.php"
?>
    <div class="sign-up-container">
        <form action="#" method="post" class="sign-up">
            <h1>Create Account</h1>
            <div class="sign-up-form">
                <div class="sign-up-field">
                    <input type="fname" id="fname" name="fname" value="" placeholder="Full Name">
                </div>
                <div class="sign-up-field">
                    <input type="email" id="email" name="email" value="" placeholder="E-Mail">
                </div>
                <div class="sign-up-field">
                    <input type="password" id="psw" name="psw" value="" placeholder="Create Password">
                </div>
                <div class="sign-up-field">
                    <input type="password" id="cpsw" name="cpsw" value="" placeholder="Confirm Password">
                </div>
                <button type="submit">Create</button>
                <div class="sign-up-a">
                    <p>By clicking the Create button you agree to our</p>
                    <a href="#">terms and conditions.</a>
                </div>
                <div class="sign-up-a">
                    <p>Already have an account? <a href="sign_in.php">Sign In here</a></p>
                </div>
            </div>
        </form>
    </div>

<?php 
    include "footer.php"
?>