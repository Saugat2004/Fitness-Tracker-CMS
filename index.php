<?php
require 'config.php';


if (isset($_SESSION['user_id'])) {


    if ($_SESSION['user_role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit;
}


header("Location: login.php");
exit;
?>