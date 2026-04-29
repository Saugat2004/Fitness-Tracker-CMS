<?php
require '../includes/config.php';
require '../includes/auth.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../user/dashboard.php");
    exit;
}

include '../includes/header.php';


if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM exercises WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: user_logs.php");
    exit;
}


$stmt = $pdo->query("
    SELECT 
        e.id,
        e.exercise_name,
        e.duration,
        e.calories,
        e.created_at,
        u.fullname,
        u.email
    FROM exercises e
    JOIN users u ON e.user_id = u.id
    ORDER BY e.created_at DESC
");

$logs = $stmt->fetchAll();
?>

<div class="full-dashboard">

    <h1>📊 User Activity Logs</h1>
    <p class="subtitle">View and manage all workout records</p>

    <?php if ($logs): ?>

        <table class="table">

            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Exercise</th>
                <th>Duration</th>
                <th>Calories</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php foreach ($logs as $log): ?>
                <tr>

                    <td><?= htmlspecialchars($log['fullname']) ?></td>
                    <td><?= htmlspecialchars($log['email']) ?></td>
                    <td><?= htmlspecialchars($log['exercise_name']) ?></td>
                    <td><?= $log['duration'] ?> min</td>
                    <td><?= $log['calories'] ?></td>
                    <td><?= date('Y-m-d', strtotime($log['created_at'])) ?></td>

                    <td style="text-align:center;">

                        <a href="user_logs.php?delete=<?= $log['id'] ?>"
                           class="action-btn"
                           onclick="return confirm('Are you sure you want to delete this record?')">
                            Delete
                        </a>

                    </td>

                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>

        <div class="empty-box">
            <p>No logs available.</p>
        </div>

    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>