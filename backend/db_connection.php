<!-- backend/db_connection.php -->
<?php
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");

if (!$happy_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
