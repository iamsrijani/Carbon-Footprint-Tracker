<?php
// public/api/register.php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../register.php");
        exit;
    }

    $auth = new Auth($pdo);
    $result = $auth->register($username, $email, $password);

    if ($result['status']) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: ../index.php"); // Redirect to login
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: ../register.php");
    }
    exit;
}
?>
