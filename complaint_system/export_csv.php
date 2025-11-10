<?php
include 'db.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=complaints_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

fputcsv($output, [
    'ID', 
    'Name', 
    'Email', 
    'Phone', 
    'Category', 
    'Subject', 
    'Description', 
    'Status', 
    'Created Date', 
    'Updated Date'
]);

$sql = "SELECT * FROM complaints ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['category'],
            $row['subject'],
            $row['description'],
            $row['status'],
            $row['created_at'],
            $row['updated_at']
        ]);
    }
}

fclose($output);
$conn->close();
exit;
?>