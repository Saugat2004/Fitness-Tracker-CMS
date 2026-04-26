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
│
└── admin/
    ├── dashboard.php        ← Admin overview
    ├── users.php            ← View all users
    └── user_logs.php        ← View user activities