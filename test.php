<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "dolphin_crm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>
