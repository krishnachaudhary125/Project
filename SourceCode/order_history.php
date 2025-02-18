<?php
include "header.php";
include "../Database/connection.php";
?>

<div class="order-main">
    <div class="order-header">
        <h1 class="order-title">Order History</h1>
    </div>

    <div class="order-body">
        <div class="order-data">
            <table>
                <thead>
                    <tr>
                        <th class="th_sno">S.No</th>
                        <th class="th_tuuid">Transaction Id</th>
                        <th class="th_amt">Total Amount</th>
                        <th class="th_game">Games</th>
                        <th class="th_time">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $select = "SELECT * FROM orders WHERE user_id = ?";
                    $stmt = $conn->prepare($select);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $query = $stmt->get_result();

                    $i = 0;
                    while ($row_data = $query->fetch_assoc()):
                        $i++;
                        $order_id = $row_data['id'];
                    ?>
                    <tr>
                        <td class="td_sno"><?php echo $i . '.'; ?></td>
                        <td class="td_tuuid"><?php echo $row_data['transaction_uuid']; ?></td>
                        <td class="td_amt"><?php echo $row_data['total_amount']; ?></td>
                        <td class="td_games">
                            <button class="toggle-games" data-order-id="<?php echo $order_id; ?>">View</button>
                        </td>
                        <td class="td_time"><?php echo $row_data['created_at']; ?></td>
                    </tr>
                    <tr class="order-items-row" id="order-items-<?php echo $order_id; ?>" style="display: none;">
                        <td colspan="6">
                            <div class="game-details">
                                <?php
                                // Fetch order items for this order
                                $order_items_query = "
                                    SELECT games.game_name, games.game_photo, games.game_price
                                    FROM order_items
                                    JOIN games ON order_items.game_id = games.game_id
                                    WHERE order_items.order_id = ?";

                                $stmt_items = $conn->prepare($order_items_query);
                                $stmt_items->bind_param("i", $order_id);
                                $stmt_items->execute();
                                $order_items_result = $stmt_items->get_result();

                                if ($order_items_result->num_rows > 0) {
                                    while ($game = $order_items_result->fetch_assoc()) {
                                        ?>
                                <div class="game-item">
                                    <img src="<?php echo $game['game_photo']; ?>"
                                        alt="<?php echo $game['game_name']; ?>" class="game-photo">

                                    <div class="game-details">
                                        <div class="game-info">
                                            <p><strong>Game Name:</strong> <?php echo $game['game_name']; ?></p>
                                            <p><strong>Game Key:</strong> <?php echo "12345678"; ?></p>
                                        </div>
                                        <div class="game-cost">
                                            <p><strong>Game Price:</strong> <?php echo $game['game_price']; ?></p>
                                            <p><strong>Esewa Charge:</strong>
                                                <?php echo ($game['game_price']*10/100); ?></p>
                                        </div>
                                    </div>
                                </div>



                                <?php
                                    }
                                } else {
                                    echo "<p>No games found for this order.</p>";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-games').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-order-id');
        const row = document.getElementById('order-items-' + orderId);
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
            this.textContent = 'Hide';
        } else {
            row.style.display = 'none';
            this.textContent = 'View';
        }
    });
});
</script>

<?php
include "footer.php";
?>