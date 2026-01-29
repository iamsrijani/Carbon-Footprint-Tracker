<?php
// src/ActivityManager.php

require_once __DIR__ . '/CarbonCalculator.php';

class ActivityManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addActivity($userId, $type, $value, $date) {
        // Validation could be added here
        
        $emission = CarbonCalculator::calculate($type, $value);

        $stmt = $this->pdo->prepare("INSERT INTO carbon_activities (user_id, activity_type, activity_value, carbon_emission, entry_date) VALUES (?, ?, ?, ?, ?)");
        
        try {
            if ($stmt->execute([$userId, $type, $value, $emission, $date])) {
                return ['status' => true, 'message' => 'Activity logged successfully.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Failed to log activity: ' . $e->getMessage()];
        }
        return ['status' => false, 'message' => 'Unknown error.'];
    }

    public function getUserActivities($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM carbon_activities WHERE user_id = ? ORDER BY entry_date DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function deleteActivity($activityId, $userId) {
        // Ensure user owns the activity before deleting
        $stmt = $this->pdo->prepare("DELETE FROM carbon_activities WHERE activity_id = ? AND user_id = ?");
        if ($stmt->execute([$activityId, $userId])) {
             if ($stmt->rowCount() > 0) {
                 return ['status' => true, 'message' => 'Activity deleted.'];
             } else {
                 return ['status' => false, 'message' => 'Activity not found or permission denied.'];
             }
        }
        return ['status' => false, 'message' => 'Deletion failed.'];
    }

    public function getSummary($userId) {
        $stmt = $this->pdo->prepare("SELECT SUM(carbon_emission) as total_emission, COUNT(*) as activity_count FROM carbon_activities WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    
    public function getRecentActivities($userId, $limit = 5) {
        $stmt = $this->pdo->prepare("SELECT * FROM carbon_activities WHERE user_id = ? ORDER BY entry_date DESC LIMIT ?");
        // Bind limit as int since PDO sometimes quotes it as string causing syntax errors in LIMIT
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEmissionsByDate($userId) {
        $stmt = $this->pdo->prepare("SELECT entry_date, SUM(carbon_emission) as total_emission FROM carbon_activities WHERE user_id = ? GROUP BY entry_date ORDER BY entry_date ASC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getEmissionsByCategory($userId) {
        $stmt = $this->pdo->prepare("SELECT activity_type, SUM(carbon_emission) as total_emission FROM carbon_activities WHERE user_id = ? GROUP BY activity_type");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
?>
