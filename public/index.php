<?php
require '../helpers.php';


/*Functia de mai jos incarca automat clasele*/
spl_autoload_register(function ($class) {
    $path=basePath('Framework/'.$class.'.php');
    if(file_exists($path)){
        require $path;
    }
});

$router = new Router();
$routes= require basePath('routes.php');

$uri=$_SERVER['REQUEST_URI'];
$method=$_SERVER['REQUEST_METHOD'];

$router->route($uri,$method);
?>

