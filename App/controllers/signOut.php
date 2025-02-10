<?php
session_destroy(); // Destroy session data
// Remove session cookie (if exists)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
header("Location: /signIn"); // Redirect to sign-in page
exit;
?>
