<?php

include "header.php";
include "../Database/connection.php";

if($_SERVER['REQUEST_METHOD']==='POST'){
    if (isset($_POST['cart_id']) && isset($_POST['total_price'])) {
        $cart_id = $_POST['cart_id']; // Array of cart IDs
        $total_price = $_POST['total_price']; // Total price

        // Example: Display the received data
        echo "<p>Cart IDs: " . implode(', ', $cart_id) . "</p>";
        echo "<p>Total Price: NPR $total_price</p>";
    } else {
        echo "<p style='color: red;'>Required POST data is missing.</p>";
    }

}
?>


<div class="payment-option">
    <?php ?>
    <div class="available">
        <div class="available-system">
            <h1 class="payment-header">Select Payment System</h1>
        </div>
        <div class="payment">
            <form action="https://uat.esewa.com.np/epay/main" method="POST">
                <input type="hidden" name="amount" value="">
                <input type="hidden" name="tax_amount" value="0">
                <input type="hidden" name="total_amount" value="">
                <input type="hidden" name="transaction_id" value="">
                <input type="hidden" name="product_code" value="EPAYTEST">
                <input type="hidden" name="product_service_charge" value="0">
                <input type="hidden" name="product_delivery_charge" value="0">
                <input type="hidden" name="success_url" value="">
                <input type="hidden" name="failure_url" value="">
                <input type="image" src="../Photos/esewa.png" name="pay">
            </form>
        </div>
    </div>
    <div class="not-available">
        <div class="not-available-system">
            <h1 class="payment-header">Will be available soon!!</h1>
        </div>
        <div class="payment">
            <input type="image" src="../Photos/khalti.png">
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>