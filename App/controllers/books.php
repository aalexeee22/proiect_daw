<?php
$config=require basePath('config/db.php');
$db=new Database($config);
$books=$db->query("SELECT * FROM books")->fetchAll();

loadView("books", ['books'=>$books]);

?>
