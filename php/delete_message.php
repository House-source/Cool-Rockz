<?php

// php/delete_message.php
// Remove message from 'contact messages' table via admin/messages.php

session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    require '../includes/db.php';

    $id = (int) $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirect back to admin page
header('Location: ../admin/messages.php');
exit();
?>