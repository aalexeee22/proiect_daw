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
        <h1>Sign In</h1>
        <form method="POST" action="/signIn">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <!--<a href="#">Forgot Password?</a>-->
        <a href="/signUp">Don't have an account? Sign Up</a>
    </div>
</div>
<?php
loadPartial('footer');
?>
