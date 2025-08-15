<?php

// php/create_product.php
// Inserts new product into 'products' table via admin/add_edit_product.php

require '../includes/db.php';

$stmt = $pdo->prepare("INSERT INTO products (name, category_id, description, price, image_path, stock_quantity) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([
  $_POST['name'],
  $_POST['category_id'],
  $_POST['description'],
  $_POST['price'],
  $_POST['image_path'],
  $_POST['stock_quantity']
]);

header('Location: ../admin/manage_product.php');
exit;
