<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../backend/login.php');
    exit();
}

$sql = "SELECT * FROM happy__tblmarks WHERE student_id = '{$_SESSION['student_id']}'";
$result = mysqli_query($happy_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-950 text-white min-h-screen flex flex-col items-center">
    <nav class="bg-gray-900 shadow-md w-full p-4 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-white">Student Portal</h1>
        <div class="flex space-x-4">
            <a href="?page=dashboard" class="px-4 py-2 rounded-md transition duration-300 ease-in-out hover:bg-blue-500 hover:text-white">Dashboard</a>
            <a href="?page=view_marks" class="px-4 py-2 rounded-md transition duration-300 ease-in-out hover:bg-blue-500 hover:text-white">View Marks</a>
            <a href="../backend/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <main class="w-full max-w-4xl p-6">
        <?php if (!isset($_GET['page']) || $_GET['page'] == 'dashboard') { ?>
            <div class="bg-gray-900 p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-white mb-4">Welcome, Student!</h2>
                <p class="text-gray-400">Access your marks and academic details here.</p>
            </div>
        <?php } elseif ($_GET['page'] == 'view_marks') { ?>
            <div class="bg-gray-900 p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold text-white mb-4">Your Marks</h2>
                <div class="overflow-hidden rounded-lg border border-gray-700">
                    <table class="min-w-full bg-gray-900">
                        <thead class="bg-gray-950 border-b border-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-400">Subject</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-400">Marks</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-400">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="border-b border-gray-700 hover:bg-gray-800">
                                    <td class="px-6 py-4 text-sm text-gray-300"><?php echo $row['subject']; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-300"><?php echo $row['marks']; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-300"><?php echo $row['entry_date']; ?></td>
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