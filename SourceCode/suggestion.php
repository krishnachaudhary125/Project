<?php
include "header.php";
include "../Database/connection.php";
?>

<div class="suggestion-container">
    <form action="#" method="post" class="suggestion">
        <h1>Suggestion</h1>
        <div class="suggestion-field">
            <textarea name="suggestion" id="suggestion" placeholder="Enter Suggestion"></textarea>
        </div>
        <button type="submit" id="submit" name="submit">Send</button>
    </form>
</div>

<?php
include "footer.php";
?>