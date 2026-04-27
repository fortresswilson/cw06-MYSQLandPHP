<?php
// db.php — Include this file at the top of every CRUD script
$host = "localhost";
$user = "your_username";   // Your GSU username
$pass = "your_password";   // Your MySQL password
$db = "fezeuchenne1";          // DB name for this class

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}
// $conn is now available in any file that requires this
