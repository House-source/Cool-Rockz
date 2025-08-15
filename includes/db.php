<?php

// includes/db.php
// Establishes connect to database from the website, allowing communication between website and database (to retrieve and modify information)

$host = 'localhost';
$db   = 'shopping_site';
$user = 'Dave Database';
$pass = 'Dave@database1';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Log the error (in a real-world scenario, to a file, not screen)
    error_log("Database connection error: " . $e->getMessage());

    // Redirect to a nice error page (adjust path as needed)
    header("Location: ../php/db_error.php");
    exit;
}