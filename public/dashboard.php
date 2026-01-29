<?php
// public/dashboard.php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/ActivityManager.php';

$auth = new Auth($pdo);
if (!$auth->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$userId = $auth->getUserId();
$activityManager = new ActivityManager($pdo);
$summary = $activityManager->getSummary($userId);
$recentActivities = $activityManager->getRecentActivities($userId, 5);

$totalEmission = $summary['total_emission'] ?? 0;
$activityCount = $summary['activity_count'] ?? 0;

$pageTitle = "Dashboard";
include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-primary dashboard-card">
            <div class="card-body">
                <h5 class="card-title">Total Emissions</h5>
                <p class="card-text display-4"><?php echo number_format($totalEmission, 2); ?> <span class="fs-5">kg CO2e</span></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-success dashboard-card">
            <div class="card-body">
                <h5 class="card-title">Activities Logged</h5>
                <p class="card-text display-4"><?php echo $activityCount; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Activities</h5>
                <a href="add_activity.php" class="btn btn-sm btn-outline-primary">+ Log Activity</a>
            </div>
            <div class="card-body">
                <?php if (count($recentActivities) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                    <th>Value</th>
                                    <th>Emission (kg CO2e)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentActivities as $activity): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($activity['entry_date']); ?></td>
                                        <td><?php echo ucfirst(htmlspecialchars($activity['activity_type'])); ?></td>
                                        <td><?php echo htmlspecialchars($activity['activity_value']); ?></td>
                                        <td><?php echo number_format($activity['carbon_emission'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="history.php" class="btn btn-link">View Full History &rarr;</a>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4">No activities logged yet.</p>
                    <div class="text-center">
                        <a href="add_activity.php" class="btn btn-primary">Log your first activity</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
