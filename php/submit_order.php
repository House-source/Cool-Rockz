<?php

// php/submit_order.php
// Handles database logic regarding creating (and submitting) orders, updating product quantities, and clearing the current cart

header('Content-Type: application/json');
session_start(); 
require '../includes/db.php';

// Validate Session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
$user_id = intval($_SESSION['user_id']);

// Step 1: Fetch items from cart
$sql = "SELECT ci.product_id, ci.quantity, p.price
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

if (empty($cart_items)) {
    http_response_code(400);
    echo json_encode(['error' => 'Cart is empty']);
    exit;
}

// Step 2: Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Step 3: Create order
$order_stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
$order_stmt->execute([$user_id, $total]);
$order_id = $pdo->lastInsertId();

// Step 4: Insert order items
$item_stmt = $pdo->prepare(
    "INSERT INTO order_items (order_id, product_id, quantity, unit_price)
     VALUES (?, ?, ?, ?)"
);

foreach ($cart_items as $item) {
    $item_stmt->execute([
        $order_id,
        $item['product_id'],
        $item['quantity'],
        $item['price']
    ]);
}

// Step 4b: Update stock quantities in products table
$update_stock_stmt = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
foreach ($cart_items as $item) {
    $update_stock_stmt->execute([
        $item['quantity'],
        $item['product_id']
    ]);
}

// Step 5: Clear cart
$clear_stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
$clear_stmt->execute([$user_id]);

// Step 6: Respond success
echo json_encode([
    'success' => true,
    'message' => 'Order placed successfully!',
    'order_id' => $order_id
]);
?>