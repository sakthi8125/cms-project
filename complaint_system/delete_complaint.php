<?php
include 'db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$complaintId = intval($input['id'] ?? 0);

if ($complaintId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid complaint ID']);
    exit;
}

$sql = "DELETE FROM complaints WHERE id = $complaintId";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Complaint deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>