<?php
// public/history.php
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
$activities = $activityManager->getUserActivities($userId);

$pageTitle = "History";
include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        All Activity History
    </div>
    <div class="card-body">
        <?php if (count($activities) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity Type</th>
                            <th>Amount</th>
                            <th>Emission (kg CO2e)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activities as $activity): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($activity['entry_date']); ?></td>
                                <td><?php echo ucfirst(htmlspecialchars($activity['activity_type'])); ?></td>
                                <td><?php echo htmlspecialchars($activity['activity_value']); ?></td>
                                <td><?php echo number_format($activity['carbon_emission'], 2); ?></td>
                                <td>
                                    <form action="api/activity.php" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="activity_id" value="<?php echo $activity['activity_id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No activities found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
