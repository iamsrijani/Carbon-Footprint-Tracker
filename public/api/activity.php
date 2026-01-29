<?php
// public/api/activity.php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/ActivityManager.php';

$auth = new Auth($pdo);
if (!$auth->isLoggedIn()) {
    header("Location: ../index.php");
    exit;
}

$userId = $auth->getUserId();
$activityManager = new ActivityManager($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $type = $_POST['activity_type'] ?? '';
        $value = floatval($_POST['activity_value'] ?? 0);
        $date = $_POST['date'] ?? date('Y-m-d');

        if (empty($type) || $value <= 0) {
            $_SESSION['error'] = "Invalid input.";
            header("Location: ../add_activity.php");
            exit;
        }

        $result = $activityManager->addActivity($userId, $type, $value, $date);
        
        if ($result['status']) {
            $_SESSION['success'] = "Activity logged!";
            header("Location: ../dashboard.php");
        } else {
            $_SESSION['error'] = $result['message'];
            header("Location: ../add_activity.php");
        }
        exit;
    } 
    elseif ($action === 'delete') {
        $activityId = $_POST['activity_id'] ?? 0;
        if ($activityId) {
             $result = $activityManager->deleteActivity($activityId, $userId);
             if ($result['status']) {
                 $_SESSION['success'] = "Activity deleted.";
             } else {
                 $_SESSION['error'] = $result['message'];
             }
        }
        // Redirect back to referring page or history
        $referrer = $_SERVER['HTTP_REFERER'] ?? '../history.php';
        header("Location: $referrer");
        exit;
    }
}
?>
