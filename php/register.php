<?php

// php/register.php
// Handles front-end and back-end communication for user registration.

session_start();
require '../includes/db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['register_error'] = "Invalid CSRF token.";
        header("Location: ../register.php");
        exit();
    }

    // Collect input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['register_error'] = "Please fill in all fields.";
        header("Location: ../register.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email format.";
        header("Location: ../register.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: ../register.php");
        exit();
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['register_error'] = "Email already registered.";
        header("Location: ../register.php");
        exit();
    }

    // Hash and insert
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $insert = $pdo->prepare("INSERT INTO users (name, email, password_hash, user_role) VALUES (?, ?, ?, 'user')");
    $insert->execute([$name, $email, $passwordHash]);

    // Redirect to login
    $_SESSION['register_success'] = "Registration successful! You can now log in.";
    header('Location: ../login.php');
    exit();
}
?>