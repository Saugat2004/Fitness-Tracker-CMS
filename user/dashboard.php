<?php
require '../includes/config.php';
require '../includes/auth.php';

include '../includes/header.php';

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("SELECT COUNT(*) FROM exercises WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_workouts = $stmt->fetchColumn();


$stmt = $pdo->prepare("SELECT SUM(calories) FROM exercises WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_calories = $stmt->fetchColumn() ?? 0;


$stmt = $pdo->prepare("SELECT * FROM exercises WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent = $stmt->fetchAll();
?>

<div class="full-dashboard">

    <p class="subtitle">
        Monitor your fitness progress and keep your consistency strong.
    </p>


    <div class="quick-actions">
        <a href="addexercise.php" class="action-btn">+ Add Exercise</a>
        <a href="history.php" class="action-btn secondary">View History</a>
    </div>


    <div class="stats">

        <div class="card">
            <h3><?= $total_workouts ?></h3>
            <p>Total Workouts</p>
        </div>

        <div class="card">
            <h3><?= $total_calories ?></h3>
            <p>Total Calories</p>
        </div>

        <div class="card">
            <h3><?= count($recent) ?></h3>
            <p>Recent Entries</p>
        </div>

    </div>


    <div class="section-title">Recent Activity</div>

    <?php if ($recent): ?>

        <table class="table">

            <tr>
                <th>Exercise</th>
                <th>Duration</th>
                <th>Sets</th>
                <th>Calories</th>
            </tr>

            <?php foreach ($recent as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['exercise_name']) ?></td>
                    <td><?= $row['duration'] ?> min</td>
                    <td><?= $row['sets'] ?></td>
                    <td><?= $row['calories'] ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>