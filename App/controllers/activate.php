<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /restricted-access");
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
        exit;
    }

    try {
        $query = "SELECT * FROM users WHERE activation_code = :activation_code LIMIT 1";
        $sth = $conn->prepare($query);
        $sth->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        $sth->execute();

        $user = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['error'] = "Invalid activation code!";
            header("Location: /activate");
            exit;
        }

        // verific daca a expirat codul de activare
        $activation_expiry = strtotime($user['activation_expiry']);
        $current_time = time();

        if ($activation_expiry < $current_time) {
            // stergere user pt activation code expirat
            $deleteQuery = "DELETE FROM users WHERE user_id = :user_id";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->execute([':user_id' => $user['user_id']]);

            $_SESSION['error'] = "Your activation code has expired. You need to sign up again.";
            header("Location: /signUp");
            exit;
        }

        if ($user['active'] == 1) {
            $_SESSION['error'] = "Your account is already activated. Go sign in!";
            header("Location: /signIn");
            exit;
        }
        if ($activation_code==$user['activation_code']) {
            $user_id = $user['user_id'];
            $updateQuery = "UPDATE users SET active = 1, activation_code = NULL WHERE user_id = :user_id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([':user_id' => $user_id]);

            $_SESSION['success'] = "Account activated! You can now sign in.";
            header("Location: /signIn");
            exit;
        } else {
            $_SESSION['error'] = "Invalid or expired activation link.";
            exit;
        }
    } catch (Exception $e) {
        error_log("Code activation error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again!";
        header("Location: /activate");
        exit;
    }
}
loadView("activate");
?>