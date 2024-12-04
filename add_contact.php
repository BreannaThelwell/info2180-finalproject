<?php
//php file for adding contacts to contacts table

// Start session to maintain login state
session_start();

// Include database connection utility
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize form inputs
    $title = htmlspecialchars(trim($_POST['title']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $company = htmlspecialchars(trim($_POST['company']));
    $type = htmlspecialchars(trim($_POST['type']));
    $assigned_to = intval($_POST['assigned_to']); // Assigned user's ID
    $created_by = $_SESSION['user_id']; // Creator's user ID

    // Insert new contact into the database
    $stmt = $conn->prepare("INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssssssiii", $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by);

    // Execute the statement and provide feedback
    if ($stmt->execute()) {
        echo "Contact added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>