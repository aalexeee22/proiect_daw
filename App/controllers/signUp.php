<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /restricted-access"); // Redirect to home or change to /dashboard if needed
    exit;
}
require_once basePath('config/db.php');
require_once basePath('PHPMailer-master/src/PHPMailer.php');
require_once basePath('PHPMailer-master/src/SMTP.php');
require_once basePath('PHPMailer-master/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require_once basePath('controllers/mail_config.php');
$usernameG='euaalexeee@gmail.com';
$passwordG='paog ttvc hxys cwns';

$db = new Database(require basePath('config/db.php'));
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = $_POST['email'];
    $password = trim($_POST['password']);


    // Generate activation code
    $activation_code = bin2hex(random_bytes(16));
    $activation_expiry = date("Y-m-d H:i:s", strtotime("+1 day")); // 24-hour expiry

    try {
        // Insert into database
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

        // Send activation email
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
        $mail->Username = $usernameG; // Set in mail_config.php
        $mail->Password = $passwordG; // Set in mail_config.php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom($usernameG, 'Library');
        $mail->addAddress($email, "$first_name $last_name");
        $mail->Subject = 'Activate Your Account';
        $mail->Body = $message;

        $mail->send();

        $_SESSION['success'] = "Registration successful! Check your email for activation.";
        header("Location: /signIn");
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
