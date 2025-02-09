<?php
if (!isset($_SESSION)) {
  session_start();
}
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'teacher') {
  header('Location: ../frontend/login.html');
  exit();
}

$teacher_id = $_SESSION['user_id'];

$sql_teacher = "SELECT * FROM happy__tblteachers WHERE id = '$teacher_id'";
$result_teacher = mysqli_query($happy_conn, $sql_teacher);
$teacher_data = mysqli_fetch_assoc($result_teacher);

$sql_marks = "SELECT * FROM happy__tblmarks WHERE teacher_id = '$teacher_id' ORDER BY entry_date DESC";
$result_marks = mysqli_query($happy_conn, $sql_marks);
?>

<h1 class="text-3xl font-bold text-white mb-6">Teacher Dashboard</h1>

<div class="p-6 rounded-lg shadow-lg mb-6">
  <h2 class="text-2xl font-semibold text-white mb-4">Welcome, <?php echo htmlspecialchars($teacher_data['name']); ?>!</h2>
  <div class="text-lg text-white"><strong>Subject:</strong> <?php echo htmlspecialchars($teacher_data['subject']); ?></div>
</div>

<h2 class="text-2xl font-semibold text-white mb-4">Marks History</h2>
<table class="w-full bg-gray-700 border border-gray-700 rounded-lg overflow-hidden">
  <thead>
    <tr class="bg-gray-800 text-white">
      <th class="py-3 px-4 text-left">Student ID</th>
      <th class="py-3 px-4 text-left">Subject</th>
      <th class="py-3 px-4 text-left">Marks</th>
      <th class="py-3 px-4 text-left">Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result_marks)) { ?>
      <tr class="border-b border-white hover:bg-gray-600">
        <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($row['student_id']); ?></td>
        <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($row['subject']); ?></td>
        <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($row['marks']); ?></td>
        <td class="py-3 px-4 text-white"><?php echo date('M j, Y', strtotime($row['entry_date'])); ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>