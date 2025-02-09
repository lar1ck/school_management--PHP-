<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM happy__tblmarks WHERE student_id = $id";
$get_student = "SELECT * FROM happy__tblstudents WHERE student_id= $id";
$get_student_result = mysqli_query($happy_conn, $get_student);
$student_data = mysqli_fetch_assoc($get_student_result);

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
    <?php include 'sidebar.php'; ?>
    <div class="max-w-3xl mt-20 mx-auto  ">
        <div class=" flex gap-4">
            <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 mb-6">
                Go Back
            </button>
            <a href="download_marks.php?id=<?php echo $id; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 mb-6 inline-block">
                Generate Report
            </a>
        </div>

        <div class="  flex gap-2">
            <h1 class="text-3xl font-bold text-white mb-6">Student marks for: <?php echo htmlspecialchars($student_data['name'] ?? 'Unknown'); ?></h1>
        </div>

        <div class="bg-gray-900 shadow-md rounded-lg overflow-hidden">
            <table class="w-full border-collapse bg-gray-900 rounded-lg overflow-hidden">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="p-3 text-white ">Subject</th>
                        <th class="p-3 text-white ">Marks</th>
                        <th class="p-3 text-white ">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm text-white "><?php echo $row['subject']; ?></td>
                            <td class="px-6 py-4 text-sm text-white "><?php echo $row['marks']; ?></td>
                            <td class="px-6 py-4 text-sm text-white "><?php echo $row['entry_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</body>

</html>