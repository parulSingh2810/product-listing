<?php
require 'db_connect.php';

// Get filter values from URL parameters
$price_min = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? $_GET['price_min'] : 0;
$price_max = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? $_GET['price_max'] : 999999;
$category = isset($_GET['category']) && $_GET['category'] !== '' ? $_GET['category'] : '';
$sale_status = isset($_GET['sale_status']) && $_GET['sale_status'] !== '' ? $_GET['sale_status'] : '';

// Create base SQL query
$sql = "SELECT COUNT(*) AS total FROM products WHERE price BETWEEN $price_min AND $price_max";

// Append category filter if set
if ($category !== '') {
    $category = $conn->real_escape_string($category);
    $sql .= " AND category LIKE '%$category%'";
}

// Append sale status filter if set
if ($sale_status !== '') {
    $sale_status = $conn->real_escape_string($sale_status);
    $sql .= " AND sale_status LIKE '%$sale_status%'";
}

// Execute query and get total number of products
$result_total = $conn->query($sql);
if ($result_total) {
    $row_total = $result_total->fetch_assoc();
    $total_pages = ceil($row_total['total'] / 10);

    // Display pagination links
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i&price_min=$price_min&price_max=$price_max&category=$category&sale_status=$sale_status'>$i</a> ";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
