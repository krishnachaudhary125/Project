<?php
include 'header.php';
include '../Database/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Unauthorized page!');</script>";
    echo "<script>window.location.href = '../SourceCode/index.php';</script>";
    exit();
}
?>

<div class="suggestion-main">
    <div class="suggestion-header">
        <h1 class="suggestion-title">Suggestions</h1>
    </div>

    <div class="suggestion-body">
        <div class="suggestion-data">
            <table>
                <thead>
                    <tr>
                        <th class="thsno">S.No.</th>
                        <th class="thuserid">User Id</th>
                        <th class="thsuggestion">Suggestion</th>
                        <th class="thaction">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $select_suggestion = "SELECT * FROM suggestions";
                    $suggestion_select = mysqli_query($conn, $select_suggestion);
                    while ($row_data = mysqli_fetch_assoc($suggestion_select)):
                        $i++;
                    ?>
                    <tr>
                        <td class="tdsno"><?php echo $i . '.'; ?></td>
                        <td class="tduserid"><?php echo $row_data['user_id'];?></td>
                        <td class="tdsuggestion"><?php echo $row_data['suggestion'];?></td>
                        <td class="tdaction">
                            <a href="./Action/suggestion_delete.php?id=<?php echo $row_data['suggestion_id']; ?>"
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
    return confirm("You want to delete this suggestion!!");
};
</script>

<?php
include 'footer.php';
?>