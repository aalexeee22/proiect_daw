<?php
loadPartial('head');
loadPartial('body');
loadPartial('navbar');


?>
    <div class="welcome-message">
        <h1>Welcome to Our Library</h1>
        <p>Your gateway to a world of knowledge and discovery!</p>
        <p><?php require_once __DIR__ . '/../controllers/wordOfTheDay.php';?></p>
    </div>

<?php
loadPartial('footer');
?>
