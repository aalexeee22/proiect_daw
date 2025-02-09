<?php
$config=require basePath('config/db.php');
$db=new Database($config);
$users=$db->query("SELECT * FROM users")->fetchAll();

//handle delete user from admin board
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];
    echo $user_id;
    // Delete the book with the given ID using positional placeholders
    $db->query("DELETE FROM users WHERE user_id =".$user_id);


    // Redirect to avoid form resubmission
    header("Location: /admin-board");
    exit;
}


// Handle UPDATE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user_id'])) {
    $user_id = $_POST['update_user_id'];

    // Fetch existing user data
    $userExists = $db->query("SELECT * FROM users WHERE user_id =".$user_id)->fetch();

    if ($userExists) {

        if (!empty($_POST['first_name'])) {
            $db->query("UPDATE users SET first_name ='" .$_POST['first_name']."' WHERE user_id = ".$user_id);
        }

        if (!empty($_POST['last_name'])) {
            $db->query("UPDATE users SET last_name ='" .$_POST['last_name']."' WHERE user_id = ".$user_id);
        }

        if (!empty($_POST['email'])) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "Error: Invalid email format!";
                exit;
            }
            $db->query("UPDATE users SET email ='" .$_POST['email']."' WHERE user_id = ".$user_id);
        }

        if (!empty($_POST['password'])) {
            $db->query("UPDATE users SET password ='" .$_POST['password']."' WHERE user_id = ".$user_id);
        }
        $allowedRoles = ["admin", "librarian", "reader"];
        if (!empty($_POST['user_type'])) {
            $user_type = $_POST['user_type'];

            if (!in_array($user_type, $allowedRoles)) {
                echo "Error: Invalid user role!";
                exit;
            }

            $user_type = addslashes($user_type);
            $db->query("UPDATE users SET user_type = '" . $user_type . "' WHERE user_id = " . $user_id);
        }


        // Redirect to avoid resubmission
        header("Location: /admin-board");
        exit;
    } else {
        echo "Error: User not found.";
    }
}


loadView("adminBoard", ['users'=>$users]);

?>
