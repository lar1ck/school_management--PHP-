<?php


session_start();
include_once('../backend/config.php');  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];  
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($role == 'admin') {
        $query = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($karine_conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
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

    $error_message = "Invalid login credentials!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="parent-div">
        <div class="image-div">
    
        </div>
        <div class="content-div">
            <h1>Login</h1> <br>
            
            <?php if (isset($error_message)) { ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
            
            <form action="login.php" method="POST">
                <select name="role" class="select-input" required>
                    <div class="mm">
                        <option value="" disabled selected>Select your role</option>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </div>
                </select> <br>
                
                <input type="text" name="username" placeholder="Username" class="text-input" required><br>
                
                <input type="password" name="password" placeholder="Password" class="text-input last" required><br>
                
                <button type="submit">Login</button>
            </form>
            
            <!-- <p class="new-one">Don't have an account? <a href="./register.php">Register</a></p> -->
        </div>
    </div>
</body>
</html>
