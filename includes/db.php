<?php
// db.php
$host = 'localhost'; // or your database host
$db   = 'shopping_site'; // your database name
$user = 'John Storeuser'; // your MySQL username
$pass = 'John@storeuser1'; // your MySQL password
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
    die("Error connecting to database: " . $e->getMessage());
}
?>