<?php
require '../includes/config.php';
require '../includes/auth.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['exercise_name']);
    $duration = (int) $_POST['duration'];
    $sets = (int) $_POST['sets'];
    $calories = (int) $_POST['calories'];

    if (empty($name) || $duration <= 0 || $sets <= 0 || $calories <= 0) {
        $message = "Please enter valid values!";
        $messageType = "error";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO exercises (user_id, exercise_name, duration, sets, calories)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$user_id, $name, $duration, $sets, $calories]);

        $message = "Exercise added successfully!";
        $messageType = "success";
    }
}
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="add-page">

    <div class="exercise-box">

        <h2><i class="fa-solid fa-plus"></i> Add Exercise</h2>

        <?php if ($message): ?>
            <div class="<?= $messageType === 'success' ? 'success-msg' : 'error' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="card-input">
                <label><i class="fa-solid fa-dumbbell"></i> Exercise Name</label>
                <input type="text" name="exercise_name" required>
            </div>

            <div class="card-input-row">
                <div class="card-input">
                    <label><i class="fa-regular fa-clock"></i> Duration</label>
                    <input type="number" name="duration" min="1" required>
                </div>

                <div class="card-input">
                    <label><i class="fa-solid fa-layer-group"></i> Sets</label>
                    <input type="number" name="sets" min="1" required>
                </div>
            </div>

            <div class="card-input">
                <label><i class="fa-solid fa-fire"></i> Calories</label>
                <input type="number" name="calories" min="1" required>
            </div>

            <button type="submit" class="btn">
                <i class="fa-solid fa-plus"></i> Add Exercise
            </button>

        </form>

    </div>

</div>

<?php include '../includes/footer.php'; ?>