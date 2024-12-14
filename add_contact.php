<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $company = htmlspecialchars($_POST['company']);
    $type = htmlspecialchars($_POST['type']);
    $assigned_to = intval($_POST['assigned_to']);
    $created_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssssssiii", $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Contact added successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add contact."]);
    }
}
?>
