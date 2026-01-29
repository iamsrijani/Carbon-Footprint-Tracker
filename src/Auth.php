<?php
// src/Auth.php

class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password) {
        if ($this->userExists($email)) {
            return ['status' => false, 'message' => 'Email already registered.'];
        }

        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        try {
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                return ['status' => true, 'message' => 'Registration successful.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Registration failed.'];
        }
        return ['status' => false, 'message' => 'Unknown error.'];
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            return ['status' => true, 'message' => 'Login successful.'];
        }

        return ['status' => false, 'message' => 'Invalid email or password.'];
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    }

    public function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    public function getUserId() {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_id'] ?? null;
    }

    private function userExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}
?>
