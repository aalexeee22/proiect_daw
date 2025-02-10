<?php
session_start();
$config=require basePath('config/db.php');
$db=new Database($config);
$conn = $db->getConnection();
$users=$db->query("SELECT * FROM users")->fetchAll();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to a restricted page or login page
    header("Location: /restricted-access");
    exit;
}

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
            $first_name = $conn->quote($_POST['first_name']);
            $db->query("UPDATE users SET first_name = " . $first_name . " WHERE user_id = " . $user_id);
        }

        if (!empty($_POST['last_name'])) {
            $last_name = $conn->quote($_POST['last_name']);
            $db->query("UPDATE users SET last_name = " . $last_name . " WHERE user_id = " . $user_id);
        }

        if (!empty($_POST['email'])) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "Error: Invalid email format!";
                exit;
            }
            $email = $conn->quote($_POST['email']);
            $db->query("UPDATE users SET email = " . $email . " WHERE user_id = " . $user_id);
        }

        if (!empty($_POST['password'])) {
            $db->query("UPDATE users SET password ='" .$_POST['password']."' WHERE user_id = ".$user_id);
        }
        if (!empty($_POST['password'])) {
            $password = $conn->quote($_POST['password']);
            $db->query("UPDATE users SET password = " . $password . " WHERE user_id = " . $user_id);
        }
        $allowedRoles = ["admin", "librarian", "reader"];
        if (!empty($_POST['user_type'])) {
            $user_type = $_POST['user_type'];

            if (!in_array($user_type, $allowedRoles)) {
                echo "Error: Invalid user role!";
                exit;
            }

            $user_type = $conn->quote($user_type);
            $db->query("UPDATE users SET user_type = '" . $user_type . "' WHERE user_id = " . $user_id);
        }


        // Redirect to avoid resubmission
        header("Location: /admin-board");
        exit;
    } else {
        echo "Error: User not found.";
    }
}

// Handle CREATE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['user_type'])) {
    $first_name = $conn->quote($_POST['first_name']);
    $last_name = $conn->quote($_POST['last_name']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format!";
        exit;
    }

    // Validate user role
    $allowedRoles = ["admin", "librarian", "reader"];
    if (!in_array($user_type, $allowedRoles)) {
        echo "Error: Invalid user role!";
        exit;
    }

    $email = $conn->quote($email);
    $user_type = $conn->quote($user_type);
    $password = $conn->quote($password);

    $existingUser = $db->query("SELECT * FROM users WHERE email = " . $email)->fetch();
    if ($existingUser) {
        $_SESSION['message'] = "Error: A user with this email already exists!";
        header("Location: /admin-board");
        exit;
    }

    $db->query("INSERT INTO users (first_name, last_name, email, password, user_type) VALUES ($first_name, $last_name, $email, $password, $user_type)");

    $_SESSION['message'] = "User created successfully.";
    header("Location: /admin-board");
    exit;
}


loadView("adminBoard", ['users'=>$users]);

?>