<?php
$config=require basePath('config/db.php');
$db=new Database($config);
$users=$db->query("SELECT * FROM users")->fetchAll();

loadView("adminBoard", ['users'=>$users]);

?>
