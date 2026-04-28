<?php
require 'config.php';
require 'auth.php';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <div class="left-panel">
        <h1>Welcome 👋</h1>
        <p><?= htmlspecialchars($user_name) ?></p>
        <p>Track your progress and stay consistent every day.</p>
    </div>

    <div class="right-panel">

        <div class="form-box dashboard-box">

            <h2>Dashboard 📊</h2>

            <div class="stats">

                <div class="card">
                    <h3><?= $total_workouts ?></h3>
                    <p>Workouts</p>
                </div>

                <div class="card">
                    <h3><?= $total_calories ?></h3>
                    <p>Calories</p>
                </div>

            </div>

            <h3 class="section-title">Recent Activity</h3>

            <?php if ($recent): ?>
                <table class="table">
                    <tr>
                        <th>Exercise</th>
                        <th>Duration</th>
                        <th>Calories</th>
                    </tr>

                    <?php foreach ($recent as $row): ?>
                        <tr>
                            <td><?= $row['exercise_name'] ?></td>
                            <td><?= $row['duration'] ?> min</td>
                            <td><?= $row['calories'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="empty-text">No workouts yet.</p>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>