<?php
$conn = mysqli_connect("localhost", "root", "", "happy_db");

$students_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM happy__tblstudents"))['count'];
$teachers_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM happy__tblteachers"))['count'];
$modules_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM happy__tblmodules"))['count'];
$marks_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM happy__tblmarks"))['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" bg-gray-950  text-whitebg-gray-950 text-white">
    <?php include 'sidebar.php'; ?>
    <div class="max-w-6xl mx-auto p-4 rounded-lg mt-20">
        <h1 class="text-3xl font-semibold text-center mb-6">School Management Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Students Card -->
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md text-center">
                <i class="bi bi-person-lines-fill text-3xl"></i>
                <h2 class="text-xl font-semibold mt-2">Students</h2>
                <p class="text-2xl font-bold"><?php echo $students_count; ?></p>
                <a href="list_students.php" class="block mt-4 bg-gray-900 text-blue-500 px-4 py-2 rounded">View Students</a>
            </div>

            <!-- Teachers Card -->
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-md text-center">
                <i class="bi bi-people-fill text-3xl"></i>
                <h2 class="text-xl font-semibold mt-2">Teachers</h2>
                <p class="text-2xl font-bold"><?php echo $teachers_count; ?></p>
                <a href="list_teachers.php" class="block mt-4 bg-gray-900 text-green-500 px-4 py-2 rounded">View Teachers</a>
            </div>

            <!-- Modules Card -->
            <div class="bg-purple-500 text-white p-6 rounded-lg shadow-md text-center">
                <i class="bi bi-book-fill text-3xl"></i>
                <h2 class="text-xl font-semibold mt-2">Modules</h2>
                <p class="text-2xl font-bold"><?php echo $modules_count; ?></p>
                <a href="list_modules.php" class="block mt-4 bg-gray-900 text-purple-500 px-4 py-2 rounded">View Modules</a>
            </div>

            <!-- Marks Card -->
            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md text-center">
                <i class="bi bi-bar-chart-fill text-3xl"></i>
                <h2 class="text-xl font-semibold mt-2">Marks</h2>
                <p class="text-2xl font-bold"><?php echo $marks_count; ?></p>
                <a href="list_marks.php" class="block mt-4 bg-gray-900 text-yellow-500 px-4 py-2 rounded">View Marks</a>
            </div>
        </div>
    </div>
</body>

</html>