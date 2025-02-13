<?php
session_destroy(); // distrug sesiunea
// sterg cookie-urile daca exista
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
header("Location: /signIn");
exit;
?>
