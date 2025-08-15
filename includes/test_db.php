<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php'; // Adjust path if needed

try {
    $stmt = $pdo->query("SELECT DATABASE() AS dbname");
    $row = $stmt->fetch();
    echo "Connected successfully to database: " . $row['dbname'];
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>