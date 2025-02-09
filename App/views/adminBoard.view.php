<?php

loadPartial('head');
loadPartial('body');
loadPartial('navbar');

?>
<div class="welcome-message">
    <h1>These are all the users.</h1>
    <?php foreach ($users as $user): ?>
        <div class="card">
            <h3>Name: <?php print($user["first_name"])?> <?php print($user["last_name"])?></h3>
            <h4>Email: <?php print($user["email"])?></h4>
            <h4>Password: <?php print($user["password"])?>
            <h4>User rights: <?php print($user["user_type"])?></h4>

            <button onclick="toggleUpdateForm(<?php echo $user['user_id']; ?>)">Update</button>

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
    function toggleUpdateForm(userId) {
        var form = document.getElementById("update-form-" + userId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
</script>
<script>
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
