<?php
// public/analytics.php
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
$byDate = $activityManager->getEmissionsByDate($userId);
$byCategory = $activityManager->getEmissionsByCategory($userId);

// Prepare data for Chart.js
$dates = [];
$dateEmissions = [];
foreach ($byDate as $row) {
    $dates[] = $row['entry_date'];
    $dateEmissions[] = $row['total_emission'];
}

$categories = [];
$categoryEmissions = [];
foreach ($byCategory as $row) {
    $categories[] = ucfirst($row['activity_type']);
    $categoryEmissions[] = $row['total_emission'];
}

$pageTitle = "Analytics";
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Emissions Over Time
            </div>
            <div class="card-body">
                <canvas id="timeChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                Emissions by Category
            </div>
            <div class="card-body">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time Chart
    const timeCtx = document.getElementById('timeChart').getContext('2d');
    new Chart(timeCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Daily Emissions (kg CO2e)',
                data: <?php echo json_encode($dateEmissions); ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'kg CO2e'
                    }
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($categories); ?>,
            datasets: [{
                data: <?php echo json_encode($categoryEmissions); ?>,
                backgroundColor: [
                    '#198754', // transport
                    '#ffc107', // electricity
                    '#dc3545', // meat
                    '#0dcaf0', // veg
                    '#6c757d', // waste
                    '#6610f2'  // other
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
