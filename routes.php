<?php
$router->get('/', 'controllers/home.php'); /*nu este o eroare, folosesc codul dupa ce am $router*/
$router->get('/signIn', 'controllers/signIn.php');
$router->get('/books', 'controllers/books.php');
$router->get('/admin-board', 'controllers/adminBoard.php');
$router->get('/signUp', 'controllers/signUp.php');
$router->get('/librarian-board', 'controllers/librarianBoard.php');
$router->get('404', 'controllers/error/404.php');

?>