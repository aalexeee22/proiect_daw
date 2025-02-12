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
// Check if an error message exists and store it in a variable
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error message after displaying
?>

<div class="sign-in-big-container">
    <div class="sign-in-container">
        <h1>Activation</h1>
        <!-- Display Error Message -->
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
