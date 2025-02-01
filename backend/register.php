<?php
// backend/register.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect form data
    $role = mysqli_real_escape_string($karine_conn, $_POST['role']);
    $email = mysqli_real_escape_string($karine_conn, $_POST['email']);
    $password = mysqli_real_escape_string($karine_conn, $_POST['password']);

    // Check if email already exists in the selected role table
    if ($role == 'admin') {
        $sql = "SELECT * FROM admins WHERE username = '$email'";
    } elseif ($role == 'teacher') {
        $sql = "SELECT * FROM teachers WHERE username = '$email'";
    } elseif ($role == 'student') {
        $sql = "SELECT * FROM students WHERE student_id = '$email'";
    }

    $result = mysqli_query($karine_conn, $sql);

    // If email exists, redirect to the appropriate dashboard
    if (mysqli_num_rows($result) > 0) {
        // Start session and set role-based redirection
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
        // If email does not exist, register the user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($role == 'admin') {
            $sql = "INSERT INTO admins (username, password) VALUES ('$email', '$hashed_password')";
        } elseif ($role == 'teacher') {
            $sql = "INSERT INTO teachers (username, password) VALUES ('$email', '$hashed_password')";
        } elseif ($role == 'student') {
            $sql = "INSERT INTO students (student_id, password) VALUES ('$email', '$hashed_password')";
        }

        if (mysqli_query($karine_conn, $sql)) {
            // Redirect to the respective dashboard after registration
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
            echo "Error: " . mysqli_error($karine_conn);
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

    <!-- Form to Register a User -->
    <form action="register.php" method="POST">
        <label for="role">Select Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>

        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required placeholder="Enter your email">

        <br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required placeholder="Enter your password">

        <br><br>

        <button type="submit">Register</button>
    </form>
    aready have an account <a href="./login.php">login</a>
    

</body>
</html>
