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
    <button class="read-button" onclick="window.open('<?php print($book["link"]) ?>', '_blank');">Read</button>
</div>
    <?php endforeach; ?>
</div>
<?php
loadPartial('footer');
?>
