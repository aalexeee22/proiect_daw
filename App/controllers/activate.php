<?php
session_start(); // Start the session
if (isset($_SESSION['user_id'])) {
    header("Location: /restricted-access"); // Redirect to home or change to /dashboard if needed
    exit;
}
// Load database configuration and initialize connection
$config = require basePath('config/db.php');
$db = new Database($config);
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $activation_code = $_POST['activation_code'];

    // check if code is empty
    if (empty($activation_code)) {
        $_SESSION['error'] = "Code is required!";
        //echo "empty field...";
        exit; // Stop execution here
    }

    try {
        // **SECURE QUERY USING PREPARED STATEMENTS**
        $query = "SELECT * FROM users WHERE activation_code = :activation_code LIMIT 1";
        $sth = $conn->prepare($query);
        $sth->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        $sth->execute();

        // Fetch user data
        $user = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['error'] = "Invalid activation code!";
            //echo "No user found with this activation code!";
            exit;
        }

        // 🔹 Debug: Before password verification
        /*
        echo "Stored password: " . $user['password'] . "<br>";
        echo "Entered password: " . $password . "<br>";
*/

        if ($user['active'] == 1) {
            $_SESSION['error'] = "Your account is already activated. Go sign in!";
            header("Location: /signIn");
            exit;
        }
        if ($activation_code==$user['activation_code']) {

            $user_id = $user['user_id'];

            // Redirect based on user type
            $updateQuery = "UPDATE users SET active = 1, activation_code = NULL WHERE user_id = :user_id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([':user_id' => $user_id]);

            $_SESSION['success'] = "Account activated! You can now sign in.";
            header("Location: /signIn");
            exit;
        } else {
            $_SESSION['error'] = "Invalid or expired activation link.";
            header("Location: /signIn");
            exit;
        }
    } catch (Exception $e) {
        // Log error and prevent exposing sensitive information
        error_log("Code activation error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again!";
        header("Location: /activate");
        //echo "🔴 Error occurred: " . $e->getMessage();
        exit;
    }
}
loadView("activate");
?>