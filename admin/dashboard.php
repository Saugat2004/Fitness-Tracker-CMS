<?php
require '../includes/config.php';
require '../includes/auth.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../user/dashboard.php");
    exit;
}


$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_workouts = $pdo->query("SELECT COUNT(*) FROM exercises")->fetchColumn();

$total_calories = $pdo->query("SELECT SUM(calories) FROM exercises")->fetchColumn();
$total_calories = $total_calories ? $total_calories : 0;


$stmt = $pdo->query("
    SELECT 
        e.exercise_name,
        e.duration,
        e.calories,
        u.fullname
    FROM exercises e
    JOIN users u ON e.user_id = u.id
    ORDER BY e.created_at DESC
    LIMIT 5
");

$recent_logs = $stmt->fetchAll();

include '../includes/header.php';
?>

<div class="full-dashboard">

  
    <h1>⚙️ Dashboard</h1>
    <p class="subtitle">Overview of system users and fitness activity</p>

   
    <div class="stats">

        <div class="card">
            <h3>👤 <?= $total_users ?></h3>
            <p>Total Users</p>
        </div>

        <div class="card">
            <h3>🏋️ <?= $total_workouts ?></h3>
            <p>Total Workouts</p>
        </div>

        <div class="card">
            <h3>🔥 <?= $total_calories ?></h3>
            <p>Total Calories</p>
        </div>

    </div>

    
    <div class="quick-actions">
        <a href="user_logs.php" class="action-btn">
            📊 View All Activity Logs
        </a>
    </div>


    <h3 class="section-title">Recent Activity</h3>

    <?php if ($recent_logs): ?>

        <table class="table">

            <tr>
                <th>User</th>
                <th>Exercise</th>
                <th>Duration</th>
                <th>Calories</th>
            </tr>

            <?php foreach ($recent_logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['fullname']) ?></td>
                    <td><?= htmlspecialchars($log['exercise_name']) ?></td>
                    <td><?= $log['duration'] ?> min</td>
                    <td><?= $log['calories'] ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>

        <div class="empty-box">
            <p>No activity recorded yet.</p>
        </div>

    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>