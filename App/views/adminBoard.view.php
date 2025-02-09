<?php

loadPartial('head');
loadPartial('body');
loadPartial('navbar');

?>
<div class="welcome-message">
    <h1>These are all the users.</h1>

    <!-- Display error or success messages when adding a new user-->
    <?php if (isset($_SESSION['message'])): ?>
        <div id="message-box"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?> <!-- Clear the message after showing it -->
    <?php endif; ?>
    <!-- Button to Show Add User Form -->
    <button onclick="toggleCreateUserForm()" class="add-button">Add New User</button>

    <!-- Create User Form (Hidden by Default) -->
    <form method="POST" id="create-user-form" style="display: none;">
        <label>First Name:</label>
        <input type="text" name="first_name" placeholder="Enter first name" required>
        <br/>

        <label>Last Name:</label>
        <input type="text" name="last_name" placeholder="Enter last name" required>
        <br/>

        <label>Email:</label>
        <input type="email" name="email" id="create_email" placeholder="Enter email" required>
        <br/>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>
        <br/>

        <label>User Rights:</label>
        <select name="user_type" id="create_user_type" required>
            <option value="">Select User Role</option>
            <option value="admin">admin</option>
            <option value="librarian">librarian</option>
            <option value="reader">reader</option>
        </select>
        <br/>

        <button type="submit" class="save-button" onclick="return validateCreateEmail()" >Create User</button>
    </form>

    <hr/>

    <?php foreach ($users as $user): ?>
        <div class="card">
            <h4>Name: <?php print($user["first_name"])?> <?php print($user["last_name"])?></h4>
            <h4>Email: <?php print($user["email"])?></h4>
            <h4>Password: <?php print($user["password"])?>
            <h4>User rights: <?php print($user["user_type"])?></h4>

            <button onclick="toggleUpdateForm(<?php echo $user['user_id']; ?>)" >Update</button>

            <form  method="POST" style="display: inline;">
                <input type="hidden" name="delete_user_id" value="<?php echo $user['user_id']; ?>">
                <button type="submit" class="delete-button">Delete</button>
            </form>

            <form method="POST" class="update-form" id="update-form-<?php echo $user['user_id']; ?>" style="display: none;">
                <input type="hidden" name="update_user_id" value="<?php echo $user['user_id']; ?>">
                <label>First Name:</label>
                <input type="text" name="first_name" placeholder="Enter new first name">
                <br/>
                <label>Last Name:</label>
                <input type="text" name="last_name" placeholder="Enter new last name">
                <br/>
                <label>Email:</label>
                <input type="email" name="email" id="email_<?php echo $user['user_id']; ?>" placeholder="Enter new email">
                <br/>
                <label>Password:</label>
                <input type="password" name="password" placeholder="Enter new password">
                <br/>
                <label>User Rights:</label>
                <select name="user_type" id="user_type_<?php echo $user['user_id']; ?>">
                    <option value="">Select User Role</option>
                    <option value="admin">admin</option>
                    <option value="librarian">librarian</option>
                    <option value="reader">reader</option>
                </select>
                <br/>
                <button type="submit" class="save-button">Save Changes</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleCreateUserForm() {
        var form = document.getElementById("create-user-form");
        form.style.display = form.style.display === "none" ? "block" : "none";
    }

    function showMessage(message, isError = false) {
        var messageBox = document.getElementById("message-box");
        messageBox.style.display = "block";
        messageBox.style.backgroundColor = isError ? "#ffcccc" : "#ccffcc";
        messageBox.innerHTML = message;
    }

    function toggleUpdateForm(userId) {
        var form = document.getElementById("update-form-" + userId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    }

    function validateEmail(userId) {
        var email = document.getElementById("email_" + userId).value;
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regular expression for email validation

        // Validate email format
        if (email !== "" && !emailPattern.test(email)) {
            alert("Invalid email format! Please enter a valid email with '@'.");
            return false;
        }

        return true;
    }
</script>
<?php
loadPartial('footer');
?>
