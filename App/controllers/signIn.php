<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /restricted-access");
    exit;
}

$config = require basePath('config/db.php');
$db = new Database($config);
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // validez formatul de mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: /signIn");
        exit;
    }

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required!";
        exit;
    }

    try {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $sth = $conn->prepare($query);//folosesc prepare anti SQL injection
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();

        $user = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['error'] = "Invalid email or password!";
            exit;
        }

        if ($user['active'] == 0) {
            $_SESSION['error'] = "Your account is not activated. Check your email.";
            header("Location: /signIn");
            exit;
        }

        if ($password==$user['password']) {
            session_regenerate_id(true);

            // stochez datele utilizatorului in sesiune
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            switch ($user['user_type']) {
                case 'admin':
                    header("Location: /admin-board");
                    exit;
                case 'librarian':
                    header("Location: /librarian-board");
                    exit;
                case 'reader':
                    header("Location: /books");
                    exit;
                default:
                    $_SESSION['error'] = "Invalid user type!";
                    header("Location: /restricted-access");
                    exit;
            }
        } else {
            $_SESSION['error'] = "Invalid email or password!";
            header("Location: /signIn");
            exit;
        }
    } catch (Exception $e) {
        error_log("Sign-in error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again!";
        header("Location: /signIn");
        exit;
    }
}

loadView("signIn");
?>