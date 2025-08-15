<?php

// php/add_cart.php
// add selected product into 'cart_items' table via catalogue/product.php

session_start();
header('Content-Type: application/json');
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}
$user_id = $_SESSION['user_id'];

$product_id = (int)$_POST['product_id'];
$quantity = max(1, (int)$_POST['quantity']); // prevent 0

// Check if already in cart
$stmt = $pdo->prepare("SELECT id FROM cart_items WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);

if ($stmt->fetch()) {
    // Update quantity
    $update = $pdo->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
    $update->execute([$quantity, $user_id, $product_id]);
} else {
    // Insert new cart item
    $insert = $pdo->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert->execute([$user_id, $product_id, $quantity]);
}

echo json_encode(['success' => true]);
?>
