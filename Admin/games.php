<?php
include 'header.php';
include '../Database/connection.php';

if (isset($_POST['submit'])) {
    
    $gameName = $_POST['game_name'];
    $gameDeveloper = $_POST['game_developer'];
    $description = $_POST['description'];
    $gameCategory = $_POST['game_category'];
    $releaseDate = $_POST['release_date'];
    $gamePrice = $_POST['game_price'];

    $gamePhoto = $_FILES['game_photo']['name'];
    $gamePhotoTemp = $_FILES['game_photo']['tmp_name'];
    $gameVideo = $_FILES['game_video']['name'];
    $gameVideoTemp = $_FILES['game_video']['tmp_name'];

    $photoPath = "../Database/uploads/photos/" . basename($gamePhoto);
    $videoPath = "../Database/uploads/videos/" . basename($gameVideo);

    move_uploaded_file($gamePhotoTemp, $photoPath);
    move_uploaded_file($gameVideoTemp, $videoPath);

    $checkQuery = "SELECT * FROM games WHERE game_name = '$gameName' AND game_developer = '$gameDeveloper'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('This game is already added. Try adding other games.')</script>";
    } else {

        $stmt = $conn->prepare("INSERT INTO games (game_name, game_developer, description, category_id, release_date, game_price, game_photo, game_video) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    

        $stmt->bind_param("ssssssss", $gameName, $gameDeveloper, $description, $gameCategory, $releaseDate, $gamePrice, $photoPath, $videoPath);
    

        if ($stmt->execute()) {
            echo "<script>alert('New game added successfully.')</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    }
    
}
?>


<div class="popup" id="addGamePopup">
    <div class="add-game-popup">
        <div class="add-game-header">
            <h1 class="add-game-title">Add Game</h1>
            <span class="close-btn" onclick="closeFunction()">&times;</span>
        </div>
        <div class="game-popup-body">
            <form action="" method="post" name="add_game_popup" enctype="multipart/form-data"
                onsubmit="return validateForm()">
                <div class="add-game-field">
                    <input type="text" id="game_name" name="game_name" placeholder="Game Name">
                </div>
                <div class="add-game-field">
                    <input type="text" id="game_developer" name="game_developer" placeholder="Developer">
                </div>
                <div class="add-game-field">
                    <textarea name="description" id="description" placeholder="Description"></textarea>
                </div>
                <div class="add-game-field">
                    <select name="game_category" id="game_category">
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
                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" name="release_date">
                </div>
                <div class="add-game-field">
                    <input type="text" id="game_price" name="game_price" placeholder="Game Price">
                </div>
                <div class="add-game-field">
                    <label for="game_photo">Photo</label>
                    <input type="file" id="game_photo" name="game_photo" accept="image/*">
                </div>
                <div class="add-game-field">
                    <label for="game_video">Video</label>
                    <input type="file" name="game_video" id="game_video" accept="video/*">
                </div>
                <div class="add-game-button">
                    <button type="submit" name="submit">Submit</button>
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
                <tbody>
                    <?php
                    $i = 0;
                    $games = "SELECT g.*, c.category_name 
                    FROM games g
                    INNER JOIN category c ON g.category_id = c.category_id";
                    $select = mysqli_query($conn, $games);
                    while ($row = mysqli_fetch_assoc($select)):
                        $i++;
                    ?>
                    <tr>
                        <td class="tdsno"><?php echo $i . '.'; ?></td>
                        <td class="tdphoto">
                            <?php
                        if (!empty($row['game_photo'])) {
                            echo '<img src="' . $row['game_photo'] . '" alt="Game Photo" class="game_photo">';
                        }
                        ?>
                        </td>
                        <td class="tdgamename"><?php echo $row['game_name']; ?></td>
                        <td class="tddeveloper"><?php echo $row['game_developer']; ?></td>
                        <td class="tdcategory"><?php echo $row['category_name']; ?></td>
                        <td class="tdreleasedate">
                            <?php
                            if (!empty($row['release_date'])) {
                                $formattedDate = date("M d, Y", strtotime($row['release_date']));
                                echo $formattedDate;
                            }
                        ?>
                        </td>
                        <td class="tdgameprice"><?php echo $row['game_price']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
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

function validateForm() {
    let isValid = true;

    const gameName = document.getElementById('game_name').value.trim();
    const gameDeveloper = document.getElementById('game_developer').value.trim();
    const description = document.getElementById('description').value.trim();
    const gameCategory = document.getElementById('game_category').value;
    const releaseDate = document.getElementById('release_date').value;
    const gamePrice = document.getElementById('game_price').value.trim();
    const gamePhoto = document.getElementById('game_photo').value;
    const gameVideo = document.getElementById('game_video').value;

    clearErrors();

    if (gameName === '') {
        displayError('game_name', 'Game name is required.');
        isValid = false;
    }
    if (gameDeveloper === '') {
        displayError('game_developer', 'Developer is required.');
        isValid = false;
    }
    if (description === '') {
        displayError('description', 'Description is required.');
        isValid = false;
    }
    if (gameCategory === '') {
        displayError('game_category', 'Please select a category.');
        isValid = false;
    }
    if (releaseDate === '') {
        displayError('release_date', 'Release date is required.');
        isValid = false;
    }
    if (gamePrice === '' || isNaN(gamePrice) || parseFloat(gamePrice) <= 0) {
        displayError('game_price', 'Please enter a valid price.');
        isValid = false;
    }
    if (gamePhoto === '') {
        displayError('game_photo', 'Please upload a photo.');
        isValid = false;
    }
    if (gameVideo === '') {
        displayError('game_video', 'Please upload a video.');
        isValid = false;
    }

    return isValid;
}

function displayError(fieldId, message) {

    const errorSpan = document.createElement('span');
    errorSpan.classList.add('error-message');
    errorSpan.innerText = message;

    const field = document.getElementById(fieldId).parentNode;
    field.appendChild(errorSpan);
}

function clearErrors() {
    const errorSpans = document.querySelectorAll('.error-message');
    errorSpans.forEach(span => span.remove());
}
</script>

<?php
include 'footer.php';
?>