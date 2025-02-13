<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
loadPartial('head');
loadPartial('body');
loadPartial('navbar');

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // sterg eroarea dupa afisare
?>

<div class="sign-in-big-container">
    <div class="sign-in-container">
        <h1>Sign In</h1>
        <!-- Display Error Message -->
        <?php if (!empty($error)): ?>
            <div id="message-box" class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="/signIn" onsubmit="return validateSignIn()">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <!--<a href="#">Forgot Password?</a>-->
        <a href="/signUp">Don't have an account? Sign Up</a>
    </div>
</div>

<script>
    function validateSignIn() {
        var email = document.getElementById("email").value.trim();
        var password = document.getElementById("password").value.trim();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !password) {
            alert("Both email and password are required!");
            return false;
        }

        if (!emailPattern.test(email)) {
            alert("Invalid email format! Please enter a valid email.");
            return false;
        }

        return true;
    }
</script>


<?php
loadPartial('footer');
?>
