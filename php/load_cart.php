<?php

// php/load_cart.php
// Fetches 'cart_items' table from back-end upon loading cart.php

header('Content-Type: application/json');
session_start(); 
require '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Login required']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$sql = "SELECT ci.product_id, ci.quantity, p.name, p.price, p.image_path
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return JSON
echo json_encode($cartItems);
?>
