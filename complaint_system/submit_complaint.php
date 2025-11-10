<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$category = trim($_POST['category'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$description = trim($_POST['description'] ?? '');

if (empty($name) || empty($email) || empty($phone) || empty($category) || empty($subject) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$phone = $conn->real_escape_string($phone);
$category = $conn->real_escape_string($category);
$subject = $conn->real_escape_string($subject);
$description = $conn->real_escape_string($description);

$sql = "INSERT INTO complaints (name, email, phone, category, subject, description) 
        VALUES ('$name', '$email', '$phone', '$category', '$subject', '$description')";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Complaint submitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>