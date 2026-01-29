<?php
// public/api/logout.php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Auth.php';

$auth = new Auth($pdo);
$auth->logout();

header("Location: ../index.php");
exit;
?>
