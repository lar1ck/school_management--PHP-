<!-- backend/db_connection.php -->
<?php
$carrick_conn = mysqli_connect("localhost", "root", "", "student_marks_db");

if (!$carrick_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
