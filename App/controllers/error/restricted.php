<?php
session_start();

// verific daca utilizatorul e conectat
if (!isset($_SESSION['user_type'])) {
    header("Location: /signIn");
    exit;
}
loadView('restricted');

?>
