<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_type'])) {
    header("Location: /signIn"); // Redirect to sign-in if not logged in
    exit;
}
loadView('restricted');

?>
