<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}
?>
<div class="dashboard-body">
    <div class="users-header">
        <h1 class="users-title">Users</h1>
    </div>

    <div class="users-body">
        <div class="users-data">
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
                $select_users = "SELECT * from users";
                $user_select = mysqli_query($conn, $select_users);
                while ($row_data = mysqli_fetch_assoc($user_select)):
                    $i++;
                ?>
                <tbody>
                    <tr>
                        <td class="tdsno"><?php echo $i . '.'; ?></td>
                        <td class="tdname"><?php echo $row_data['fullname']; ?></td>
                        <td class="tdphone"><?php echo $row_data['phone']; ?></td>
                        <td class="tdemail"><?php echo $row_data['email']; ?></td>
                        <td class="tdaction">
                            <a href="./Action/user_delete.php?id=<?php echo $row_data['user_id']; ?>"
                                class="btn btn--danger" onclick="return confirmDelete();">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function confirmDelete() {
    return confirm("Are you sure, you want to delete this user?");
};
</script>


<?php
include 'footer.php';
?>