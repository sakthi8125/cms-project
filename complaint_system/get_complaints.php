<?php
include 'db.php';

header('Content-Type: application/json');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

$page = max(1, $page);
$limit = max(1, $limit);
$offset = ($page - 1) * $limit;

$where = "1=1";
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR subject LIKE '%$search%' OR category LIKE '%$search%')";
}
if (!empty($status)) {
    $status = $conn->real_escape_string($status);
    $where .= " AND status = '$status'";
}

$order = $sort === 'oldest' ? "created_at ASC" : "created_at DESC";

$count_sql = "SELECT COUNT(*) as total FROM complaints WHERE $where";
$count_result = $conn->query($count_sql);
$total_count = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_count / $limit);

$sql = "SELECT * FROM complaints WHERE $where ORDER BY $order LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$complaints = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'complaints' => $complaints,
    'totalPages' => $total_pages,
    'totalCount' => $total_count
]);

$conn->close();
?>