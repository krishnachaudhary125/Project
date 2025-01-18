<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $category = mysqli_real_escape_string($conn, trim($_POST['categoryInput']));
    $admin_id = $_SESSION['admin_id'];

    if (empty($category)) {
        echo "<script>alert('Category input cannot be empty.');</script>";
    } else {
        $select_query = "SELECT * FROM category WHERE category_name = ?";
        $stmt = $conn->prepare($select_query);

        if ($stmt === false) {
            error_log("SQL Prepare Error: " . $conn->error);
            echo "<script>alert('A database error occurred. Please try again later.');</script>";
            exit();
        }

        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('This category already exists.');</script>";
        } else {
            $sqlQuery = "INSERT INTO category (category_name, admin_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sqlQuery);

            if ($stmt === false) {
                error_log("SQL Prepare Error: " . $conn->error);
                echo "<script>alert('A database error occurred. Please try again later.');</script>";
                exit();
            }

            $stmt->bind_param("si", $category, $admin_id);

            if ($stmt->execute()) {
                echo "<script>alert('Category added successfully.');</script>";
            } else {
                echo "<script>alert('Error adding category.');</script>";
            }
        }
        $stmt->close();
    }
}
?>

<div class="popup" id="categoryPopup">
    <div class="add-category-popup">
        <div class="add-category-header">
            <h1 class="add-category-title">Add Category</h1>
            <span class="close-btn" onclick="closeCategoryPopup()">&times;</span>
        </div>
        <div class="category-popup-body">
            <form action="" method="post" name="category_popup">
                <div class="add-category-field">
                    <label for="categoryInput">Add Category</label>
                    <input type="text" id="categoryInput" name="categoryInput" value="" placeholder="Input Category"
                        required pattern="^[a-zA-Z0-9\s]+$">
                    <span></span>
                </div>
                <div class="add-category-button">
                    <button type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="category-main">
    <div class="category-header">
        <h1 class="category-title">Category</h1>
        <button type="button" class="category-popup-button" onclick="openCategoryPopup()">Add Category</button>
    </div>

    <div class="category-body">
        <div class="category-data">
            <table>
                <thead>
                    <tr>
                        <th class="thsno">S.No.</th>
                        <th class="thname">Category</th>
                        <th class="thadmin">Admin Id</th>
                        <th class="thaction" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $select_category = "SELECT * FROM category";
                    $category_select = mysqli_query($conn, $select_category);
                    while ($row_data = mysqli_fetch_assoc($category_select)):
                        $i++;
                    ?>
                    <tr>
                        <td class="tdsno"><?php echo $i . '.'; ?></td>
                        <td class="tdname">
                            <?php echo htmlspecialchars($row_data['category_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="adminid"><?php echo htmlspecialchars($row_data['admin_id'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td class="tdaction">
                            <a href="./category_edit.php?id=<?php echo $row_data['category_id']; ?>"
                                class="btn btn--small">Edit</a>
                        </td>
                        <td class="tdaction">
                            <a href="./Action/category_delete.php?id=<?php echo $row_data['category_id']; ?>"
                                class="btn btn--danger" onclick="return confirmDelete();">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function confirmDelete() {
    return confirm("You want to delete this category?");
};

function openCategoryPopup() {
    document.getElementById("categoryPopup").style.display = "block";
};

function closeCategoryPopup() {
    document.getElementById("categoryPopup").style.display = "none";
};
</script>

<?php include 'footer.php'; ?>