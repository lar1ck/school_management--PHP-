
<?php
// admin/dashboard.php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  // Redirect to login if not admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            margin: 0;
            min-height: 100vh;
            padding: 2rem;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-weight: 300;
            color: #2c3e50;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            text-align: center;
        }

        h1 span {
            color: #7f8c8d;
            font-weight: 400;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem 0;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            max-width: 800px;
        }

        li {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        li:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-size: 1.1rem;
            display: block;
            white-space: nowrap;
        }

        a[href="../backend/logout.php"] {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            color: #95a5a6;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            body {
                padding: 1.5rem;
            }
            
            ul {
                flex-direction: column;
                width: 100%;
            }
            
            li {
                width: 100%;
                text-align: center;
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <h1>Welcome, <span>Admin!</span></h1>
    <ul>
        <li><a href="manage_students.php">Manage Students</a></li>
        <li><a href="manage_teachers.php">Manage Teachers</a></li>
        <li><a href="manage_modules.php">Manage Modules</a></li>
    </ul>
    <a href="../backend/logout.php">Logout</a>
</body>
</html>
