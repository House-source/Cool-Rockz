<?php

// profile.php
// Allows users to update profile information.

include 'includes/header.php';
require 'includes/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$success_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = "Invalid CSRF token.";
    } else {
        // Sanitize inputs
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        // Basic validation
        if (empty($name)) {
            $errors[] = "Name cannot be empty.";
        }

        if (empty($email)) {
            $errors[] = "Email cannot be empty.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Check if email already taken by another user
        if (empty($errors)) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $user_id]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "This email is already taken by another user.";
            }
        }

        // Handle password change if requested
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $change_password = !empty($current_password) || !empty($new_password) || !empty($confirm_password);

        if ($change_password) {
            // Validate password fields
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $errors[] = "To change password, fill in all password fields.";
            } elseif ($new_password !== $confirm_password) {
                $errors[] = "New passwords do not match.";
            } elseif (strlen($new_password) < 6) {
                $errors[] = "New password must be at least 6 characters long.";
            } else {
                // Verify current password
                $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user_data = $stmt->fetch();
                if (!$user_data || !password_verify($current_password, $user_data['password_hash'])) {
                    $errors[] = "Current password is incorrect.";
                }
            }
        }

        if (empty($errors)) {
            // Update name and email
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $user_id]);

            // Update password if requested
            if ($change_password) {
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->execute([$new_password_hash, $user_id]);
            }

            $success_msg = "Your profile has been updated.";
        }
    }
}

// Fetch latest user info for display
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profile - CoolRockz</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<main class="account-container">
  <h2>Edit Profile</h2>

  <?php if ($success_msg): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success_msg); ?></p>
  <?php endif; ?>

  <?php if ($errors): ?>
    <ul style="color: red;">
      <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />

    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required />

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />

    <hr />
    <h3>Change Password</h3>

    <label for="current_password">Current Password</label>
    <input type="password" id="current_password" name="current_password" placeholder="Leave blank if not changing" />

    <label for="new_password">New Password</label>
    <input type="password" id="new_password" name="new_password" placeholder="At least 6 characters" />

    <label for="confirm_password">Confirm New Password</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat new password" />

    <button type="submit">Update Profile</button>
  </form>
</main>

<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>
</body>
</html>
