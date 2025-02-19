<?php
include "header.php";
include "../Database/connection.php";

// Redirect to sign-in page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    echo '<h2 style="color: red; text-align: center; display: flex; justify-content: center; padding: 155px 0;">Please Sign In to see your cart data. <a href="sign_in.php" style="color: blue;">Click Here</a></h2>';
    include "footer.php";
    exit;
}
?>

<div class="games-main">
    <div class="games-header">
        <h1 class="games-title">Cart</h1>
    </div>

    <div class="game-cart-body">
        <div class="game-data">
            <form action="" method="post">
                <table>
                    <thead>
                        <tr>
                            <th class="thsno">S.No.</th>
                            <th class="thphoto">Game Photo</th>
                            <th>Game Name</th>
                            <th class="th_game_price">Game Price (NPR)</th>
                            <th class="thaction" colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $total_price = 0;

                        // Fetch cart items for the logged-in user
                        $query = "SELECT ci.cart_item_id, g.game_id, g.game_photo, g.game_name, g.game_price 
                                  FROM cart_items ci 
                                  JOIN games g ON ci.game_id = g.game_id 
                                  JOIN cart c ON ci.cart_id = c.cart_id 
                                  WHERE c.user_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $sno = 0;
                            while ($row = $result->fetch_assoc()):
                                $total_price += $row['game_price'];
                                $sno++;
                        ?>
                        <tr>
                            <td class="tdsno"><?php echo $sno . '.'; ?></td>
                            <td>
                                <img src="<?php echo $row['game_photo']; ?>" alt="Game Photo" class="games-cart-photo">
                            </td>
                            <td><?php echo $row['game_name']; ?></td>
                            <td class="tdgameprice"><?php echo $row['game_price']; ?></td>
                            <td class="tdaction">
                                <input type="checkbox" name="removegame[]" value="<?php echo $row['cart_item_id']; ?>">
                            </td>
                        </tr>
                        <?php
                            endwhile;
                        } else {
                            echo "<tr><td colspan='5' style='color: red; text-align: center; padding: 50px 0;'>Your cart is empty.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="checkout">
                    <p>Total Price: NPR <?php echo $total_price; ?></p>
                    <button type="submit" class="remove" name="removefromcart">Remove</button>
                </div>
            </form>

            <!-- Checkout Form -->
            <form id="checkoutForm" action="./checkout.php" method="post">
                <?php
    if ($result->num_rows > 0) {
        $result->data_seek(0); // Reset the result pointer to the beginning
        while ($row = $result->fetch_assoc()):
    ?>
                <input type="hidden" name="cart_item_id[]" value="<?php echo $row['cart_item_id']; ?>">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <?php
        endwhile;
    }
    ?>
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <input type="submit" class="check-out" value="Check Out" onclick="return checkCart();">
            </form>
        </div>
    </div>
</div>
<script>
function checkCart() {
    var totalPrice = <?php echo $total_price; ?>;
    if (totalPrice === 0) {
        alert("Your cart is empty. Please add games before checking out.");
        return false; // Prevent form submission
    }
    return true;
}
</script>

<?php
// Function to remove items from the cart
function remove_from_cart() {
    global $conn;

    if (isset($_POST['removefromcart'])) {
        if (isset($_POST['removegame']) && is_array($_POST['removegame'])) {
            foreach ($_POST['removegame'] as $remove_item) {
                $remove_item = intval($remove_item);
                $delete_query = "DELETE FROM cart_items WHERE cart_item_id = $remove_item";
                mysqli_query($conn, $delete_query);
            }
            echo "<script>window.open('cart.php', '_self')</script>";
        } else {
            echo "<script>alert('Please select game from cart to remove.');</script>";
        }
    }
}
remove_from_cart();

include "footer.php";
?>