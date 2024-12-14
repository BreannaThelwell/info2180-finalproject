<?php
$host = 'localhost';        // XAMPP default server
$username = 'root';         // Default XAMPP username
$password = '';             // Default XAMPP password (empty by default)
$database = 'dolphin_crm';  // Your database name

// Create the database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
