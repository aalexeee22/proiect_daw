<?php
session_start(); // Start the session

// Load database configuration and initialize connection
$config = require basePath('config/db.php');
$db = new Database($config);
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and trim input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debug: Print received input
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Password: " . htmlspecialchars($password) . "<br>";

    // 🔹 Check if email or password is empty
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required!";
        echo "🔴 Redirecting due to empty fields...";
        exit; // Stop execution here before redirecting
    }

    try {
        // **SECURE QUERY USING PREPARED STATEMENTS**
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $sth = $conn->prepare($query);
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();

        // Fetch user data
        $user = $sth->fetch(PDO::FETCH_ASSOC);

        // 🔹 Debug: Print fetched user data
        echo "<pre>";
        var_dump($user);
        echo "</pre>";

        if (!$user) {
            $_SESSION['error'] = "Invalid email or password!";
            echo "🔴 No user found with this email!";
            exit;
        }

        // 🔹 Debug: Before password verification
        echo "Stored password: " . $user['password'] . "<br>";
        echo "Entered password: " . $password . "<br>";

        if ($password==$user['password']) {
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Store user data in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            echo "✅ Password verification successful! Redirecting...";

            // Redirect based on user type
            switch ($user['user_type']) {
                case 'admin':
                    echo "Redirecting to /admin-board";
                    header("Location: /admin-board");
                    exit;
                case 'librarian':
                    echo "Redirecting to /librarian-board";
                    header("Location: /librarian-board");
                    exit;
                case 'reader':
                    echo "Redirecting to /books";
                    header("Location: /books");
                    exit;
                default:
                    $_SESSION['error'] = "Invalid user type!";
                    echo "🔴 Invalid user type!";
                    exit;
            }
        } else {
            $_SESSION['error'] = "Invalid email or password!";
            echo "🔴 Password verification failed!";
            exit;
        }
    } catch (Exception $e) {
        // Log error and prevent exposing sensitive information
        error_log("Sign-in error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again!";
        echo "🔴 Error occurred: " . $e->getMessage();
        exit;
    }
}

loadView("signIn");
?>
