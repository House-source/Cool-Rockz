<?php

// admin/add_edit_user.php
// Allows admins to add or edit a user account.

include '../includes/header.php';
require '../includes/db.php';

// Check admin access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../login.php');
    exit();
}

$errors = [];
$success = false;

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Get user ID if editing existing user
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$name = '';
$email = '';
$user_role = 'user';

if ($user_id) {
    // Fetch existing user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        die("User not found.");
    }

    $name = $user['name'];
    $email = $user['email'];
    $user_role = $user['user_role'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token");
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $user_role = $_POST['user_role'] ?? 'user';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Basic validation
    if ($name === '') {
        $errors[] = "Name is required.";
    }
    if ($email === '') {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if ($password !== '' && $password !== $password_confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Check email uniqueness
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $user_id ?? 0]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email already in use by another user.";
    }

    if (empty($errors)) {
        if ($user_id) {
            // Update existing user
            if ($password !== '') {
                // Update password too
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE users SET name = ?, email = ?, user_role = ?, password_hash = ? WHERE id = ?");
                $update->execute([$name, $email, $user_role, $password_hash, $user_id]);
            } else {
                // Update without changing password
                $update = $pdo->prepare("UPDATE users SET name = ?, email = ?, user_role = ? WHERE id = ?");
                $update->execute([$name, $email, $user_role, $user_id]);
            }
            $success = "User updated successfully.";
        } else {
            // Create new user — password required here
            if ($password === '') {
                $errors[] = "Password is required for new users.";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("INSERT INTO users (name, email, user_role, password_hash) VALUES (?, ?, ?, ?)");
                $insert->execute([$name, $email, $user_role, $password_hash]);
                $success = "User created successfully.";
                // Optionally redirect after creation
                // header("Location: manage_users.php");
                // exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= $user_id ? "Edit User" : "Add User" ?> - CoolRockz Admin</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<main class="account-container">
  <h1><?= $user_id ? "Edit User" : "Add New User" ?></h1>
  
  <?php if ($errors): ?>
    <div class="error-messages">
      <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <p class="success-message"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required />

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required />

    <label for="user_role">User Role:</label>
    <select id="user_role" name="user_role" required>
      <option value="user" <?= $user_role === 'user' ? 'selected' : '' ?>>User</option>
      <option value="admin" <?= $user_role === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>

    <label for="password">Password: <small>(Leave blank to keep current password)</small></label>
    <input type="password" id="password" name="password" />

    <label for="password_confirm">Confirm Password:</label>
    <input type="password" id="password_confirm" name="password_confirm" />

    <button type="submit"><?= $user_id ? "Update User" : "Create User" ?></button>
  </form>

  <p><a href="manage_users.php">Back to User Management</a></p>
</main>
</body>
</html>
