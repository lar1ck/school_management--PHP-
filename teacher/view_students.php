<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../frontend/login.html');
    exit();
}

$teacher_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students";
$students_result = mysqli_query($karine_conn, $sql);

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $marks_sql = "SELECT * FROM marks WHERE student_id = '$student_id' AND teacher_id = '$teacher_id'";
    $marks_result = mysqli_query($karine_conn, $marks_sql);
    $student_info = mysqli_fetch_assoc(mysqli_query($karine_conn, "SELECT * FROM students WHERE student_id = '$student_id'"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .button-group {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
        }

        .button {
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #357abd;
        }

        h1, h2 {
            color: #2c3e50;
            margin-bottom: 25px;
        }

        h1 {
            border-bottom: 3px solid #4a90e2;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background-color: #4a90e2;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .view-marks {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .view-marks:hover {
            color: #357abd;
            text-decoration: underline;
        }

        .marks-table {
            margin-top: 30px;
            border: 2px solid #4a90e2;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="button-group">
        <a href="../teacher/dashboard.php" class="button">Return to Dashboard</a>
            <a href="../backend/logout.php" class="button">Logout</a>
        </div>

        <h1>Student List</h1>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['class']); ?></td>
                        <td>
                            <a href="?student_id=<?php echo $student['student_id']; ?>" class="view-marks">
                                View Marks
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (isset($marks_result)) { ?>
            <div class="marks-section">
                <h2><?php echo htmlspecialchars($student_info['name']); ?>'s Academic Record</h2>
                
                <table class="marks-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Entry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($mark = mysqli_fetch_assoc($marks_result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($mark['subject']); ?></td>
                                <td><?php echo htmlspecialchars($mark['marks']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($mark['entry_date'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</body>
</html>