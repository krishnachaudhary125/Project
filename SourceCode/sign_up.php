<?php
include "header.php";
include "./Database/connection.php";

if (isset($_POST['submit'])) {
    $fullname = $_POST['fname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $psw = $_POST['psw'];
    $cpsw = $_POST['cpsw'];

    if ($psw != $cpsw) {
        echo "<script>alert('Password not matched.')</script>";
    } else {
        $hashPsw = sha1($psw);

        $select_query = "SELECT * from users WHERE email = '$email'";
        $res_select = mysqli_query($conn, $select_query);
        $check = mysqli_num_rows($res_select);
        if ($check > 0) {
            echo "<script>alert('User with this email already exist.')</script>";
        } else {

            $sqlQuery = "INSERT INTO users (fullname, phone, email, password) VALUES ('$fullname', '$phone', '$email', '$hashPsw')";

            $result = mysqli_query($conn, $sqlQuery);
            if ($result) {
                echo "<script>alert('User created Succesfully.')</script>";
            }
        }
    }
}
?>
<div class="sign-up-container">
    <form action="#" method="post" class="sign-up" name="sign_up">
        <h1>Create Account</h1>
        <div class="sign-up-form">
            <div class="sign-up-field">
                <input type="text" id="fname" name="fname" value="" placeholder="Full Name">
            </div>
            <div class="sign-up-field">
                <input type="text" id="phone" name="phone" value="" placeholder="Mobile Number (Not Mandatory)">
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
            <button type="submit" name="submit">Create</button>
            <div class="sign-up-a">
                <p>By clicking the Create button you agree to our</p>
                <a href="#">terms and conditions.</a>
            </div>
            <div class="sign-up-a">
                <p>Already have an account? <a href="sign_in.php">Sign In</a> here</p>
            </div>
        </div>
    </form>
</div>
<script>
let formEle = document.sign_up,
    fname = formEle.fname,
    phone = formEle.phone,
    email = formEle.email,
    psw = formEle.psw,
    cpsw = formEle.cpsw;

let fieldArr = document.querySelectorAll(".sign-up-field");

fieldArr.forEach(field => {
    let span = document.createElement("span");
    field.append(span);
});

formEle.addEventListener("submit", e => {
    if (fname.value == '') {
        fname.nextElementSibling.innerText = "Full Name is required.";
        e.preventDefault();
    }
    if (phone.value == '') {
        phone.nextElementSibling.innerText = "Contact is required.";
        e.preventDefault();
    }
    if (email.value == '') {
        email.nextElementSibling.innerText = "E-Mail is required.";
        e.preventDefault();
    }
    if (psw.value == '') {
        psw.nextElementSibling.innerText = "Password is required.";
        e.preventDefault();
    }
    if (cpsw.value == '') {
        cpsw.nextElementSibling.innerText = "Password confirmation is required.";
        e.preventDefault();
    }
});

fname.addEventListener("keyup", function() {
    let fnamePtrn = /^[A-Z][a-z]+(?: [A-Z][a-z]+)+$/
    if (fnamePtrn.test(this.value) == false) {
        this.nextElementSibling.innerText = "First letter must be in capital."
    } else {
        this.nextElementSibling.innerText = "";
    }
});
phone.addEventListener("keyup", function() {
    let phonePtrn = /[0-9]{10}/g
    if (phonePtrn.test(this.value) == false) {
        this.nextElementSibling.innerText = "Invalid number."
    } else {
        this.nextElementSibling.innerText = "";
    }
});
email.addEventListener("keyup", function() {
    let emailPtrn = /^[\w-]+@([\w-]+\.)+[\w]{2,3}$/g
    if (emailPtrn.test(this.value) == false) {
        this.nextElementSibling.innerText = "Invalid email."
    } else {
        this.nextElementSibling.innerText = "";
    }
});
psw.addEventListener("keyup", function() {
    let pswPtrn = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
    if (pswPtrn.test(this.value) == false) {
        this.nextElementSibling.innerText =
            "Password must be 8 chararacter long and must contain at least one (symbol, number and capital letter)."
    } else {
        this.nextElementSibling.innerText = "";
    }
});
</script>
<?php
include "footer.php";
?>