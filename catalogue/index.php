<?php

// catalogue/index.php
// Main catalogue page, shows all categories and available products, also allows users to search for products.

include '../includes/header.php';
require '../includes/db.php';

// Define static categories
$categories = [
    ['id' => 1, 'name' => 'Cool Rockz'],
    ['id' => 2, 'name' => 'Cool Standz'],
    // Add more categories as needed
];

// Fetch products that are in stock
$stmt = $pdo->query("SELECT p.id, p.name, p.stock_quantity, c.name AS category_name, c.id AS category_id FROM products p JOIN categories c ON p.category_id = c.id WHERE p.stock_quantity > 0");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize categories data structure
$categoriesData = [];
foreach ($categories as $cat) {
    $categoriesData[$cat['id']] = [
        'name' => $cat['name'],
        'products' => []
    ];
}

// Assign products to categories
foreach ($products as $product) {
    $catId = $product['category_id'];
    if (isset($categoriesData[$catId])) {
        $categoriesData[$catId]['products'][] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catalogue - CoolRockz</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

<main class="catalogue-container">
<h2>Catalogue</h2>
<!-- Search Input -->
<input type="text" id="search-box" placeholder="Search products..." />

<?php
// Loop through static categories and display products
foreach ($categories as $category):
    $catId = $category['id'];
    $categoryName = $category['name'];
    $productsInCat = $categoriesData[$catId]['products'];
?>
<div class="category-section">
  <h3><?php echo htmlspecialchars($categoryName); ?></h3>
  <div class="product-grid">
    <?php if (empty($productsInCat)): ?>
      <p>Sorry, we currently have no <?php echo htmlspecialchars($categoryName); ?> products.</p>
    <?php else: ?>
        <?php foreach ($productsInCat as $product): ?>
			<a href="product.php?id=<?php echo $product['id']; ?>" 
				class="product-card" 
				data-name="<?php echo htmlspecialchars($product['name']); ?>"
				data-stock="<?php echo $product['stock_quantity']; ?>">
				<?php echo htmlspecialchars($product['name']); ?>
			</a>
		<?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
</main>

<script src="../js/search.js"></script>

<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>

</body>
</html>