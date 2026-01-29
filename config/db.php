<?php
// config/db.php

$host = '127.0.0.1';
$db   = 'carbon_tracker';
$user = 'root'; // Default for local dev, user should change if needed
$pass = '';     // Default for local dev
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In production, log this specific error and show a generic one
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
