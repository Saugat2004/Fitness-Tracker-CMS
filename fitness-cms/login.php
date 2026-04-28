<?php require '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Fitness Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="container">


        <div class="left-panel">
            <h1>Train. Track. Improve.</h1>
            <p>Log your workouts, monitor progress, and build consistency every day.</p>
        </div>


        <div class="right-panel">
            <div class="form-box">
                <h2>Welcome Back 👋 </h2>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $email = $_POST['email'] ?? '';
                    $password = $_POST['password'] ?? '';

                    if (empty($email) || empty($password)) {
                        echo '<p class="error">Please fill all fields</p>';
                    } else {
                        try {
                            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                            $stmt->execute([$email]);
                            $user = $stmt->fetch();

                            if ($user && password_verify($password, $user['password'])) {
                                $_SESSION['user_id'] = $user['id'];
                                $_SESSION['user_name'] = $user['fullname'];
                                $_SESSION['user_role'] = $user['role'] ?? 'user';
                                header('Location: index.php');
                                exit;
                            } else {
                                echo '<p class="error">Invalid email or password</p>';
                            }
                        } catch (PDOException $e) {
                            echo '<p class="error">Database error</p>';
                        }
                    }
                }
                ?>

                <form method="POST">
                    <div class="input-group">
                        <input type="email" name="email" placeholder=" " required>
                        <label>Email</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="" required>
                        <label>Password</label>
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>

                <p class="auth-link">
                    Don't have an account? <a href="register.php">Register</a>
                </p>
            </div>
        </div>

    </div>

</body>

</html>