<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "your_username";
$pass = "your_password";
$db = "fezeuchenne1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connection successful";
echo " | Server: " . $conn->server_info;
$conn->close();
