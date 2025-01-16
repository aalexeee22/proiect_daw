<?php
$config = require basePath('config/db.php');
$db = new Database($config);

// Fetch all books
$books = $db->query("SELECT * FROM books")->fetchAll();

// Handle book deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book_id'])) {
    $book_id = intval($_POST['delete_book_id']);

    // Delete the book with the given ID using positional placeholders
    $db->query("DELETE FROM books WHERE book_id = ?", [$book_id]);

    // Redirect to avoid form resubmission
    header("Location: /books");
    exit;
}

loadView("books", ['books' => $books]);
?>
