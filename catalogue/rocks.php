<?php

// catalogue/rocks.php
// Category page for Cool Rockz, giving info and current inventory

include '../includes/header.php';
require '../includes/db.php';

// Fetch category ID for "Cool Rockz"
$stmt = $pdo->prepare("SELECT id FROM categories WHERE name = :name");
$stmt->execute([':name' => 'Cool Rockz']);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if ($category) {
    $categoryId = $category['id'];
    // Fetch products in that category with stock > 0
    $stmt_products = $pdo->prepare("SELECT * FROM products WHERE category_id = :category_id AND stock_quantity > 0");
    $stmt_products->execute([':category_id' => $categoryId]);
    $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
} else {
    // No such category found
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rockz Catalogue - CoolRockz</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

	<main class="catalogue-container">
	  <h2>Cool Rockz!</h2>
	  <p>Looking for some rocks to buy? You're in the right place!<br><br>
	  This is our up-to-date selection of Cool Rockz available for purchase. 
	  Our selection is always updating so be sure to come back often whether you're in the market or just want to check out some cool rocks.<br><br><br></p>
	  
	  <!-- Rock Products -->
	  <div class="category-section">
		<div class="product-grid">
		  <?php if ($products): ?>
			<?php foreach ($products as $product): ?>
				<a href="product.php?id=<?php echo $product['id']; ?>" 
					class="product-card" 
					data-name="<?php echo htmlspecialchars($product['name']); ?>">
					<?php echo htmlspecialchars($product['name']); ?>
				</a>
			<?php endforeach; ?>
		  <?php else: ?>
			<p>Unfortunately, right now we currently have no Cool Rockz available :(</p>
		  <?php endif; ?>
		</div>
	  </div>
	</main>

<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>
</body>
</html>