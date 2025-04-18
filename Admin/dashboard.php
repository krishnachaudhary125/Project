<?php
include "header.php";
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}
?>
<div class="box-container">
    <div class="box box1">
        <div class="text">
            <?php
            $count = "SELECT COUNT(*) AS totalUsers from admin";
            $result = mysqli_query($conn, $count);
            if ($result->num_rows > 0) {
            ?>
            <h2 class="topic-heading"><?php $row = $result->fetch_assoc();
                                            echo $row['totalUsers'];
                                        } else {
                                            echo "0";
                                        } ?></h2>
            <h2 class="topic">No. of Admin</h2>
        </div>

        <img src="../Photos/admin.png" alt="Admin Icon">
    </div>

    <div class="box box2">
        <div class="text">
            <?php
            $count = "SELECT COUNT(*) AS totalUsers from users";
            $result = mysqli_query($conn, $count);
            if ($result->num_rows > 0) {
            ?>
            <h2 class="topic-heading"><?php $row = $result->fetch_assoc();
                                            echo $row['totalUsers'];
                                        } else {
                                            echo "0";
                                        } ?></h2>
            <h2 class="topic">No. of Users</h2>
        </div>

        <img src="../Photos/user.png" alt="User Icon">
    </div>

    <div class="box box3">
        <div class="text">
            <?php
            $count = "SELECT COUNT(*) AS totalCategory from category";
            $result = mysqli_query($conn, $count);
            if ($result->num_rows > 0) {
            ?>
            <h2 class="topic-heading"><?php $row = $result->fetch_assoc();
                                            echo $row['totalCategory'];
                                        } else {
                                            echo "0";
                                        } ?></h2>
            <h2 class="topic">No. of Category</h2>
        </div>

        <img src="../Photos/category.png" alt="Game Icon">
    </div>
</div>

<div class="box-container">
    <div class="box box4">
        <div class="text">
            <?php
            $count = "SELECT COUNT(*) AS totalCategory from games";
            $result = mysqli_query($conn, $count);
            if ($result->num_rows > 0) {
            ?>
            <h2 class="topic-heading"><?php $row = $result->fetch_assoc();
                                            echo $row['totalCategory'];
                                        } else {
                                            echo "0";
                                        } ?></h2>
            <h2 class="topic">No. of Games</h2>
        </div>

        <img src="../Photos/game.png" alt="Game Icon">
    </div>

    <div class="box box5">
        <div class="text">
            <?php
            $amount = "SELECT SUM(total_amount) AS final_amount FROM orders";
            $result = mysqli_query($conn, $amount);
            ?>
            <h2 class="topic-heading"><?php $row = $result->fetch_assoc();
                                            echo $row['final_amount'];?></h2>
            <h2 class="topic">Total Revenue</h2>
        </div>

        <img src="../Photos/revenue.png" alt="Revenue Icon">
    </div>
</div>
<?php
include "footer.php";
?>