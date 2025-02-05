<?php


$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "student_marks_db"; 

$carrick_conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$carrick_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
