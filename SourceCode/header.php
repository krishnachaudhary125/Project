<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamEase: Store to Purchase Any PC Games</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php" class="logo"><img src="/Project/Photos/main_logo.png" alt="Logo"></a>
        </div>
        <div class="nav-bar">
            <form class="search-bar">
                <input type="text" placeholder="Search" name="search">
                <button type="submit"><img src="../Photos/search.png" alt=""></button>
            </form>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="games.php">Games</a></li>
                <li><a href="about_us.php">About Us </a></li>
                <li><a href="#" onclick="openPopup()"><img src="../Photos/profile.png" alt="Profile Icon"
                            class="profile-icon"></a></li></a></li>
            </ul>
        </div>
    </header>
    <div id="accountPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <div class="account_content">
                <ul>
                    <?php
                if (isset($_SESSION['user_name'])): ?>
                    <li><a href="#"><?php echo $_SESSION['user_name']; ?></a></li>
                    <li><a href="../Admin/logout.php">Logout</a></li>
                    <?php else: ?>
                    <li><a href="sign_in.php">Sign In</a></li>
                    <li><a href="sign_up.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-container">
            <script>
            function openPopup() {
                document.getElementById('accountPopup').style.display = 'flex';
            }

            function closePopup() {
                document.getElementById('accountPopup').style.display = 'none';
            }

            // Close the popup when clicking outside the content
            window.onclick = function(event) {
                const popup = document.getElementById('accountPopup');
                if (event.target == popup) {
                    popup.style.display = 'none';
                }
            };
            </script>