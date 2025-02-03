<?php
session_start();
include_once('../backend/config.php');  

if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../frontend/login.html');  
    exit();
}

if (isset($_POST['add_marks'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $teacher_id = $_SESSION['user_id'];

    $sql = "INSERT INTO marks (student_id, subject, marks, teacher_id) VALUES ('$student_id', '$subject', '$marks', '$teacher_id')";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Marks added successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

$sql = "SELECT * FROM students";
$result = mysqli_query($karine_conn, $sql);

$sql_marks = "SELECT * FROM marks WHERE teacher_id = '{$_SESSION['user_id']}'";
$result_marks = mysqli_query($karine_conn, $sql_marks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Entry</title>
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

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-back {
            background-color: #95a5a6;
            color: white;
            margin-right: 15px;
        }

        .btn-back:hover {
            background-color: #7f8c8d;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .styled-table th,
        .styled-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        .styled-table th {
            background-color: #2c3e50;
            color: white;
        }

        .styled-table tr:hover {
            background-color: #f8f9fa;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php

    $alert = '';
    if (isset($_POST['add_marks'])) {
        if (mysqli_query($karine_conn, $sql)) {
            $alert = '<div class="alert alert-success">Marks added successfully!</div>';
        } else {
            $alert = '<div class="alert alert-error">Error: ' . mysqli_error($karine_conn) . '</div>';
        }
    }
    ?>

    <div class="container">
        <div class="header">
            <div>
            <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
                <h1>Marks Entry</h1>
            </div>
            <a href="../backend/logout.php" class="logout-btn">Logout</a>
        </div>

        <?php echo $alert; ?>

        <div class="form-card">
            <form method="POST">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">Enter Student Marks</h2>
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" name="student_id" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="marks">Marks</label>
                    <input type="number" name="marks" required>
                </div>
                <button type="submit" name="add_marks" class="btn btn-primary">Save Marks</button>
            </form>
        </div>

        <h2 style="margin: 30px 0 20px; color: #2c3e50;">Marks History</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_marks)) { ?>
                <tr>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['marks']; ?></td>
                    <td><?php echo $row['entry_date']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>