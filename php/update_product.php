<?php

// php/update_product.php
// Updates properties of a specific product in 'products' table to reflect changes made via admin/add_edit_product.php

require '../includes/db.php';

$stmt = $pdo->prepare("UPDATE products SET name=?, category_id=?, description=?, price=?, image_path=?, stock_quantity=? WHERE id=?");
$stmt->execute([
  $_POST['name'],
  $_POST['category_id'],
  $_POST['description'],
  $_POST['price'],
  $_POST['image_path'],
  $_POST['stock_quantity'],
  $_POST['id']
]);

header('Location: ../admin/manage_product.php');
exit;
