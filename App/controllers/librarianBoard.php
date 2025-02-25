<?php
session_start();
$config = require basePath('config/db.php');
$db = new Database($config);
$conn = $db->getConnection();

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] !== 'librarian'&& $_SESSION['user_type'] !== 'admin')) {
    header("Location: /restricted-access");
    exit;
}

// scot toate cartile din bd
$books = $db->query("SELECT * FROM books")->fetchAll();

// stergerea cartilor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book_id'])) {
    $book_id = $_POST['delete_book_id'];
    echo $book_id;
    $db->query("DELETE FROM books WHERE book_id =".$book_id);

    header("Location: /librarian-board");
    exit;
}

// actualizarea cartilor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book_id'])) {
    $book_id = $_POST['update_book_id'];

    $bookExists = $db->query("SELECT * FROM books WHERE book_id =".$book_id)->fetch();

    if ($bookExists) {
        if (!empty($_POST['title'])) {
            $title = $conn->quote($_POST['title']);
            $db->query("UPDATE books SET title = " . $title . " WHERE book_id = " . $book_id);
        }

        if (!empty($_POST['author'])) {
            $author = $conn->quote($_POST['author']);
            $db->query("UPDATE books SET author = " . $author . " WHERE book_id = " . $book_id);
        }

        if (!empty($_POST['link'])) {
            $link = $conn->quote($_POST['link']);
            $db->query("UPDATE books SET link = " . $link . " WHERE book_id = " . $book_id);
        }
        header("Location: /librarian-board");
        exit;
    } else {
        echo "Error: Book not found.";
    }
}

// crearea cartilor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['author'], $_POST['link'])) {
    $title = $conn->quote($_POST['title']);
    $author = $conn->quote($_POST['author']);
    $link = $conn->quote($_POST['link']);

    $existingBook = $db->query("SELECT * FROM books WHERE link = " . $link)->fetch();
    if ($existingBook) {
        $_SESSION['message'] = "Error: A book with this link already exists!";
        header("Location: /librarian-board");
        exit;
    }

    $db->query("INSERT INTO books (title, author, link) VALUES ($title, $author, $link)");

    $_SESSION['message'] = "Book created successfully.";
    header("Location: /librarian-board");
    exit;
}

loadView("librarianBoard", ['books' => $books]);
?>