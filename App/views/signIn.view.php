<?php
loadPartial('head');
loadPartial('body');
loadPartial('navbar');
?>

<div class="sign-in-big-container">
    <div class="sign-in-container">
        <h1>Sign In</h1>
        <form >
            <input type="text" name="username" placeholder="Username" required>
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
