<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Fitness Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">


        <div class="left-panel">
            <h1>Start Your Fitness Journey</h1>
            <p>Create your account and begin tracking workouts, calories, and progress.</p>
        </div>


        <div class="right-panel">
            <div class="form-box">
                <h2>Create Account 👤</h2>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $fullname = $_POST['fullname'] ?? '';
                    $email = $_POST['email'] ?? '';
                    $phone = $_POST['phone'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $role = $_POST['role'] ?? 'user';

                    if (empty($fullname) || empty($email) || empty($password)) {
                        echo '<p class="error">Please fill all required fields</p>';
                    } else {
                        try {
                            // Check if email exists
                            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                            $stmt->execute([$email]);

                            if ($stmt->rowCount() > 0) {
                                echo '<p class="error">Email already exists</p>';
                            } else {
                                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                                $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
                                $stmt->execute([$fullname, $email, $phone, $hashedPassword, $role]);

                                echo '
                               <div class="success-msg">
                               Registration successful!
                              <a href="login.php">Login here →</a>
                             </div>';
                            }
                        } catch (PDOException $e) {
                            echo '<p class="error">Something went wrong</p>';
                        }
                    }
                }
                ?>

                <form method="POST">

                    <div class="input-group">
                        <input type="text" name="fullname" placeholder=" ">
                        <label>Full Name</label>
                    </div>

                    <div class="input-group">
                        <input type="email" name="email" placeholder=" ">
                        <label>Email</label>
                    </div>

                    <div class="input-group">
                        <input type="text" name="phone" placeholder=" ">
                        <label>Phone</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder=" ">
                        <label>Password</label>
                    </div>


                    <div class="input-group">
                        <select name="role" required class="select-box">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn">Register</button>

                </form>

                <p class="auth-link">
                    Already have an account? <a href="login.php">Login</a>
                </p>

            </div>
        </div>

    </div>

</body>

</html>