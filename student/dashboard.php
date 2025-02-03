<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../backend/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300">
                Go Back
            </button>
            <a href="../backend/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">
                Logout
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome, Student!</h1>
            
            <div class="space-y-4">
                <a href='view_marks.php' class="block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300 text-center">
                    View Your Marks
                </a>
                
            </div>
        </div>
    </main>
</body>
</html>