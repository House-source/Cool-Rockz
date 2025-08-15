<?php

// php/login.php
// Handles front-end and back-end communication for user login.

session_start();
require '../includes/db.php'; // database connection

// Generate CSRF token if needed (for added security)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['error'] = "Invalid CSRF token.";
        header('Location: ../login.php');
        exit();
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
		$_SESSION['user_email'] = $user['email'];  // for contact page
        $_SESSION['user_role'] = $user['user_role']; // 'user' or 'admin'
		$_SESSION['is_admin'] = ($user['user_role'] === 'admin'); // Set is_admin flag when logged in as admin

        // Redirect to account page
        header('Location: ../account.php');
        exit();
    } else {
        // Invalid credentials
        $_SESSION['error'] = "Invalid email or password.";
        header('Location: ../login.php');
        exit();
    }
} else {
    // If GET or other, redirect to login page or show an error
    header('Location: ../login.php');
    exit();
}
?>