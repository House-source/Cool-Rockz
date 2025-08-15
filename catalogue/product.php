<?php

// catalogue/product.php
// Template for all products, dynamically displays product information based on product_id

include '../includes/header.php';
require '../includes/db.php';

// Get product ID from URL, ensure it's an integer for security
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    die('Invalid product ID.');
}

// Fetch product from database
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die('Product not found.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php echo htmlspecialchars($product['name']); ?> - CoolRockz</title>
<link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

	<main class="product-detail">
	  <h1><?php echo htmlspecialchars($product['name']); ?></h1>
	  <p>Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
	  <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
	  <p>Description: <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
	  <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
	  <p>Stock Remaining: <?php echo htmlspecialchars($product['stock_quantity']); ?></p>
	  <button id="add-btn" data-product='<?= json_encode(['id' => $product['id'], 'name' => $product['name'],'price' => $product['price']]) ?>'>Add to Cart</button>
	</main>
	
	<script src="../js/addCart.js"></script>

<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>
</body>
</html>