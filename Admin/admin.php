<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $fullname = $_POST['adminName'];
    $phone = $_POST['adminPhone'];
    $email = $_POST['adminEmail'];
    $psw = $_POST['adminPsw'];
    $cpsw = $_POST['adminCpsw'];

    if ($psw != $cpsw) {
        echo "<script>alert('Password not matched.')</script>";
    } else {
        $hashPsw = sha1($psw);

        $select_query = "SELECT * from admin WHERE email = '$email'";
        $res_select = mysqli_query($conn, $select_query);
        $check = mysqli_num_rows($res_select);
        if ($check > 0) {
            echo "<script>alert('Admin with this email already exist.')</script>";
        } else {

            $sqlQuery = "INSERT INTO admin (fullname, phone, email, password) VALUES ('$fullname', '$phone', '$email', '$hashPsw')";

            $result = mysqli_query($conn, $sqlQuery);
            if ($result) {
                echo "<script>alert('Admin created Succesfully.')</script>";
            }
        }
    }
}
?>


<div class="popup" id="addAdminPopup">
    <div class="add-admin-popup">
        <div class="add-admin-header">
            <h1 class="add-admin-title">Add Admin</h1>
            <span class="close-btn" onclick="closeFunction()">&times;</span>
        </div>
        <div class="admin-popup-body">
            <form action="#" method="post" name="add_admin_popup">
                <div class="add-admin-field">
                    <input type="text" id="adminName" name="adminName" value="" placeholder="Full Name">
                </div>
                <div class="add-admin-field">
                    <input type="text" id="adminPhone" name="adminPhone" value="" placeholder="Phone no.">
                </div>
                <div class="add-admin-field">
                    <input type="text" id="adminEmail" name="adminEmail" value="" placeholder="E-Mail">
                </div>
                <div class="add-admin-field">
                    <input type="password" id="adminPsw" name="adminPsw" value="" placeholder="Password">
                </div>
                <div class="add-admin-field">
                    <input type="password" id="adminCpsw" name="adminCpsw" value="" placeholder="Confirm Password">
                </div>
                <div class="add-admin-button">
                    <button type="submit" onclick="submitAdmin()" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="dashboard-body">
    <div class="admin-header">
        <h1 class="admin-title">Admin</h1>
        <button type="submit" class="admin-popup-button" onclick="myFunction()">Add Admin</button>
    </div>

    <div class="admin-body">
        <div class="admin-data">
            <table>
                <thead>
                    <tr>
                        <th class="thsno">S.No.</th>
                        <th class="thname">Fullname</th>
                        <th class="thphone">Phone No.</th>
                        <th class="themail">E-Mail</th>
                        <th class="thaction" colspan="2">Actions</th>
                    </tr>
                </thead>
                <?php
                $i = 0;
                $select_admin = "SELECT * from admin";
                $admin_select = mysqli_query($conn, $select_admin);
                while ($row_data = mysqli_fetch_assoc($admin_select)):
                    $i++;
                ?>
                <tbody>
                    <tr>
                        <td class="tdsno"><?php echo $i . '.'; ?></td>
                        <td class="tdname"><?php echo $row_data['fullname']; ?></td>
                        <td class="tdphone"><?php echo $row_data['phone']; ?></td>
                        <td class="tdemail"><?php echo $row_data['email']; ?></td>
                        <td class="tdaction">
                            <a href="./user_edit.php?id=<?php echo $row_data['admin_id']; ?>"
                                class="btn btn--small">Edit</a>
                        </td>
                        <td class="tdaction">
                            <a href="./admin_delete.php?id=<?php echo $row_data['admin_id']; ?>"
                                class="btn btn--danger">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function myFunction() {
    document.getElementById("addAdminPopup").style.display = "block";
};

function closeFunction() {
    document.getElementById("addAdminPopup").style.display = "none";
};


document.addEventListener("DOMContentLoaded", () => {
    const formEle = document.add_admin_popup,
        fname = formEle.adminName,
        phone = formEle.adminPhone,
        email = formEle.adminEmail,
        psw = formEle.adminPsw,
        cpsw = formEle.adminCpsw;

    formEle.addEventListener("submit", (e) => {
        let isValid = true;

        // Function to clear errors
        const clearError = (field) => {
            const errorSpan = field.nextElementSibling;
            if (errorSpan) {
                errorSpan.innerText = "";
            }
        };

        // Function to set error message
        const setError = (field, message) => {
            const errorSpan = field.nextElementSibling;
            if (errorSpan) {
                errorSpan.innerText = message;
            }
            isValid = false;
        };

        // Full name validation
        if (!/^[A-Z][a-z]+(?: [A-Z][a-z]+)+$/.test(fname.value)) {
            setError(fname, "Full Name must start with capital letters and include a surname.");
        } else {
            clearError(fname);
        }

        // Phone validation (example for a specific format like starting with '98')
        if (phone.value !== "" && !/^98\d{8}$/.test(phone.value)) {
            setError(phone, "Phone number must be 10 digits and start with 98.");
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

    // Add span elements for error messages dynamically
    document.querySelectorAll(".add-admin-field").forEach(field => {
        let span = document.createElement("span");
        span.style.color = "red";
        span.style.fontSize = "12px";
        field.appendChild(span);
    });
});
</script>
<?php
include 'footer.php';
?>