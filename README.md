fitness-cms/
│
├── index.php                  ← Redirect logic
├── login.php
├── register.php
├── logout.php
│
├── database.sql              ← Database schema 
│
├── includes/
│   ├── config.php            ← DB connection + session_start()
│   ├── auth.php              ← login check helper 
│   ├── header.php            ← navbar + opening HTML
│   └── footer.php            ← closing HTML
│
├── css/
│   └── style.css             ← All styling
│
├── user/
│   ├── dashboard.php         ← User stats + summary
│   ├── add_exercise.php     ← Add workout
│   └── history.php          ← Workout history
│   └──profile.php            ← user profile
└── admin/
    ├── dashboard.php        ← Admin overview
    ├── users.php            ← View all users
    └── user_logs.php        ← View user activities

## Features

🔐 User Authentication System
-Secure login, registration, and logout functionality for users.

🏋️ Workout Tracking System
-Users can add, view, and manage their daily exercise/workout records.

📊 Admin Dashboard
-Admin panel to manage users and monitor system activity efficiently.

🎨 Clean & Simple UI
-Minimal, responsive, and user-friendly interface designed for easy navigation.
    
