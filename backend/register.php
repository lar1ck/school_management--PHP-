<?php
session_start();
include_once('../backend/config.php');  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = mysqli_real_escape_string($carrick_conn, $_POST['role']);
    $email = mysqli_real_escape_string($carrick_conn, $_POST['email']);
    $password = mysqli_real_escape_string($carrick_conn, $_POST['password']);

    if ($role == 'admin') {
        $sql = "SELECT * FROM ShyakCarrick_tbladmins WHERE username = '$email'";
    } elseif ($role == 'teacher') {
        $sql = "SELECT * FROM ShyakCarrick_tblteachers WHERE username = '$email'";
    } elseif ($role == 'student') {
        $sql = "SELECT * FROM ShyakCarrick_tblstudents WHERE student_id = '$email'";
    }

    $result = mysqli_query($carrick_conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        if ($role == 'admin') {
            header('Location: ../admin/dashboard.php');
        } elseif ($role == 'teacher') {
            header('Location: ../teacher/dashboard.php');
        } else {
            header('Location: ../student/dashboard.php');
        }
        exit();
    } else {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($role == 'admin') {
            $sql = "INSERT INTO ShyakCarrick_tbladmins (username, password) VALUES ('$email', '$hashed_password')";
        } elseif ($role == 'teacher') {
            $sql = "INSERT INTO ShyakCarrick_tblteachers (username, password) VALUES ('$email', '$hashed_password')";
        } elseif ($role == 'student') {
            $sql = "INSERT INTO ShyakCarrick_tblstudents (student_id, password) VALUES ('$email', '$hashed_password')";
        }

        if (mysqli_query($carrick_conn, $sql)) {
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;
            if ($role == 'admin') {
                header('Location: ../admin/dashboard.php');
            } elseif ($role == 'teacher') {
                header('Location: ../teacher/dashboard.php');
            } else {
                header('Location: ../student/dashboard.php');
            }
            exit();
        } else {
            echo "Error: " . mysqli_error($carrick_conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <form action="register.php" method="POST">
        <label for="role">Select Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>

        <br><br>

        <label for="email">ID:</label>
        <input type="text" name="email" required placeholder="Enter your ID">

        <br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required placeholder="Enter your password">

        <br><br>

        <button type="submit">Register</button>
    </form>
    aready have an account <a href="./login.php">login</a>
    

</body>
</html>
