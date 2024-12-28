<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
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
                        <th class="thaction" colspan="2">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
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