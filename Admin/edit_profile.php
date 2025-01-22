<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}


if (isset($_GET['admin_id'])):
    $id = $_GET['admin_id'];
    $sql = "SELECT admin_id, fullname, phone, email, password FROM admin WHERE admin_id=$id";
    $res = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($res); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = $_POST['adminName'] ?? '';
        $phone = $_POST['adminPhone'] ?? '';
        $password = $_POST['adminPsw'] ?? '';

        $hashPassword = sha1($password);

        if (empty($fullname) || empty($phone) || empty($password)) {
            $error = "All fields are required.";
        } elseif (!preg_match("/^[A-Z][a-z]+(?: [A-Z][a-z]+)+$/", $fullname)) {
            $error = "Full Name must start with capital letters and include a surname.";
        } elseif (!preg_match("/^(98|97)\d{8}$/", $phone)) {
            $error = "Phone number must start with 98 or 97 and be 10 digits.";
        } else {
            if ($hashPassword===$row['password']) { 
                $update_sql = "UPDATE admin SET fullname = ?, phone = ? WHERE admin_id = ?";
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

<div class="edit-admin-container">
    <form action="#" method="post" name="edit_admin" class="edit-admin">
        <h1>Edit Profile</h1>
        <div class="edit-admin-form">
            <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
            <?php elseif (!empty($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>
            <div class="edit-admin-field">
                <input type="text" id="adminName" name="adminName"
                    value="<?php echo htmlspecialchars($row['fullname']); ?>">
            </div>
            <div class="edit-admin-field">
                <input type="text" id="adminPhone" name="adminPhone"
                    value="<?php echo htmlspecialchars($row['phone']); ?>">
            </div>
            <div class="edit-admin-field">
                <input type="email" id="adminEmail" name="adminEmail"
                    value="<?php echo htmlspecialchars($row['email']); ?>" disabled>
            </div>
            <div class="edit-admin-field">
                <input type="password" id="adminPsw" name="adminPsw" value="" placeholder="Enter Password">
            </div>
            <div class="edit-admin-button">
                <button type="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

<?php 
endif;
include 'footer.php';
?>