<?php
include "header.php";
include '../Database/connection.php';
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

        <img src="./image/admin.png" alt="Admin Icon">
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

        <img src="./image/user.png" alt="User Icon">
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

        <img src="./image/category.png" alt="Game Icon">
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

        <img src="./image/game.png" alt="Game Icon">
    </div>

    <div class="box box5">
        <div class="text">
            <h2 class="topic-heading">320</h2>
            <h2 class="topic">Total Revenue</h2>
        </div>

        <img src="./image/revenue.png" alt="Revenue Icon">
    </div>
</div>
<?php
include "footer.php";
?>