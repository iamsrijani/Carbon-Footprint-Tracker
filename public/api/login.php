<?php
// public/api/login.php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: ../index.php");
        exit;
    }

    $auth = new Auth($pdo);
    $result = $auth->login($email, $password);

    if ($result['status']) {
        header("Location: ../dashboard.php");
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: ../index.php");
    }
    exit;
}
?>
