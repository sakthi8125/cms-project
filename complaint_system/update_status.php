<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include 'db.php';

// Get raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$complaintId = intval($input['id'] ?? 0);
$newStatus = $conn->real_escape_string($input['status'] ?? '');

if ($complaintId <= 0 || !in_array($newStatus, ['Open', 'Resolved'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$sql = "UPDATE complaints SET status = '$newStatus' WHERE id = $complaintId";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>