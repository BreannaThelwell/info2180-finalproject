<?php
session_start();
header('Content-Type: application/json');
require 'db_connection.php'; // Ensure this connects to your database correctly

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'error' => 'Email and password are required.']);
        exit;
    }

    // Query to fetch the user
    $stmt = $conn->prepare('SELECT password FROM Users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email; // Store email in session for identification
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
