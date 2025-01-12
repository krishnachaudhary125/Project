<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $category = mysqli_real_escape_string($conn, $_POST['categoryInput']);

    $select_query = "SELECT * FROM category WHERE category_name = ?";
    $stmt = $conn->prepare($select_query);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('This category already exists.')</script>";
    } else {
        $admin_id = $_SESSION['admin_id'];
        $sqlQuery = "INSERT INTO category (category_name, admin_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sqlQuery);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $category);

        if ($stmt->execute()) {
            echo "<script>alert('Category added successfully.')</script>";
        } else {
            echo "<script>alert('Error adding category.')</script>";
        }
    }
    $stmt->close();
}

?>

<div class="popup" id="categoryPopup">
    <div class="add-category-popup">
        <div class="add-category-header">
            <h1 class="add-category-title">Add Category</h1>
            <span class="close-btn" onclick="closeFunction()">&times;</span>
        </div>
        <div class="category-popup-body">
            <form action="" method="post" name="category_popup">
                <div class="add-category-field">
                    <label for="categoryInput">Add Category</label>
                    <input type="text" id="categoryInput" name="categoryInput" value="" placeholder="Input Category">
                </div>
                <div class="add-category-button">
                    <button type="submit" onclick="submitCategory()" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="category-main">

    <div class="category-header">
        <h1 class="category-title">Category</h1>
        <button type="submit" class="category-popup-button" onclick="myFunction()">Add Category</button>
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

                <?php
                $i = 0;
                $select_category = "SELECT * from category";
                $category_select = mysqli_query($conn, $select_category);
                while ($row_data = mysqli_fetch_assoc($category_select)):
                    $i++;
                ?>
                <tbody>
                    <tr>
                        <td class="tdsno"><?php echo $i . '.'; ?></td>
                        <td class="tdname"><?php echo $row_data['category_name']; ?></td>
                        <td class="adminid"><?php echo $_SESSION['admin_id'] ?></td>
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

function myFunction() {
    document.getElementById("categoryPopup").style.display = "block";
};

function closeFunction() {
    document.getElementById("categoryPopup").style.display = "none";
};
let formEle = document.category_popup,
    categoryInput = formEle.categoryInput;
let fieldArr = document.querySelectorAll(".add-category-field");

fieldArr.forEach(field => {
    let span = document.createElement("span");
    field.append(span);
});
formEle.addEventListener("submit", e => {
    if (categoryInput.value == '') {
        categoryInput.nextElementSibling.innerText = "Please Enter Category.";
        e.preventDefault();
    }
})
</script>

<?php
include 'footer.php';
?>