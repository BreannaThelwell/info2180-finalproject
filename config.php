//php for database connection and configuration

<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'edit_username');
define('DB_PASS', 'edit_password');
define('DB_NAME', 'dolphin_crm');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'Admin';
}