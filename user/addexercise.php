<?php
require '../includes/config.php';
require '../includes/auth.php';

include '../includes/header.php';

$user_id = $_SESSION['user_id'];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['exercise_name'];
    $duration = $_POST['duration'];
    $sets = $_POST['sets'];
    $calories = $_POST['calories'];

    if ($name && $duration && $sets && $calories) {

        $stmt = $pdo->prepare("
            INSERT INTO exercises (user_id, exercise_name, duration, sets, calories)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([$user_id, $name, $duration, $sets, $calories]);

        $message = "Exercise added successfully!";
    } else {
        $message = "Please fill all fields!";
    }
}
?>



<div class="container add-page">

    <div class="form-box">

        <h2>Add Exercise 💪</h2>

        <?php if ($message): ?>
            <p class="<?= strpos($message, 'success') !== false ? 'success-msg' : 'error' ?>">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <div class="input-group">
                <input type="text" name="exercise_name" placeholder=" " required>
                <label>Exercise Name</label>
            </div>

            <div class="input-group">
                <input type="number" name="duration" placeholder=" " required>
                <label>Duration</label>
            </div>

            <div class="input-group">
                <input type="number" name="sets" placeholder=" " required>
                <label>Sets</label>
            </div>

            <div class="input-group">
                <input type="number" name="calories" placeholder=" " required>
                <label>Calories</label>
            </div>

            <button class="btn">Add Exercise</button>

        </form>

    </div>

</div>

<?php include '../includes/footer.php'; ?>