<?php

include "header.php";
include "../Database/connection.php";

if($_SERVER['REQUEST_METHOD']==='POST'){
    if (isset($_POST['total_price']) && isset($_POST['total_price']) && isset($_POST['total_price'])) {
        $cart_item_ids = $_POST['cart_item_id']; 
        $user_id = $_POST['user_id']; 
        $total_amount = $_POST['total_price']; 

        $cart_item_ids_str = implode(", ", $cart_item_ids);
    }

}
$transaction_uuid = mt_rand(100000, 999999);
$message = "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=EPAYTEST";
$s = hash_hmac('sha256', $message, '8gBm/:&EnhH.1/q', true);
?>


<div class="payment-option">
    <?php ?>
    <div class="available">
        <div class="available-system">
            <h1 class="payment-header">Select Payment System</h1>
        </div>
        <div class="payment">
            <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
                <input type="text" id="amount" name="amount" value="<?php echo $total_amount;?>" required hidden>
                <input type="text" id="tax_amount" name="tax_amount" value="0" required hidden>
                <input type="text" id="total_amount" name="total_amount" value="<?php echo $total_amount;?>" required
                    hidden>
                <input type="text" id="transaction_uuid" name="transaction_uuid" value="<?php echo $transaction_uuid;?>"
                    required hidden>
                <input type="text" id="product_code" name="product_code" value="EPAYTEST" required hidden>
                <input type="text" id="product_service_charge" name="product_service_charge" value="0" required hidden>
                <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required
                    hidden>
                <input type="text" id="success_url" name="success_url" value="https://esewa.com.np" required hidden>
                <input type="text" id="failure_url" name="failure_url" value="https://google.com" required hidden>
                <input type="text" id="signed_field_names" name="signed_field_names"
                    value="total_amount,transaction_uuid,product_code" required hidden>
                <input type="text" id="signature" name="signature" value="<?php echo base64_encode($s); ?>" required
                    hidden>
                <input type="image" src="../Photos/esewa.png" name="esewa">
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