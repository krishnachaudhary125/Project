<?php
include "header.php";
include "../Database/connection.php";

if (isset($_POST['submit'])) {
    $fullname = $_POST['fname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $psw = $_POST['psw'];
    $cpsw = $_POST['cpsw'];

    if ($psw != $cpsw) {
        echo "<script>alert('Incorrect Password')</script>";
    } else {
        $hashPsw = sha1($psw);

        $select_query = "SELECT * from users WHERE email = '$email' union SELECT * from admin WHERE email = '$email'";
        $res_select = mysqli_query($conn, $select_query);
        $check = mysqli_num_rows($res_select);
        if ($check > 0) {
            echo "<script>alert('User with this email already exist.')</script>";
        } else {

            $sqlQuery = "INSERT INTO users (fullname, phone, email, password) VALUES ('$fullname', '$phone', '$email', '$hashPsw')";

            $result = mysqli_query($conn, $sqlQuery);
            if ($result) {
                echo "<script>alert('User created Succesfully.')</script>";
                header('location:sign_in.php');
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
                <input type="text" id="phone" name="phone" value="" placeholder="Mobile Number">
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
document.addEventListener("DOMContentLoaded", () => {
    const formEle = document.sign_up,
        fname = formEle.fname,
        phone = formEle.phone,
        email = formEle.email,
        psw = formEle.psw,
        cpsw = formEle.cpsw;

    formEle.addEventListener("submit", e => {
        let isValid = true;

        const clearError = (field) => {
            if (field.nextElementSibling) {
                field.nextElementSibling.innerText = "";
            }
        };

        const setError = (field, message) => {
            field.nextElementSibling.innerText = message;
            isValid = false;
        };

        // Full name validation
        if (!/^[A-Z][a-z]+(?: [A-Z][a-z]+)+$/.test(fname.value)) {
            setError(fname,
                "Full Name must start with capital letters and surname should be added aswell.");
        } else {
            clearError(fname);
        }

        // Phone validation
        if (phone.value !== "" && !/^(98|97)\d{8}$/
            .test(phone.value)) {
            setError(phone, "Phone number must be 10 digits and start with 98 or 97.");
        } else {
            clearError(phone);
        }

        // Email validation
        if (!/^[\w-]+@([\w-]+\.)+[\w]{2,3}$/.test(email.value)) {
            setError(email, "Invalid email format.");
        } else {
            clearError(email);
        }

        // Password validation
        if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(psw.value)) {
            setError(psw,
                "Password must be at least 8 characters long and contain one uppercase, one number, and one symbol."
            );
        } else {
            clearError(psw);
        }

        // Confirm password validation
        if (psw.value !== cpsw.value) {
            setError(cpsw, "Passwords do not match.");
        } else {
            clearError(cpsw);
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Added span for error messages
    document.querySelectorAll(".sign-up-field").forEach(field => {
        let span = document.createElement("span");
        span.style.color = "red";
        span.style.fontSize = "12px";
        field.appendChild(span);
    });
});
</script>
<?php
include "footer.php";
?>