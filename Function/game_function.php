<?php
include "../Database/connection.php";
?>

<?php
function games(){
    global $conn;
    if(!isset($_GET['category_id'])){
$select_game = "SELECT * FROM games INNER JOIN category ON games.category_id=category.category_id";
$game_select = mysqli_query($conn, $select_game);
while ($row_data = mysqli_fetch_assoc($game_select)):
?>
<div class="game-container">
    <div class="game-body">
        <div class="media-container">
            <?php
                if (!empty($row_data['game_photo'])) {
                    echo '<img src="' . $row_data['game_photo'] . '" alt="Game Photo" class="image">';
                }
                ?>
            <video class="video" loop muted>
                <source src="<?php echo $row_data['game_video']; ?>" type="video/mp4" />
            </video>
        </div>
    </div>
    <div class="game-info">
        <div class="game-title">
            <h1><?php echo $row_data['game_name']; ?></h1>
        </div>
        <div class="game-description">
            <p><?php echo $row_data['description']; ?></p>
            <p>Release Date : <?php
                            if (!empty($row_data['release_date'])) {
                                $formattedDate = date("M d, Y", strtotime($row_data['release_date']));
                                echo $formattedDate;
                            }
                            ?></p>
            <p>Developer : <?php echo $row_data['game_developer']; ?></p>
            <p>Category : <?php echo $row_data['category_name']; ?></p>
        </div>
        <div class="game-cart">
            <div class="cost"><?php echo 'Npr  ' . $row_data['game_price']; ?></div>
            <button>Add to Cart</button>
        </div>
    </div>
</div>
<?php
endwhile; 
}
}
function gamesByCategory(){
    global $conn;
    if(isset($_GET['category_id'])){
        $category_id=$_GET['category_id'];
$select_game = "SELECT * FROM games INNER JOIN category ON games.category=category.category_id where games.category=$category_id";
$game_select = mysqli_query($conn, $select_game);
while ($row_data = mysqli_fetch_assoc($game_select)):
?>
<div class="game-container">
    <div class="game-body">
        <div class="media-container">
            <?php
                if (!empty($row_data['photo'])) {
                    echo '<img src="../Database/uploads/photos/' . ($row_data['photo']) . '" alt="Game Photo" class="image">';
                }
                ?>
            <video class="video" loop muted>
                <source src="<?php echo '../Database/uploads/videos/' . $row_data['video']; ?>" type="video/mp4" />
            </video>
        </div>
    </div>
    <div class="game-info">
        <div class="game-title">
            <h1><?php echo $row_data['game_name']; ?></h1>
        </div>
        <div class="game-description">
            <p><?php echo $row_data['description']; ?></p>
            <p>Release Date : <?php echo $row_data['release_date']; ?></p>
            <p>Developer : <?php echo $row_data['developer']; ?></p>
            <p>Category : <?php echo $row_data['category']; ?></p>
        </div>
        <div class="game-cart">
            <div class="cost"><?php echo 'Npr  ' . $row_data['game_price']; ?></div>
            <button>Add to Cart</button>
        </div>
    </div>
</div>
<?php
endwhile; 
}
}
?>