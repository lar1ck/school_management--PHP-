<?php
// backend/login_action.php

session_start();
include_once('../config.php');  // Include database connection (replace with your config file)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($karine_conn, $_POST['username']);
    $password = mysqli_real_escape_string($karine_conn, $_POST['password']);

    // Check if the username and password match an admin
    $query = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($karine_conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Admin login success
            $_SESSION['user_type'] = 'admin';
            $_SESSION['username'] = $username;
            header("Location: ../admin/dashboard.php");
            exit();
        }
    }

    // Check teacher credentials
    $query = "SELECT * FROM teachers WHERE username = '$username'";
    $result = mysqli_query($karine_conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Teacher login success
            $_SESSION['user_type'] = 'teacher';
            $_SESSION['username'] = $username;
            header("Location: ../teacher/dashboard.php");
            exit();
        }
    }

    // Check student credentials
    $query = "SELECT * FROM students WHERE student_id = '$username'";
    $result = mysqli_query($karine_conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Student login success
            $_SESSION['user_type'] = 'student';
            $_SESSION['student_id'] = $username;
            header("Location: ../student/dashboard.php");
            exit();
        }
    }

    // Invalid credentials
    echo "Invalid login credentials!";
}
?>
