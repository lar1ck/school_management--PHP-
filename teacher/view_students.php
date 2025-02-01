<?php
// teacher/view_students.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../frontend/login.html');  // Redirect to login if not teacher
    exit();
}

// Get Teacher ID from session
$teacher_id = $_SESSION['user_id'];

// Fetch all students for the teacher to view
$sql = "SELECT * FROM students";
$students_result = mysqli_query($karine_conn, $sql);

// View Marks for a specific student
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch marks for the selected student
    $marks_sql = "SELECT * FROM marks WHERE student_id = '$student_id' AND teacher_id = '$teacher_id'";
    $marks_result = mysqli_query($karine_conn, $marks_sql);
    $student_info = mysqli_fetch_assoc(mysqli_query($karine_conn, "SELECT * FROM students WHERE student_id = '$student_id'"));
}
?>
<a href="../backend/logout.php">logout</a>

<h1>View Students</h1>

<!-- List of Students -->
<table class="table-auto border-collapse border border-gray-200 mb-6">
    <thead>
        <tr>
            <th class="border px-4 py-2">Student Name</th>
            <th class="border px-4 py-2">Class</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $student['name']; ?></td>
                <td class="border px-4 py-2"><?php echo $student['class']; ?></td>
                <td class="border px-4 py-2">
                    <a href="?student_id=<?php echo $student['student_id']; ?>" class="bg-blue-500 text-white px-4 py-2">View Marks</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php if (isset($marks_result)) { ?>

    <h2>Marks for <?php echo $student_info['name']; ?></h2>
    <table class="table-auto border-collapse border border-gray-200 mb-6">
        <thead>
            <tr>
                <th class="border px-4 py-2">Subject</th>
                <th class="border px-4 py-2">Marks</th>
                <th class="border px-4 py-2">Entry Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($mark = mysqli_fetch_assoc($marks_result)) { ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $mark['subject']; ?></td>
                    <td class="border px-4 py-2"><?php echo $mark['marks']; ?></td>
                    <td class="border px-4 py-2"><?php echo $mark['entry_date']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } ?>
