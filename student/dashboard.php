<?php
// student/dashboard.php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is a student
if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../backend/login.php');  // Redirect to login if not student
    exit();
}

echo "<h1>Welcome, Student!</h1>";
echo "<ul class='space-y-4'>";
echo "<li><a href='view_marks.php' class='text-blue-500 hover:underline'>View Marks</a></li>";
echo "</ul>";
?>
<body>
<a href="../backend/logout.php">logout</a>
</body>