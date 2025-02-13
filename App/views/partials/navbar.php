<?php

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
            <?php if ($_SESSION['user_type'] === 'admin'): ?>
                <a href="/admin-board">Manage Users</a>
                <a href="/librarian-board">Manage Books</a>
                <a href="/books">Read Books</a>
            <?php endif; ?>
            <?php if ($_SESSION['user_type'] === 'librarian'): ?>
                <a href="/librarian-board">Manage Books</a>
            <?php endif; ?>
            <?php if ($_SESSION['user_type'] === 'reader'): ?>
                <a href="/books">Read Books</a>
            <?php endif; ?>
            <a href="/signOut">Sign Out</a>
        <?php else: ?>
            <!-- Show Sign In and Sign Up when NOT logged in -->
            <a href="/signIn">Sign In</a>
            <a href="/signUp">Sign Up</a>
        <?php endif; ?>
    </div>
</header>
