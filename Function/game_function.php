<?php
include "../Database/connection.php";
?>

<?php
// Displaying Game
function games(){
    global $conn;
    if(!isset($_GET['category_id'])){
$select_game = "SELECT * FROM games INNER JOIN category ON games.category_id=category.category_id ";
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
            <a href="games.php?add_to_cart=<?php echo $row_data['game_id']; ?>"><button>Add to Cart</button></a>
        </div>
    </div>
</div>
<?php
endwhile; 
}
}

// Displaying game by category
function gamesByCategory(){
    global $conn;
    if(isset($_GET['category_id'])){
        $category_id=$_GET['category_id'];
$select_game = "SELECT * FROM games INNER JOIN category ON games.category_id=category.category_id where games.category_id=$category_id";
$game_select = mysqli_query($conn, $select_game);

$num_rows = mysqli_num_rows($game_select);
if($num_rows==0){
    echo '<h2 style="color: red; text-align: center; display: flex; justify-content: center; padding: 88px 0;">Games with this category not available.</h2>';
}

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
            <a href="games.php?add_to_cart=<?php echo $row_data['game_id']; ?>"><button>Add to Cart</button></a>
        </div>
    </div>
</div>
<?php
endwhile; 
}
}

// Displaying game by search
function search_game(){
    global $conn;
    if(isset($_GET['search_game'])){
        $search_game_value = $_GET['search']; 
$search_query = "SELECT * FROM games INNER JOIN category ON games.category_id=category.category_id WHERE game_keyword LIKE '%$search_game_value%'";
$game_select = mysqli_query($conn, $search_query);

$num_rows = mysqli_num_rows($game_select);
if($num_rows==0){
    echo '<h2 style="color: red; text-align: center; display: flex; justify-content: center; padding: 88px 0;">Games not Available!!</h2>';
}
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
            <a href="games.php?add_to_cart=<?php echo $row_data['game_id']; ?>"><button>Add to Cart</button></a>
        </div>
    </div>
</div>
<?php
endwhile; 
}
}

// Adding games in cart
function cart(){
    global $conn;
    if (isset($_GET['add_to_cart'])) {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You need to sign in to add a game to the cart.');</script>";
            echo "<script>window.location.href = 'sign_in.php';</script>";
            exit(); 
        }

        $get_game_id = $_GET['add_to_cart'];
        $user_id = $_SESSION['user_id'];

        $check_cart_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND game_id = '$get_game_id'";
        $check_cart_result = mysqli_query($conn, $check_cart_query);

        if (mysqli_num_rows($check_cart_result) > 0) {
            echo "<script>alert('Game is already in the cart!');</script>";
        } else {

            $add_to_cart_query = "INSERT INTO cart (user_id, game_id) VALUES ('$user_id', '$get_game_id')";
            $add_to_cart_result = mysqli_query($conn, $add_to_cart_query);

            if ($add_to_cart_result) {
                echo "<script>alert('Game added to cart successfully!');</script>";
                echo "<script>window.location.href = 'games.php';</script>";
            } else {
                echo "<script>alert('Failed to add game to cart. Please try again.');</script>";
            }
        }
    }
}
?>