<?php
session_start();
require '../includes/db.php'; // database connection

// Generate CSRF token if needed (for added security)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token if you implement CSRF protection
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
         die("Invalid CSRF token");
    }

    // Get and sanitize inputs
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die("Please enter both email and password.");
    }

    // Fetch user from database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Valid credentials
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['user_role']; // optional, for role-based access

        // Redirect to account page
        header('Location: ../account.php');
        exit();
    } else {
        // Invalid login
        die("Invalid email or password.");
    }
} else {
    // If GET or other, redirect to login page or show an error
    header('Location: ../login.php');
    exit();
}
?>