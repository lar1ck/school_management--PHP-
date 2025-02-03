<?php


$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "student_marks_db"; 

$karine_conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$karine_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
