<?php
session_start();
$config=require basePath('config/db.php');
$db=new Database($config);

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'reader' && $_SESSION['user_type'] != 'admin') ) {
    header("Location: /restricted-access");
    exit;
}

$books=$db->query("SELECT * FROM books")->fetchAll();

loadView("books", ['books'=>$books]);

?>
