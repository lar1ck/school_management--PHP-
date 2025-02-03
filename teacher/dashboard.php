<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: #2c3e50;
            padding: 20px;
            color: white;
            border-radius: 8px;
        }

        .nav-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .nav-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            color: #2c3e50;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-card:hover {
            transform: translateY(-5px);
            background-color: #3498db;
            color: white;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include_once('../backend/config.php');

    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'teacher') {
        header('Location: ../backend/login.php');
        exit();
    }
    ?>

    <div class="container">
        <div class="header">
            <h1>Welcome, Teacher!</h1>
            <a href="../backend/logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="nav-cards">
            <a href="marks_entry.php" class="nav-card">
                <h2>Enter Marks</h2>
                <p>Submit and manage student grades</p>
            </a>
            
            <a href="view_students.php" class="nav-card">
                <h2>View Students</h2>
                <p>Access student profiles and records</p>
            </a>
        </div>
    </div>
</body>
</html>