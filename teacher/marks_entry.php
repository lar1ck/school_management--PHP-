<?php
// teacher/marks_entry.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is a teacher
if ($_SESSION['user_type'] !== 'teacher') {
    header('Location: ../frontend/login.html');  // Redirect to login if not teacher
    exit();
}

// Handle Marks Entry
if (isset($_POST['add_marks'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $teacher_id = $_SESSION['user_id'];

    $sql = "INSERT INTO marks (student_id, subject, marks, teacher_id) VALUES ('$student_id', '$subject', '$marks', '$teacher_id')";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Marks added successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Fetch all students for viewing
$sql = "SELECT * FROM students";
$result = mysqli_query($karine_conn, $sql);

// Fetch marks for the teacher
$sql_marks = "SELECT * FROM marks WHERE teacher_id = '{$_SESSION['user_id']}'";
$result_marks = mysqli_query($karine_conn, $sql_marks);
?>

<h1>Marks Entry</h1>

<!-- Marks Entry Form -->
<form method="POST" class="mb-6">
    <h2>Enter Marks</h2>
    <label for="student_id">Student ID</label><input type="text" name="student_id" required class="border p-2" />
    <label for="subject">Subject</label><input type="text" name="subject" required class="border p-2" />
    <label for="marks">Marks</label><input type="number" name="marks" required class="border p-2" />
    <button type="submit" name="add_marks" class="bg-blue-500 text-white p-2">Save Marks</button>
</form>

<!-- Display marks entered by teacher -->
<h2>Marks Entered</h2>
<table class="min-w-full table-auto mt-4">
    <thead><tr><th>Student ID</th><th>Subject</th><th>Marks</th><th>Date</th></tr></thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result_marks)) { ?>
        <tr>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['marks']; ?></td>
            <td><?php echo $row['entry_date']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="../backend/logout.php">logout</a>
