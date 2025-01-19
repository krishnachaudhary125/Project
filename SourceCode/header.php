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
            <a href="index.php" class="logo"><img src="../Photos/logo.png" alt="Logo"></a>
        </div>
        <div class="nav-bar">
            <form class="search-bar" action="search.php" method="get">
                <input type="text" placeholder="Search" name="search">

                <button type="submit" value="search" name="search_game">
                    <div class="search-button">
                        <img src="../Photos/search.png" class="search-icon" alt="search-icon">
                    </div>
                </button>
            </form>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="games.php">Games</a></li>
                <li><a href="about_us.php">About Us </a></li>
                <li><a href="cart.php"><img src="../Photos/cart.png" alt="Cart" class="cart-icon"></a></li>
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
                    <?php if (isset($_SESSION['user_name'])): ?>
                    <li>
                        <h2><strong><?php echo $_SESSION['user_name']; ?></strong></h2>
                    </li>
                    <div class="profile">
                        <li><a href="edit_profile.php">
                                <div class="profile-settings"><img src="../Photos/edit_profile.png" alt="Logout"
                                        class="icon-profile">
                                    <h3>Edit Profile</h3>
                                </div>
                            </a></li>
                        <li><a href="cart.php">
                                <div class="profile-settings"><img src="../Photos/cart.png" alt="Logout"
                                        class="icon-profile">
                                    <h3>Check Cart</h3>
                                </div>
                            </a></li>
                        <li><a href="order_history.php">
                                <div class="profile-settings"><img src="../Photos/purchase.png" alt="Logout"
                                        class="icon-profile">
                                    <h3>Order History</h3>
                                </div>
                            </a></li>
                        <li><a href="suggestion.php">
                                <div class="profile-settings"><img src="../Photos/suggestion.png" alt="Logout"
                                        class="icon-profile">
                                    <h3>Suggestion</h3>
                                </div>
                            </a></li>
                        <li><a href="change_password.php">
                                <div class="profile-settings"><img src="../Photos/change_psw.png" alt="Logout"
                                        class="icon-profile">
                                    <h3>Change Password</h3>
                                </div>
                            </a></li>
                        <li><a href="../Admin/logout.php">
                                <div class="profile-settings"><img src="../Photos/logout.png" alt="Logout"
                                        class="icon-profile">
                                    <h3>Logout</h3>
                                </div>
                            </a></li>
                    </div>
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