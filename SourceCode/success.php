<?php
include "header.php";
include "../Database/connection.php";

if (isset($_GET['data'])) {
    $encoded_response = $_GET['data'];
    $decoded_response = base64_decode($encoded_response);
    $response_data = json_decode($decoded_response, true);

    if (isset($response_data['status']) && isset($response_data['total_amount']) && isset($response_data['transaction_uuid']) && isset($response_data['signature'])) {
        
        $status = $response_data['status'];
        $total_amount = $response_data['total_amount'];
        $transaction_uuid = $response_data['transaction_uuid'];

        if ($status === 'COMPLETE') {

            $check_sql = "SELECT transaction_uuid FROM orders WHERE transaction_uuid = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("s", $transaction_uuid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
            } else {
                $amount = isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : null;
                $final_amount = ($amount + ($amount * 10 / 100));
                $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                $cart_item_ids_str = isset($_SESSION['cart_item_ids_str']) ? $_SESSION['cart_item_ids_str'] : null; 

                // Insert into orders table
                $sql = "INSERT INTO orders (user_id, transaction_uuid, total_amount, status) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isds", $user_id, $transaction_uuid, $final_amount, $status);
                $stmt->execute();
                $order_id = $stmt->insert_id;

                // Process cart items
                $cart_item_ids = explode(", ", $cart_item_ids_str);
                foreach ($cart_item_ids as $cart_item_id) {
                    // Retrieve game_id from cart_items
                    $game_query = "SELECT game_id FROM cart_items WHERE cart_item_id = ?";
                    $stmt = $conn->prepare($game_query);
                    $stmt->bind_param("i", $cart_item_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        $game_id = $row['game_id'];

                        // Insert into order_items
                        $insert_order_items_sql = "INSERT INTO order_items (order_id, game_id) VALUES (?, ?)";
                        $stmt = $conn->prepare($insert_order_items_sql);
                        $stmt->bind_param("ii", $order_id, $game_id);
                        $stmt->execute();
                    }
                }

                // Delete items from cart
                foreach ($cart_item_ids as $cart_item_id) {
                    $delete_sql = "DELETE FROM cart_items WHERE cart_item_id = ?";
                    $stmt = $conn->prepare($delete_sql);
                    $stmt->bind_param("i", $cart_item_id);
                    $stmt->execute();
                }

                // Clear session data
                unset($_SESSION['cart_item_ids_str']);
                unset($_SESSION['total_amount']);
            }
        }
    }
}
?>

<div class="pay-success-container">
    <div class="success-message">
        <h1><?php echo "Payment Successful"; ?></h1>
    </div>
    <div class="payment-amount">
        <h2><?php echo "Game Cost : " . $amount; ?></h2>
    </div>
    <div class="payment-amount">
        <h2><?php echo "Esewa Service Charge : " . ($amount * 10 / 100); ?></h2>
    </div>
    <div class="payment-amount">
        <h2><?php echo "Total Amount : " . ($amount + ($amount * 10 / 100)); ?></h2>
    </div>
    <div class="salutation">
        <h2><?php echo "Thank You!!"; ?></h2>
    </div>
</div>

<?php
include 'footer.php';
?>