<?php

// admin/manage_product.php
// Allows admins to interact with inventory from the front-end

include '../includes/header.php';
require '../includes/db.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Products</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<main class="account-container">
  <h1>Manage Products</h1>
  <a href="add_edit_product.php" class="btn-primary">Add New Product</a>

  <section class="order-history">
    <h3>Inventory</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Description</th>
          <th>Price</th>
          <th>Image Path</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
          <td><?= htmlspecialchars($product['id']) ?></td>
          <td><?= htmlspecialchars($product['name']) ?></td>
          <td><?= htmlspecialchars($product['category_id']) ?></td>
          <td><?= htmlspecialchars($product['description']) ?></td>
          <td>$<?= htmlspecialchars($product['price']) ?></td>
          <td><?= htmlspecialchars($product['image_path']) ?></td>
          <td><?= htmlspecialchars($product['stock_quantity']) ?></td>
          <td>
            <a href="add_edit_product.php?id=<?= $product['id'] ?>">Edit</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
  <script src='../js/manageprod.js'></script>
</main>
</body>
</html>
