<?php

// includes/search_products.php
// Handles search functionality in the catalogue.

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $searchTerm = '%' . strtolower(trim($_GET['q'])) . '%';

    // Prepare statement to search products by name
    $stmt = $pdo->prepare("SELECT p.id, p.name, p.stock_quantity, c.name AS category_name
                           FROM products p
                           JOIN categories c ON p.category_id = c.id
                           WHERE LOWER(p.name) LIKE ?");
    $stmt->execute([$searchTerm]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output JSON
    echo json_encode($results);
} else {
    echo json_encode([]); // empty array if no query
}
?>