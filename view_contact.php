<?php
header('Content-Type: application/json'); // Set the correct content type

// Database connection (ensure this is correctly configured)
$mysqli = new mysqli('localhost', 'username', 'password', 'database_name');

// Check connection
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['getNotes'])) {
    // Fetch notes from the database
    $contactId = $_GET['contact_id']; // Make sure this ID is passed
    $stmt = $mysqli->prepare('SELECT firstname, lastname, content, created_at FROM notes WHERE contact_id = ? ORDER BY created_at DESC');
    $stmt->bind_param('i', $contactId);
    $stmt->execute();
    $result = $stmt->get_result();

    $notes = [];
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }

    echo json_encode($notes);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action']) && $data['action'] === 'addNote' && !empty($data['content'])) {
        // Insert the new note into the database
        $contactId = 1; // Replace this with the correct contact ID from your app logic
        $content = $data['content'];
        $userId = 1; // Replace with the logged-in user ID
        $createdAt = date('Y-m-d H:i:s');

        $stmt = $mysqli->prepare('INSERT INTO notes (contact_id, user_id, content, created_at) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('iiss', $contactId, $userId, $content, $createdAt);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database insert failed']);
        }

        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
        exit;
    }
}

// Default error response
echo json_encode(['success' => false, 'error' => 'Invalid request']);
exit;
?>
