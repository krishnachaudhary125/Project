<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}

?>


<div class="popup" id="addGamePopup">
    <div class="add-game-popup">
        <div class="add-game-header">
            <h1 class="add-game-title">Add Game</h1>
            <span class="close-btn" onclick="closeFunction()">&times;</span>
        </div>
        <div class="game-popup-body">
            <form action="" method="post" name="add_game_popup" enctype="multipart/form-data">
                <div class="add-game-field">
                    <input type="text" id="gname" name="gname" value="" placeholder="Game Name">
                </div>
                <div class="add-game-field">
                    <input type="text" id="developer" name="developer" value="" placeholder="Developer">
                </div>
                <div class="add-game-field">
                    <textarea name="gameDescription" id="gameDescription" placeholder="Description"></textarea>
                </div>
                <div class="add-game-field">
                    <select name="gameCategory" id="gameCategory">
                        <option value="" disabled selected hidden>Select Category</option>
                        <?php
                        $select_category = "SELECT * from category";
                        $category_select = mysqli_query($conn, $select_category);
                        while ($row_data = mysqli_fetch_assoc($category_select)):
                        ?>
                        <option value="<?php echo $row_data['category_id']; ?>">
                            <?php echo $row_data['category_name']; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
                <div class="add-game-field">
                    <input type="text" id="gamePrice" name="gamePrice" value="" placeholder="Game Price">
                </div>
                <div class="add-game-field">
                    <label for="date">Release Date</label>
                    <input type="date" id="date" name="releaseDate" value="">
                </div>
                <div class="add-game-field">
                    <label for="photo">Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                <div class="add-game-field">
                    <label for="video">Video</label>
                    <input type="file" name="video" id="video" accept="video/*">
                </div>
                <div class="add-game-button">
                    <button type="submit" onclick="submitGame()" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="games-main">
    <div class="games-header">
        <h1 class="games-title">Games</h1>
        <button type="submit" class="game-popup-button" onclick="myFunction()">Add Game</button>
    </div>

    <div class="game-body">
        <div class="game-data">
            <table>
                <thead>
                    <tr>
                        <th class="thsno">S.No.</th>
                        <th class="">Game Photo</th>
                        <th class="">Game Name</th>
                        <th class="">Developer</th>
                        <th class="th_category">Category</th>
                        <th class="th_release_date">Release Date</th>
                        <th class="th_game_price">Game Price (NPR)</th>
                        <th class="thaction" colspan="2">Actions</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<script>
function myFunction() {
    document.getElementById("addGamePopup").style.display = "block";
};

function closeFunction() {
    document.getElementById("addGamePopup").style.display = "none";
};
</script>

<?php
include 'footer.php';
?>