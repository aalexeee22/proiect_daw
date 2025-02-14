<?php
$host = "mysql.hostinger.com";
$dbname = "";
$username = "";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("onnection failed: " . $conn->connect_error);
}

echo("Connected successfully!\n");

$query = "DELETE FROM users WHERE activation_expiry < NOW() AND active = 0";
if ($conn->query($query) === TRUE) {
    echo "Expired users deleted successfully.\n";
} else {
    echo "Error deleting users: " . $conn->error . "\n";
}

$conn->close();
?>
