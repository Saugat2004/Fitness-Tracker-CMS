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


        <a href="../user/dashboard.php" class="logo">
            Fitness Tracker
        </a>


        <div class="nav-right">


            <a href="../user/dashboard.php" class="nav-link">Dashboard</a>
            <a href="../user/addexercise.php" class="nav-link">Add</a>
            <a href="../user/history.php" class="nav-link">History</a>


            <span class="user">
                👤 <?= $_SESSION['user_name'] ?? 'User' ?>
            </span>


            <a href="../logout.php" class="logout-btn">Logout</a>

        </div>

    </div>

    </div>