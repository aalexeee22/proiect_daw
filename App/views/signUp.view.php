<?php
loadPartial('head');
loadPartial('body');
loadPartial('navbar');
?>
<?php if (isset($_SESSION['error'])): ?>
    <div id="message-box"><?php echo $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?> <!-- Clear the message after showing it -->
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
    <div id="message-box"><?php echo $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?> <!-- Clear the message after showing it -->
<?php endif; ?>
<div class="sign-up-big-container">
<div class="sign-up-container">
    <h1>Sign Up</h1>
    <form action="/signUp" method="post" onsubmit="return validateSignUp()">
        <input type="text" name="first_name" id="first_name" placeholder="First name" required>
        <input type="text" name="last_name" id="last_name" placeholder="Last name" required>
        <input type="email" name="email" id="email"  placeholder="Email" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <a href="/signIn">Already have an account? Sign In</a>
</div>
</div>
    <script>
        function validateSignUp() {
            var firstName = document.getElementById("first_name").value.trim();
            var lastName = document.getElementById("last_name").value.trim();
            var email = document.getElementById("email").value.trim();
            var password = document.getElementById("password").value.trim();
            var confirmPassword = document.getElementById("confirm_password").value.trim();
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!firstName || !lastName || !email || !password || !confirmPassword) {
                alert("All fields are required!");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Invalid email format!");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }

            return true;
        }
    </script>
<?php
loadPartial('footer');
?>