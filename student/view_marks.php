<?php
// student/view_marks.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is a student
if ($_SESSION['user_type'] !== 'student') {
    header('Location: ../frontend/login.html');  // Redirect to login if not student
    exit();
}

// Fetch marks for the student
$sql = "SELECT * FROM marks WHERE student_id = '{$_SESSION['student_id']}'";
$result = mysqli_query($karine_conn, $sql);
?>

<h1>Your Marks</h1>
<table class="min-w-full table-auto mt-4">
    <thead><tr><th>Subject</th><th>Marks</th><th>Date</th></tr></thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['marks']; ?></td>
            <td><?php echo $row['entry_date']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="../backend/login.php">logout</a>

