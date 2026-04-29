<?php
require '../includes/config.php';
require '../includes/auth.php';

include '../includes/header.php';

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<div class="full-dashboard">

    <h1>👤 Profile</h1>

    <div class="profile-wrapper">


        <div class="profile-card main">

            <div class="profile-avatar">
                <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
            </div>

            <h3><?= htmlspecialchars($user['fullname']) ?></h3>

            </p>

        </div>


        <div class="profile-grid">


            <div class="mini-card">
                <p>📧 Email</p>
                <span><?= htmlspecialchars($user['email'] ?? '-') ?></span>
            </div>


            <div class="mini-card">
                <p>👤 Role</p>
                <span><?= ucfirst($user['role']) ?></span>
            </div>


            <div class="mini-card">
                <p>🆔 User ID</p>
                <span>#<?= $user['id'] ?></span>
            </div>


            <div class="mini-card">
                <p>📊 Status</p>
                <span>
                    <?php
                    $stmt = $pdo->prepare("
                        SELECT COUNT(*) FROM exercises WHERE user_id = ?
                    ");
                    $stmt->execute([$user_id]);
                    $count = $stmt->fetchColumn();

                    echo ($count > 0) ? "Active User" : "New User";
                    ?>
                </span>
            </div>


            <div class="mini-card">
                <p>📅 Weekly Activity</p>
                <span>
                    <?php
                    $stmt = $pdo->prepare("
                        SELECT COUNT(*) 
                        FROM exercises 
                        WHERE user_id = ?
                        AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                    ");
                    $stmt->execute([$user_id]);
                    $week = $stmt->fetchColumn();

                    if ($week == 0) {
                        echo "No activity this week";
                    } elseif ($week < 3) {
                        echo "Low activity";
                    } elseif ($week < 6) {
                        echo "Good progress";
                    } else {
                        echo "Excellent consistency";
                    }
                    ?>
                </span>
            </div>


            <div class="mini-card">
                <p>🔥 Streak</p>
                <span>
                    <?php
                    $stmt = $pdo->prepare("
                        SELECT DATE(created_at) as workout_date
                        FROM exercises
                        WHERE user_id = ?
                        ORDER BY created_at DESC
                    ");
                    $stmt->execute([$user_id]);
                    $dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

                    $streak = 0;

                    foreach ($dates as $date) {
                        if ($date == date('Y-m-d', strtotime("-$streak days"))) {
                            $streak++;
                        } else {
                            break;
                        }
                    }

                    echo $streak > 0 ? $streak . " day streak" : "Start your streak";
                    ?>
                </span>
            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>