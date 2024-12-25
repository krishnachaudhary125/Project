<?php
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}
?>
<header>
    <div class="dashboard-logo">
        <img src="./image/logo.png" alt="logo" class="dash-logo">
    </div>
    <div class="dash-menu">
        <img src="./image/hamburger.png" alt="Menu" class="menu-icon" id="menu-icon">
    </div>
</header>

<div class="main-container">
    <div class="nav-body">
        <nav class="nav-main">
            <div class="option-container">
                <a href="./admin_panel.php?dashboard">
                    <div class="nav-option option1">
                        <img src="./image/dashboard.png" alt="Dashboard" class="option-icon">
                        <h3>Dashboard</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?admin">
                    <div class="nav-option option4">
                        <img src="./image/admin.png" alt="Admins" class="option-icon">
                        <h3>Admin</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?games">
                    <div class="nav-option option2">
                        <img src="./image/game.png" alt="Games" class="option-icon">
                        <h3>Games</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?users">
                    <div class="nav-option option5">
                        <img src="./image/user.png" alt="Users" class="option-icon">
                        <h3>Users</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?category">
                    <div class="nav-option option5">
                        <img src="./image/category.png" alt="Category" class="option-icon">
                        <h3>Category</h3>
                    </div>
                </a>
                <a href="./logout.php">
                    <div class="nav-option option6">
                        <img src="./image/logout.png" alt="Logout" class="option-icon">
                        <h3>Logout</h3>
                    </div>
                </a>
            </div>
        </nav>
    </div>
    <div class=" dashboard-main">
        <?php
        if (isset($_GET['dashboard'])) {
            include 'dashboard.php';
        }
        ?>
        <?php
        if (isset($_GET['admin'])) {
            include 'admin.php';
        }
        ?>
        <?php
        if (isset($_GET['games'])) {
            include 'games.php';
        }
        ?>
        <?php
        if (isset($_GET['users'])) {
            include 'users.php';
        }
        ?>
        <?php
        if (isset($_GET['category'])) {
            include 'category.php';
        }
        ?>
    </div>
</div>
<script>
let menu_icon = document.querySelector(".menu-icon");
let nav = document.querySelector(".nav-body");

menu_icon.addEventListener("click", () => {
    nav.classList.toggle("navclose");
});
</script>
<?php
include 'footer.php';
?>