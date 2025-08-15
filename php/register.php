<?php
session_start();
require '../includes/db.php'; // database connection script

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token");
    }

    // Collect and sanitize input
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        die("Please fill all fields.");
    }
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Email already registered.");
    }

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert with role 'user'
    $insert = $pdo->prepare("INSERT INTO users (name, email, password_hash, user_role) VALUES (?, ?, ?, 'user')");
    $insert->execute([$name, $email, $passwordHash]);

    // Redirect to login page after successful registration
    header('Location: login.php');
    exit();
}
?>