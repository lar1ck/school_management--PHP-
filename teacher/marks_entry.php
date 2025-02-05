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

$sql_teacher = "SELECT * FROM ShyakCarrick_tblteachers WHERE id = '$teacher_id'";
$result_teacher = mysqli_query($carrick_conn, $sql_teacher);
$teacher_data = mysqli_fetch_assoc($result_teacher);

$sql_marks = "SELECT * FROM ShyakCarrick_tblmarks WHERE teacher_id = '$teacher_id' ORDER BY entry_date DESC";
$result_marks = mysqli_query($carrick_conn, $sql_marks);
?>

<style>
  .dashboard-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  .dashboard-card h2 {
    margin-bottom: 20px;
    color: #2c3e50;
  }
  .dashboard-info {
    font-size: 18px;
    margin-bottom: 10px;
    color: #34495e;
  }
  .styled-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  .styled-table th,
  .styled-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ecf0f1;
  }
  .styled-table th {
    background-color: #2c3e50;
    color: white;
  }
  .styled-table tr:hover {
    background-color: #f8f9fa;
  }
  h1, h2 {
    color: #2c3e50;
    margin-bottom: 20px;
  }
</style>

<h1>Teacher Dashboard</h1>

<div class="dashboard-card">
  <h2>Welcome, <?php echo htmlspecialchars($teacher_data['name']); ?>!</h2>
  <div class="dashboard-info"><strong>Subject:</strong> <?php echo htmlspecialchars($teacher_data['subject']); ?></div>
</div>

<h2>Marks History</h2>
<table class="styled-table">
  <thead>
    <tr>
      <th>Student ID</th>
      <th>Subject</th>
      <th>Marks</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result_marks)) { ?>
    <tr>
      <td><?php echo htmlspecialchars($row['student_id']); ?></td>
      <td><?php echo htmlspecialchars($row['subject']); ?></td>
      <td><?php echo htmlspecialchars($row['marks']); ?></td>
      <td><?php echo date('M j, Y', strtotime($row['entry_date'])); ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
