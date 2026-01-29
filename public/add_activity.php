<?php
// public/add_activity.php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/CarbonCalculator.php';

$auth = new Auth($pdo);
if (!$auth->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$pageTitle = "Log Activity";
include 'includes/header.php';

$factors = CarbonCalculator::getFactors();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Log New Activity
            </div>
            <div class="card-body">
                <form action="api/activity.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="activity_type" class="form-label">Activity Type</label>
                        <select class="form-select" id="activity_type" name="activity_type" required>
                            <option value="">Select activity...</option>
                            <option value="transport_car">Transport - Car (Petrom)</option>
                            <option value="transport_bus">Transport - Bus</option>
                            <option value="transport_bike">Transport - Bicycle</option>
                            <option value="electricity">Electricity Usage</option>
                            <option value="food_meat">Food - Meat Meal</option>
                            <option value="food_veg">Food - Vegetarian Meal</option>
                            <option value="waste">General Waste</option>
                        </select>
                         <div id="unitHelp" class="form-text">
                            Units: Transport (km), Electricity (kWh), Food/Waste (kg)
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="activity_value" class="form-label">Value (Amount)</label>
                        <input type="number" step="0.01" class="form-control" id="activity_value" name="activity_value" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Log Activity</button>
                        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
