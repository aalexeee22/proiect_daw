<?php
session_start();
$config=require basePath('config/db.php');
$db=new Database($config);

// Check if user is logged in and is a reader or admin
if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'reader' && $_SESSION['user_type'] != 'admin') ) {
    // Redirect to a restricted page or login page
    header("Location: /restricted-access");
    exit;
}

$books=$db->query("SELECT * FROM books")->fetchAll();

loadView("books", ['books'=>$books]);

?>
