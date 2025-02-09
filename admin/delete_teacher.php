<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $happy_conn->prepare("DELETE FROM happy__tblteachers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: list_teachers.php");
    exit();
}
?>