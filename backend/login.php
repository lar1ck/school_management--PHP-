<?php
// backend/login.php

session_start();
include_once('../backend/config.php');  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];  // Get the selected role
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password match the selected role
    if ($role == 'admin') {
        $query = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($karine_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Admin login
                $_SESSION['user_type'] = 'admin';
                $_SESSION['username'] = $username;
                header("Location: ../admin/dashboard.php");
                exit();
            }
        }
    } elseif ($role == 'teacher') {
        $query = "SELECT * FROM teachers WHERE username = '$username'";
        $result = mysqli_query($karine_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $teacher = mysqli_fetch_assoc($result);
            if (password_verify($password, $teacher['password'])) {
                // Teacher login
                $_SESSION['user_type'] = 'teacher';
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $teacher['id'];
                header("Location: ../teacher/dashboard.php");
                exit();
            }
        }
    } elseif ($role == 'student') {
        $query = "SELECT * FROM students WHERE student_id = '$username'";
        $result = mysqli_query($karine_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Student login
                $_SESSION['user_type'] = 'student';
                $_SESSION['student_id'] = $username;
                header("Location: ../student/dashboard.php");
                exit();
            }
        }
    }

    // Invalid credentials
    $error_message = "Invalid login credentials!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    
    <?php if (isset($error_message)) { ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php } ?>
    
    <form action="login.php" method="POST">
        <select name="role" required>
            <option value="" disabled selected>Select your role</option>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
        <br><br>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    
    Don't have an account? <a href="./register.php">Register</a>
</body>
</html>
