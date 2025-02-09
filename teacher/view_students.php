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

$teacher_sql = "SELECT subject FROM happy__tblteachers WHERE id = '$teacher_id'";
$teacher_res = mysqli_query($happy_conn, $teacher_sql);
$teacher_data = mysqli_fetch_assoc($teacher_res);
$teacher_subject = $teacher_data['subject'] ?? '';

$sql = "SELECT * FROM happy__tblstudents";
$students_result = mysqli_query($happy_conn, $sql);

$marks_result = false;
$student_info = false;

if (isset($_POST['add_mark'])) {
  $student_id = $_POST['student_id'];
  $marks = $_POST['marks'];
  $subject = $teacher_subject;

  $insert_sql = "INSERT INTO happy__tblmarks (student_id, subject, marks, teacher_id) VALUES (?, ?, ?, ?)";
  $stmt = $happy_conn->prepare($insert_sql);
  $stmt->bind_param("ssdi", $student_id, $subject, $marks, $teacher_id);
  if ($stmt->execute()) {
    $success_message = "Marks added successfully!";
  } else {
    $error_message = "Error: " . $stmt->error;
  }
  header("Location: ?page=view_students&student_id=" . urlencode($student_id));
  exit();
}

if (isset($_GET['student_id'])) {
  $student_id = $_GET['student_id'];
  $marks_sql = "SELECT * FROM happy__tblmarks WHERE student_id = '$student_id' AND teacher_id = '$teacher_id'";
  $marks_result = mysqli_query($happy_conn, $marks_sql);
  $student_info = mysqli_fetch_assoc(mysqli_query($happy_conn, "SELECT * FROM happy__tblstudents WHERE student_id = '$student_id'"));
}

if (isset($_POST['update_marks'])) {
  $mark_id = $_POST['mark_id'];
  $new_marks = $_POST['new_marks'];

  $sql_update = "UPDATE happy__tblmarks SET marks = '$new_marks' WHERE id = '$mark_id' AND teacher_id = '$teacher_id'";
  mysqli_query($happy_conn, $sql_update);

  echo "<script>window.location.href = window.location.href;</script>";
}

if (isset($_POST['delete_marks'])) {
  $mark_id = $_POST['mark_id'];

  $sql_delete = "DELETE FROM happy__tblmarks WHERE id = '$mark_id' AND teacher_id = '$teacher_id'";
  mysqli_query($happy_conn, $sql_delete);

  echo "<script>window.location.href = window.location.href;</script>";
}
?>

<h1 class="text-3xl font-bold text-white mb-6">Student List</h1>
<table class="w-full bg-gray-700 border border-border rounded-lg overflow-hidden">
  <thead>
    <tr class="bg-gray-800 text-white">
      <th class="py-3 px-4 text-left">Student Name</th>
      <th class="py-3 px-4 text-left">Class</th>
      <th class="py-3 px-4 text-left">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
      <tr class="border-b border-white hover:bg-gray-600">
        <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($student['name']); ?></td>
        <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($student['class']); ?></td>
        <td class="py-3 px-4">
          <a href="?page=view_students&student_id=<?php echo urlencode($student['student_id']); ?>" class="text-blue-600 hover:underline">View Marks</a>
          <a href="?page=view_students&student_id=<?php echo urlencode($student['student_id']); ?>&action=add_marks" class="text-blue-600 hover:underline ml-4">Add Marks</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php if ($student_info): ?>
  <div class="mt-6 rounded-lg  ">
    <h2 class="text-2xl font-semibold text-white mb-4 ">Marks for <?php echo htmlspecialchars($student_info['name']); ?></h2>
    <table class="w-full bg-gray-700 border border-border rounded-lg overflow-hidden">
      <thead>
        <tr class="bg-gray-800 text-white">
          <th class="py-3 px-4 text-left">Subject</th>
          <th class="py-3 px-4 text-left">Marks</th>
          <th class="py-3 px-4 text-left">Entry Date</th>
          <th class="py-3 px-4 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($mark = mysqli_fetch_assoc($marks_result)) { ?>
          <tr class="border-b border-white hover:bg-gray-600">
          <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($mark['subject']); ?></td>
             <td class="py-3 px-4 text-white"><?php echo htmlspecialchars($mark['marks']); ?></td>
             <td class="py-3 px-4 text-white"><?php echo date('M j, Y', strtotime($mark['entry_date'])); ?></td>
            <td class="py-3 px-4">
              <form method="POST" class="inline">
                <input type="hidden" name="mark_id" value="<?php echo $mark['id']; ?>">
                <button type="submit" name="delete_marks" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700">Delete</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>