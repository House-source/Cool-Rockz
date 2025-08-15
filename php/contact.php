<?php

// php/contact.php
// Handles front-end and back-end communication for logging user messages.

session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to send a message.';
    exit;
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo 'Invalid CSRF token.';
    exit;
}

// Get message content
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (!$message) {
    echo 'Please enter a message.';
    exit;
}

// Insert message into database, associating with logged-in user
try {
    $stmt = $pdo->prepare("INSERT INTO contact_messages (user_id, message, date_sent) VALUES (?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $message]);
    echo 'Your message has been sent.';
} catch (Exception $e) {
    echo 'Error saving your message. Please try again later.';
}
?>