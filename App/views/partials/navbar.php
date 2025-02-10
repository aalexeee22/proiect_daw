<?php
// Check if a session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <div class="logo">
        <a style="text-decoration: none; color: white;" href="/"><h2>Library</h2></a>
    </div>

    <div class="buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/signOut">Sign Out</a>
        <?php else: ?>
            <!-- Show Sign In and Sign Up when NOT logged in -->
            <a href="/signIn">Sign In</a>
            <a href="/signUp">Sign Up</a>
        <?php endif; ?>
    </div>
</header>
