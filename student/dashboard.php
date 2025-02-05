<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../backend/login.php');
    exit();
}

$sql = "SELECT * FROM ShyakCarrick_tblmarks WHERE student_id = '{$_SESSION['student_id']}'";
$result = mysqli_query($happy_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Arial', sans-serif; }
        .nav-item { transition: all 0.3s ease-in-out; }
        .nav-item:hover { background-color: #4A90E2; color: white; }
        .active { background-color: #4A90E2; color: white; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center">
    <nav class="bg-white shadow-md w-full p-4 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Student Portal</h1>
        <div>
            <a href="?page=dashboard" class="nav-item px-4 py-2 rounded-md">Dashboard</a>
            <a href="?page=view_marks" class="nav-item px-4 py-2 rounded-md">View Marks</a>
            <a href="../backend/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <main class="w-full max-w-4xl p-6">
        <?php if (!isset($_GET['page']) || $_GET['page'] == 'dashboard') { ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-gray-700 mb-4">Welcome, Student!</h2>
                <p class="text-gray-600">Access your marks and academic details here.</p>
            </div>
        <?php } elseif ($_GET['page'] == 'view_marks') { ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-gray-700 mb-4">Your Marks</h2>
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Subject</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Marks</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo $row['subject']; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo $row['marks']; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo $row['entry_date']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </main>
</body>
</html>