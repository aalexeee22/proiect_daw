<?php

loadPartial('head');
loadPartial('body');
loadPartial('navbar');

?>
    <div class="welcome-message">
        <h1>These are the available books.</h1>
        <?php foreach ($books as $book): ?>
            <div class="card">
                <h3><?php print($book["title"])?></h3>
                <h4><?php print($book["author"])?></h4>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="delete_book_id" value="<?php echo $book['book_id']; ?>">
                    <button type="submit" class="delete-button">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php
loadPartial('footer');
?>