<?php
// teacher/dashboard.php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'teacher') {
    header('Location: ../backend/login.php'); // Redirect to login if not authorized
    exit();
}

echo "<h1>Welcome, Teacher!</h1>";
echo "<ul class='space-y-4'>";
echo "<li><a href='marks_entry.php' class='text-blue-500 hover:underline'>Enter Marks</a></li>";
echo "<li><a href='view_students.php' class='text-blue-500 hover:underline'>View Students</a></li>";
echo "</ul>";
?>
<body>
    <a href="../backend/logout.php">logout</a>
</body>