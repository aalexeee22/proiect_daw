<?php
// Check if a session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
loadPartial('head');
loadPartial('body');
loadPartial('navbar');

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>

<div class="sign-in-big-container">
    <div class="sign-in-container">
        <h1>Activation</h1>
        <!-- afisez eroarea daca exista -->
        <?php if (!empty($error)): ?>
            <div id="message-box" class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="/activate" ">
            <input type="text" name="activation_code" placeholder="Activation code" required>
            <button type="submit">Activate</button>
        </form>
    </div>
</div>


<?php
loadPartial('footer');
?>
