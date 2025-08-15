<?php

// admin/manage_users.php
// Allows admins to view, add and edit user accounts

include '../includes/header.php';
require '../includes/db.php';

// Check if logged in and admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../login.php');
    exit();
}

// Fetch all users
$stmt = $pdo->query("SELECT id, name, email, user_role, date_joined FROM users ORDER BY id");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users - CoolRockz Admin</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<main class="account-container">
  <h1>Manage Users</h1>
  <a href="add_edit_user.php" class="btn-primary">Add New User</a>

  <section class="order-history">
    <h3>User Accounts</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>User Role</th>
          <th>Member Since</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['id']) ?></td>
          <td><?= htmlspecialchars($user['name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['user_role']) ?></td>
          <td><?= date('M Y', strtotime($user['date_joined'])) ?></td>
          <td>
            <a href="add_edit_user.php?id=<?= $user['id'] ?>">Edit</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>
</body>
</html>
