<?php
require_once 'includes/database.php';
require_once 'includes/functions.php';
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]); exit;
}

$stmt = $pdo->prepare('SELECT name, category FROM products WHERE name LIKE ? OR category LIKE ? ORDER BY name LIMIT 8');
$like = '%' . $q . '%';
$stmt->execute([$like, $like]);
$rows = $stmt->fetchAll();
$suggestions = [];
foreach ($rows as $row) {
    $suggestions[] = $row['name'];
    $suggestions[] = $row['category'];
}
$suggestions = array_values(array_unique(array_slice($suggestions, 0, 8)));
echo json_encode($suggestions, JSON_UNESCAPED_UNICODE);
