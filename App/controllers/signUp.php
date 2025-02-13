<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /restricted-access");
    exit;
}
require_once basePath('config/db.php');
require_once basePath('PHPMailer-master/src/PHPMailer.php');
require_once basePath('PHPMailer-master/src/SMTP.php');
require_once basePath('PHPMailer-master/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$usernameG='';
$passwordG='';

$db = new Database(require basePath('config/db.php'));
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = $_POST['email'];
    $password = trim($_POST['password']);

    // verific daca exista deja mail-ul
    $emailQuery = "SELECT COUNT(*) FROM users WHERE email = :email";
    $emailStmt = $conn->prepare($emailQuery);
    $emailStmt->execute([':email' => $email]);
    $emailExists = $emailStmt->fetchColumn();

    if ($emailExists > 0) {
        $_SESSION['error'] = "This email is already in use. Please use a different email address.";
        header("Location: /signUp");
        exit;
    }

    // generez codul de activare
    $activation_code = bin2hex(random_bytes(16));
    $activation_expiry = date("Y-m-d H:i:s", strtotime("+1 day")); // 24-hour expiry

    try {
        // trimit mail de activare
        $domain='http://localhost';
        $activation_link = "$domain/activate";
        $message = "Hello $first_name, click the link below to activate your account by entering $activation_code at:\n$activation_link";
        $message = wordwrap($message, 160, "<br />\n");

        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $usernameG;
        $mail->Password = $passwordG;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom($usernameG, 'Library');
        $mail->addAddress($email, "$first_name $last_name");
        $mail->Subject = 'Activate Your Account';
        $mail->Body = $message;

        if (!$mail->send()) {
            throw new Exception("Email failed to send.");
        }

        $_SESSION['success'] = "Registration successful! Check your email for activation.";
        // inserez noul user in baza de date dupa ce s-a trimis mail-ul de confirmare cu succes ca sa nu incarc baza de date
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type, active, activation_code, activation_expiry) 
                  VALUES (:first_name, :last_name, :email, :password, 'reader', 0, :activation_code, :activation_expiry)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':password' => $password,
            ':activation_code' => $activation_code,
            ':activation_expiry' => $activation_expiry,
        ]);
        header("Location: /signUp");
        exit;
    } catch (Exception $e) {
        error_log("Signup error: " . $e->getMessage());
        $_SESSION['error'] = "Error registering user.".$e->getMessage();
        header("Location: /signUp");
        exit;
    }
}

loadView("signUp");
?>
