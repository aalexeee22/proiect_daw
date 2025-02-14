<?php

loadPartial('head');
loadPartial('body');
loadPartial('navbar');

?>
    <div class="welcome-message">
        <h1>These are the available books.</h1>
        <!-- mesaj dupa adaugarea unei carti-->
        <?php if (isset($_SESSION['message'])): ?>
            <div id="message-box"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <button onclick="toggleCreateBookForm()" class="add-button">Add New Book</button>

        <!-- formular de adaugare carti (default hidden) -->
        <form method="POST" id="create-book-form" style="display: none;">
            <p class="title_form">New book</p>
            <br/>
            <input type="text" name="title" placeholder="Title" required>
            <br/>

            <input type="text" name="author" placeholder="Author" required>
            <br/>

            <input type="text" name="link" placeholder="Link" required>
            <br/>


            <button type="submit" class="save-button" onclick="return validateCreateEmail()" >Create Book</button>
        </form>

        <hr/>

        <?php foreach ($books as $book): ?>
            <div class="card">
                <h3><?php print($book["title"])?></h3>
                <h4><?php print($book["author"])?></h4>
                <h4><?php print($book["link"])?></h4>
                <button onclick="toggleUpdateForm(<?php echo $book['book_id']; ?>)">Update</button>
                
                <form  method="POST" style="display: inline;">
                    <input type="hidden" name="delete_book_id" value="<?php echo $book['book_id']; ?>">
                    <button type="submit" class="delete-button">Delete</button>
                </form>
                
                <form method="POST" class="update-form" id="update-form-<?php echo $book['book_id']; ?>" style="display: none;">
                    <input type="hidden" name="update_book_id" value="<?php echo $book['book_id']; ?>">
                    <label>Title:</label>
                    <input type="text" name="title" placeholder="Enter new title">
                    <br/>
                    <label>Author:</label>
                    <input type="text" name="author" placeholder="Enter new author">
                    <br/>
                    <label>Link:</label>
                    <input type="text" name="link" placeholder="Enter new link">
                    <br/>
                    <button type="submit" class="save-button">Save Changes</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        function toggleCreateBookForm() {
            var form = document.getElementById("create-book-form");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
        function showMessage(message, isError = false) {
            var messageBox = document.getElementById("message-box");
            messageBox.style.display = "block";
            messageBox.style.backgroundColor = isError ? "#ffcccc" : "#ccffcc";
            messageBox.innerHTML = message;
        }
        function toggleUpdateForm(bookId) {
            var form = document.getElementById("update-form-" + bookId);
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
<?php
loadPartial('footer');
?>