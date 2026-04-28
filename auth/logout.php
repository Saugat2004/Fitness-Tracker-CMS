<?php
session_start();
session_unset();
session_destroy();

header('Location: /fitness-tracker/auth/login.php');
exit;