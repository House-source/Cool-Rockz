<?php

// admin/add_edit_product.php
// Add or Edit values in 'products' table to update inventory from front-end and reflect in database

include '../includes/header.php';
require '../includes/db.php';

$editing = isset($_GET['id']);
$product = [
  'name' => '',
  'category_id' => '',
  'description' => '',
  'price' => '',
  'image_path' => '',
  'stock_quantity' => ''
];

if ($editing) {
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$_GET['id']]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= $editing ? 'Edit' : 'Add' ?> Product</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<main class="form-container">
  <h2><?= $editing ? 'Edit' : 'Add New' ?> Product</h2>
  <form action="<?= $editing ? '../php/update_product.php' : '../php/create_product.php' ?>" method="POST">
    <?php if ($editing): ?>
      <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
    <?php endif; ?>

    <label for="name">Product Name</label>
    <input type="text" name="name" required value="<?= htmlspecialchars($product['name']) ?>">

    <label for="category_id">Category ID</label>
    <input type="number" name="category_id" required value="<?= htmlspecialchars($product['category_id']) ?>">

    <label for="description">Description</label>
    <textarea name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>

    <label for="price">Price</label>
    <input type="number" name="price" step="0.01" required value="<?= htmlspecialchars($product['price']) ?>">

    <label for="image_path">Image Path</label>
    <input type="text" name="image_path" value="<?= htmlspecialchars($product['image_path']) ?>">

    <label for="stock_quantity">Stock Quantity</label>
    <input type="number" name="stock_quantity" required value="<?= htmlspecialchars($product['stock_quantity']) ?>">

    <button type="submit"><?= $editing ? 'Update' : 'Add' ?> Product</button>
  </form>
</main>
</body>
</html>
