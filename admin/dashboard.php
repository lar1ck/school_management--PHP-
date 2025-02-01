<?php
// admin/dashboard.php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  // Redirect to login if not admin
    exit();
}

echo "<h1>Welcome, Admin!</h1>";
echo "<ul class='space-y-4'>";
echo "<li><a href='manage_students.php' class='text-blue-500 hover:underline'>Manage Students</a></li>";
echo "<li><a href='manage_teachers.php' class='text-blue-500 hover:underline'>Manage Teachers</a></li>";
echo "<li><a href='manage_modules.php' class='text-blue-500 hover:underline'>Manage Modules</a></li>";
echo "</ul>";
?>
<body>
    <a href="../backend/login.php">logout</a>
</body>
