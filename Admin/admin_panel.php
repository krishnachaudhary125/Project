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
        <img src="../Photos/logo.png" alt="logo" class="dash-logo">
    </div>
    <div class="dash-menu">
        <a href="#" onclick="openPopup()">
            <img src="../Photos/profile.png" alt="Admin Profile" class="admin-profile"></a>
        <img src="../Photos/hamburger.png" alt="Menu" class="menu-icon" id="menu-icon">
    </div>
</header>

<div class="main-container">
    <div class="nav-body">
        <nav class="nav-main">
            <div class="option-container">
                <a href="./admin_panel.php?dashboard">
                    <div class="nav-option option1">
                        <img src="../Photos/dashboard.png" alt="Dashboard" class="option-icon">
                        <h3>Dashboard</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?admin">
                    <div class="nav-option option4">
                        <img src="../Photos/admin.png" alt="Admins" class="option-icon">
                        <h3>Admin</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?category">
                    <div class="nav-option option5">
                        <img src="../Photos/category.png" alt="Category" class="option-icon">
                        <h3>Category</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?games">
                    <div class="nav-option option2">
                        <img src="../Photos/game.png" alt="Games" class="option-icon">
                        <h3>Games</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?users">
                    <div class="nav-option option5">
                        <img src="../Photos/user.png" alt="Users" class="option-icon">
                        <h3>Users</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?transaction">
                    <div class="nav-option option5">
                        <img src="../Photos/purchase.png" alt="Transaction" class="option-icon">
                        <h3>Transaction</h3>
                    </div>
                </a>
                <a href="./admin_panel.php?suggestion">
                    <div class="nav-option option5">
                        <img src="../Photos/suggestion.png" alt="Suggestion" class="option-icon">
                        <h3>Suggestion</h3>
                    </div>
                </a>
            </div>
        </nav>
    </div>

    <div class="dashboard-main">
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
        <?php
        if (isset($_GET['suggestion'])) {
            include 'suggestion.php';
        }
        ?>
        <?php
        if (isset($_GET['edit_profile'])) {
            include 'edit_profile.php';
        }
        ?>
        <?php
        if (isset($_GET['transaction'])) {
            include 'transaction.php';
        }
        ?>
        <?php
        if (isset($_GET['change_password'])) {
            include 'change_password.php';
        }
        ?>
    </div>
</div>

<div id="accountPopup" class="header-popup">
    <div class="popup-content-header">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <div class="account_content">
            <ul>
                <?php if (isset($_SESSION['admin_name'])): ?>
                <li>
                    <h2><strong><?php echo $_SESSION['admin_name']; ?></strong>
                    </h2>
                </li>
                <div class="header-profile">
                    <li><a href="./admin_panel.php?edit_profile&admin_id=<?php echo $_SESSION['admin_id']; ?>">
                            <div class="profile-settings"><img src="../Photos/edit_profile.png" alt="Edit Profile"
                                    class="icon-profile">
                                <h3>Edit Profile</h3>
                            </div>
                        </a></li>
                    <li><a href="./admin_panel.php?change_password&admin_id=<?php echo $_SESSION['admin_id']; ?>">
                            <div class="profile-settings"><img src="../Photos/change_psw.png" alt="Change Password"
                                    class="icon-profile">
                                <h3>Change Password</h3>
                            </div>
                        </a></li>
                    <li><a href="logout.php">
                            <div class="profile-settings"><img src="../Photos/logout.png" alt="Logout"
                                    class="icon-profile">
                                <h3>Logout</h3>
                            </div>
                        </a></li>
                </div>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script>
let menu_icon = document.querySelector(".menu-icon");
let nav = document.querySelector(".nav-body");

menu_icon.addEventListener("click", () => {
    nav.classList.toggle("navclose");
});

function openPopup() {
    document.getElementById('accountPopup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('accountPopup').style.display = 'none';
}

window.onclick = function(event) {
    const popup = document.getElementById('accountPopup');
    if (event.target == popup) {
        popup.style.display = 'none';
    }
};
</script>
<?php
include 'footer.php';
?>