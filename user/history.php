<?php
require '../includes/config.php';
require '../includes/auth.php';

include '../includes/header.php';

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    SELECT * FROM exercises 
    WHERE user_id=? 
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$history = $stmt->fetchAll();
?>

<div class="full-dashboard">

    <h3 class="section-title">Workout History</h3>

    <p class="subtitle">
        View all your recorded workouts and track your progress.
    </p>

    <?php if ($history): ?>

        <table class="table">

            <tr>
                <th>Exercise</th>
                <th>Duration</th>
                <th>Sets</th>
                <th>Calories</th>
                <th>Date</th>
            </tr>

            <?php foreach ($history as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['exercise_name']) ?></td>
                    <td><?= $row['duration'] ?> min</td>
                    <td><?= $row['sets'] ?></td>
                    <td><?= $row['calories'] ?></td>
                    <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>

        <div class="empty-box">

            <p class="empty-text">
                No workout history found. Start adding exercises.
            </p>

            <a href="addexercise.php" class="action-btn add-btn">
                ✚ Add Exercise
            </a>

        </div>

    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>