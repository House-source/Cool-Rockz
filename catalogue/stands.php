<?php

// catalogue/stands.php
// Category page for Cool Standz, give info and current inventory

include '../includes/header.php';
require '../includes/db.php';

// Fetch category ID for "Cool Standz"
$stmt = $pdo->prepare("SELECT id FROM categories WHERE name = :name");
$stmt->execute([':name' => 'Cool Standz']);
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
  <title>Standz Catalogue - CoolRockz</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

	<main class="catalogue-container">
	 <h2>Cool Standz!</h2>
	<p>You've got some Cool Rockz? Great! Now you need somewhere to place 'em and show 'em off!<br>
	   This is our up-to-date selection of Cool Standz available for purchase.<br><br></p>
	  
	  <!-- Stand Products -->
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
			<p>Unfortunately, right now we currently have no Cool Standz available :(</p>
		  <?php endif; ?>
		</div>
	  </div>
	</main>

<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>
</body>
</html>