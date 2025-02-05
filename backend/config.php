<?php


$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "happy_db"; 

$happy_conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$happy_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
