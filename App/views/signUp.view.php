<?php
loadPartial('head');
loadPartial('body');
loadPartial('navbar');
?>

<div class="sign-up-big-container">
<div class="sign-up-container">
    <h1>Sign Up</h1>
    <form action="process_signup.php" method="post">
        <input type="text" name="first_name" placeholder="First name" required>
        <input type="text" name="last_name" placeholder="Last name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Sign Up</button>
    </form>
    <a href="/signIn">Already have an account? Sign In</a>
</div>
</div>
<?php
loadPartial('footer');
?>