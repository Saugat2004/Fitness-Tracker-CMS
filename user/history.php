<?php
require '../includes/config.php';
require '../includes/auth.php';

include '../includes/header.php';

$user_id = $_SESSION['user_id'];

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM exercises WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    header("Location: history.php");
    exit();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['exercise_name'];
    $duration = $_POST['duration'];
    $sets = $_POST['sets'];
    $calories = $_POST['calories'];

    $stmt = $pdo->prepare("
        UPDATE exercises 
        SET exercise_name=?, duration=?, sets=?, calories=? 
        WHERE id=? AND user_id=?
    ");

    $stmt->execute([$name, $duration, $sets, $calories, $id, $user_id]);

    header("Location: history.php");
    exit();
}


$stmt = $pdo->prepare("
    SELECT * FROM exercises 
    WHERE user_id=? 
    ORDER BY created_at DESC
");

$stmt->execute([$user_id]);
$history = $stmt->fetchAll();


$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM exercises WHERE id=? AND user_id=?");
    $stmt->execute([$id, $user_id]);

    $editData = $stmt->fetch();
}
?>



<div class="full-dashboard">

    <h3 class="section-title">Workout History</h3>

    <p class="subtitle">
        View, update, or manage all your recorded workouts.
    </p>

    <!-- EDIT FORM -->
    <?php if ($editData): ?>
        <div class="form-box" style="margin-bottom:20px;">

            <h2>Edit Exercise ✏️</h2>

            <form method="POST">

                <input type="hidden" name="id" value="<?= $editData['id'] ?>">

                <div class="input-group">
                    <input type="text" name="exercise_name" value="<?= $editData['exercise_name'] ?>" required>
                    <label>Exercise Name</label>
                </div>

                <div class="input-group">
                    <input type="number" name="duration" value="<?= $editData['duration'] ?>" required>
                    <label>Duration</label>
                </div>

                <div class="input-group">
                    <input type="number" name="sets" value="<?= $editData['sets'] ?>" required>
                    <label>Sets</label>
                </div>

                <div class="input-group">
                    <input type="number" name="calories" value="<?= $editData['calories'] ?>" required>
                    <label>Calories</label>
                </div>

                <button class="btn" name="update">Update</button>

            </form>

        </div>
    <?php endif; ?>


    <?php if ($history): ?>

        <table class="table">

            <tr>
                <th>Exercise</th>
                <th>Duration</th>
                <th>Sets</th>
                <th>Calories</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php foreach ($history as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['exercise_name']) ?></td>
                    <td><?= $row['duration'] ?> min</td>
                    <td><?= $row['sets'] ?></td>
                    <td><?= $row['calories'] ?></td>
                    <td><?= $row['created_at'] ?? 'N/A' ?></td>
                    <td>
                        <a href="history.php?edit=<?= $row['id'] ?>">Edit</a> |
                        <a href="history.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this exercise?')"
                            style="color:red;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php else: ?>
        <div class="empty-box">

        <p class="empty-text">No workout history found. Start adding exercises.</p>

         <a href="addexercise.php" class="add-link-btn">
            + Add Exercise
        </a>

    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>