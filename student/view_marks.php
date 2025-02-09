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
    <title>View Marks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" bg-gray-950  text-whitebg-gray-950 p-6">
    <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 mb-6">
        Go Back
    </button>

    <h1 class="text-3xl font-bold text-white mb-6">Your Marks</h1>

    <div class="bg-gray-900 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Marks</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class=" bg-gray-950  text-whitedivide-y divide-gray-200">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-700"><?php echo $row['subject']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-700"><?php echo $row['marks']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-700"><?php echo $row['entry_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="../backend/logout.php" class="text-red-600 hover:text-red-800 transition duration-300">Logout</a>
    </div>
</body>
</html>