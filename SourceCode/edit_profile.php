<?php
include "header.php";
include "../Database/connection.php";

if (isset($_GET['user_id'])):
    $id = $_GET['user_id'];
    $sql = "SELECT user_id, fullname, phone, email, password FROM users WHERE user_id=$id";
    $res = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($res); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = $_POST['fname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['psw'] ?? '';

        $hashPassword = sha1($password);

        if (empty($fullname) || empty($phone) || empty($password)) {
            $error = "All fields are required.";
        } elseif (!preg_match("/^[A-Z][a-z]+(?: [A-Z][a-z]+)+$/", $fullname)) {
            $error = "Full Name must start with capital letters and include a surname.";
        } elseif (!preg_match("/^(98|97)\d{8}$/", $phone)) {
            $error = "Phone number must start with 98 or 97 and be 10 digits.";
        } else {
            if ($hashPassword===$row['password']) { 
                $update_sql = "UPDATE users SET fullname = ?, phone = ? WHERE user_id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ssi", $fullname, $phone, $id);

                if ($stmt->execute()) {
                    $success = "Profile updated successfully.";
                } else {
                    $error = "Failed to update profile. Please try again.";
                }

                $stmt->close();
            } else {
                $error = "Incorrect password. Profile not updated.";
            }
        }
    }
?>

<div class="edit-profile-container">
    <form action="#" method="post" class="edit-profile" name="edit_profile">
        <h1>Edit Profile</h1>
        <div class="edit-profile-form">
            <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
            <?php elseif (!empty($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>
            <div class="edit-profile-field">
                <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($row['fullname']); ?>"
                    placeholder="Full Name">
            </div>
            <div class="edit-profile-field">
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>"
                    placeholder="Phone Number">
            </div>
            <div class="edit-profile-field">
                <label for="email">Email Cannot be changed.</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"
                    disabled>
            </div>
            <div class="edit-profile-field">
                <input type="password" id="psw" name="psw" value="" placeholder="Enter Password">
            </div>
            <button type="submit" name="submit">Confirm</button>
        </div>
    </form>
</div>

<?php
endif;
include "footer.php";
?>