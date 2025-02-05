<?php
if (!isset($_SESSION)) { session_start(); }
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

<style>
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    background: white;
  }
  th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ecf0f1;
  }
  th {
    background-color: #4a90e2;
    color: white;
    font-weight: 600;
  }
  tr:hover {
    background-color: #f8f9fa;
  }
  .action-link {
    color: #4a90e2;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
    margin-right: 10px;
  }
  .action-link:hover {
    color: #357abd;
    text-decoration: underline;
  }
  .marks-table {
    margin-top: 30px;
    border: 2px solid #4a90e2;
    border-radius: 8px;
    overflow: hidden;
  }
  h1, h2 {
    color: #2c3e50;
    margin-bottom: 20px;
  }
  .add-marks-form {
    margin-top: 30px;
    padding: 20px;
    border: 2px solid #4a90e2;
    border-radius: 8px;
    background: white;
    max-width: 400px;
  }
  .add-marks-form label {
    display: block;
    margin-bottom: 5px;
  }
  .add-marks-form input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .add-marks-form button {
    background-color: #4a90e2;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
  }
  .add-marks-form button:hover {
    background-color: #357abd;
  }
  .message {
    padding: 10px;
    margin: 15px 0;
    border-radius: 4px;
  }
  .success { background-color: #e8f5e9; color: #2e7d32; }
  .error { background-color: #ffebee; color: #c62828; }
  .update-form input[type="number"] {
    width: 70px;
    padding: 5px;
  }
  .update-form button {
    padding: 5px 10px;
    margin-left: 5px;
    cursor: pointer;
  }
  .delete-btn {
    padding: 5px 10px;
    margin-left: 10px;
    cursor: pointer;
    background-color: #e74c3c;
    color: white;
    border: none;
  }
  .delete-btn:hover {
    background-color: #c0392b;
  }
</style>

<h1>Student List</h1>
<table>
  <thead>
    <tr>
      <th>Student Name</th>
      <th>Class</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
      <tr>
        <td><?php echo htmlspecialchars($student['name']); ?></td>
        <td><?php echo htmlspecialchars($student['class']); ?></td>
        <td>
          <a href="?page=view_students&student_id=<?php echo urlencode($student['student_id']); ?>" class="action-link">
            View Marks
          </a>
          <a href="?page=view_students&student_id=<?php echo urlencode($student['student_id']); ?>&action=add_marks" class="action-link">
            Add Marks
          </a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php if (isset($success_message)) { ?>
  <div class="message success"><?php echo $success_message; ?></div>
<?php } ?>
<?php if (isset($error_message)) { ?>
  <div class="message error"><?php echo $error_message; ?></div>
<?php } ?>

<?php if ($student_info): ?>
  <div class="marks-section">
    <h2><?php echo htmlspecialchars($student_info['name']); ?>'s Academic Record</h2>
    <table class="marks-table">
      <thead>
        <tr>
          <th>Subject</th>
          <th>Marks</th>
          <th>Entry Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($marks_result && mysqli_num_rows($marks_result) > 0): ?>
          <?php while ($mark = mysqli_fetch_assoc($marks_result)) { ?>
            <tr id="row-<?php echo $mark['id']; ?>">
              <td><?php echo htmlspecialchars($mark['subject']); ?></td>
              <td>
                <form method="POST" class="update-form" id="update-form-<?php echo $mark['id']; ?>">
                  <input type="hidden" name="mark_id" value="<?php echo $mark['id']; ?>">
                  <input type="hidden" name="update_marks" value="1">
                  <input type="number" name="new_marks" id="new_marks-<?php echo $mark['id']; ?>" value="<?php echo htmlspecialchars($mark['marks']); ?>" step="0.01" min="0" max="100" disabled>
                  <button type="button" id="edit-btn-<?php echo $mark['id']; ?>" onclick="toggleEdit(<?php echo $mark['id']; ?>)">Edit</button>
                </form>
              </td>
              <td><?php echo date('M j, Y', strtotime($mark['entry_date'])); ?></td>
              <td>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this mark?');" style="display:inline;">
                  <input type="hidden" name="mark_id" value="<?php echo $mark['id']; ?>">
                  <button type="submit" name="delete_marks" class="delete-btn">Delete</button>
                </form>
              </td>
            </tr>
          <?php } ?>
        <?php else: ?>
            <tr>
              <td colspan="4">No marks recorded yet.</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php
  if (isset($_GET['action']) && $_GET['action'] === 'add_marks'):
  ?>
    <div class="add-marks-form">
      <h2>Add Marks for <?php echo htmlspecialchars($student_info['name']); ?></h2>
      <form method="POST">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_info['student_id']); ?>">
        <p><strong>Subject:</strong> <?php echo htmlspecialchars($teacher_subject); ?></p>
        <label for="marks">Marks:</label>
        <input type="number" name="marks" id="marks" step="0.01" min="0" max="100" required>
        <button type="submit" name="add_mark">Submit Marks</button>
      </form>
    </div>
  <?php endif; ?>
<?php endif; ?>

<script>
function toggleEdit(markId) {
    var inputField = document.getElementById("new_marks-" + markId);
    var button = document.getElementById("edit-btn-" + markId);
    var form = document.getElementById("update-form-" + markId);
    if (inputField.disabled) {
        inputField.disabled = false;
        inputField.focus();
        button.textContent = "Save";
    } else {
        form.submit();
    }
}
</script>
