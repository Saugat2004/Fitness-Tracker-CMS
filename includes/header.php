<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fitness Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="navbar">


        <a href="/fitness-tracker/index.php" class="logo">
            Fitness Tracker
        </a>

        <div class="nav-right">


            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>

                <a href="/fitness-tracker/admin/dashboard.php" class="nav-link">
                    Dashboard
                </a>

                <a href="/fitness-tracker/admin/user_logs.php" class="nav-link">
                    User Logs
                </a>

            <?php else: ?>

                <a href="/fitness-tracker/user/dashboard.php" class="nav-link">
                    Dashboard
                </a>

                <a href="/fitness-tracker/user/addexercise.php" class="nav-link">
                    Add
                </a>

                <a href="/fitness-tracker/user/history.php" class="nav-link">
                    History
                </a>

            <?php endif; ?>


            <span class="user">
                👤 <?= $_SESSION['user_name'] ?? 'User' ?>
            </span>


            <a href="/fitness-tracker/auth/logout.php" class="logout-btn">
                Logout
            </a>

        </div>

    </div>

</body>

</html>