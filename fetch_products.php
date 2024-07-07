<?php
require 'db_connect.php';

// Get filter values from URL parameters
$price_min = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? $_GET['price_min'] : 0;
$price_max = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? $_GET['price_max'] : 999999;
$category = isset($_GET['category']) && $_GET['category'] !== '' ? $_GET['category'] : '';
$sale_status = isset($_GET['sale_status']) && $_GET['sale_status'] !== '' ? $_GET['sale_status'] : '';

// Pagination settings
$items_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Create base SQL query
$sql = "SELECT * FROM products WHERE price BETWEEN ? AND ?";
$params = [$price_min, $price_max];
$types = 'dd';

// Append category filter if set
if ($category !== '') {
    $sql .= " AND category LIKE ?";
    $params[] = "%$category%";
    $types .= 's';
}

// Append sale status filter if set
if ($sale_status !== '') {
    $sql .= " AND sale_status = ?";
    $params[] = $sale_status;
    $types .= 's';
}

$sql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $items_per_page;
$types .= 'ii';

// Prepare and bind parameters to the SQL query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();

// Display products
while ($row = $result->fetch_assoc()) {
    echo "<div class='product'>";
    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
    echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
    echo "<p>Category: " . htmlspecialchars($row['category']) . "</p>";
    echo "<p>Status: " . htmlspecialchars($row['sale_status']) . "</p>";
    echo "</div>";
}

$stmt->close();
$conn->close();
?>
