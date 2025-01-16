<?php

loadPartial('head');
loadPartial('body');
loadPartial('navbar');

?>
<div class="welcome-message">
    <h1>These are all the users.</h1>
    <?php foreach ($users as $user): ?>
        <div class="card">
            <h3>Name: <?php print($user["first_name"])?> <?php print($user["last_name"])?></h3>
            <h4>Email: <?php print($user["email"])?></h4>
            <h4>Password: <?php print($user["password"])?></h4>
            <button>Update</button>
            <button style="background: crimson; color:whitesmoke;">Delete</button>
        </div>
    <?php endforeach; ?>
</div>
<?php
loadPartial('footer');
?>
