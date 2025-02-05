<?php
session_start();
include_once('../backend/config.php');  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = mysqli_real_escape_string($happy_conn, $_POST['role']);
    $email = mysqli_real_escape_string($happy_conn, $_POST['email']);
    $password = mysqli_real_escape_string($happy_conn, $_POST['password']);

    if ($role == 'admin') {
        $sql = "SELECT * FROM happy__tbladmins WHERE username = '$email'";
    } elseif ($role == 'teacher') {
        $sql = "SELECT * FROM happy__tblteachers WHERE username = '$email'";
    } elseif ($role == 'student') {
        $sql = "SELECT * FROM happy__tblstudents WHERE student_id = '$email'";
    }

    $result = mysqli_query($happy_conn, $sql);

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
            $sql = "INSERT INTO happy__tbladmins (username, password) VALUES ('$email', '$hashed_password')";
        } elseif ($role == 'teacher') {
            $sql = "INSERT INTO happy__tblteachers (username, password) VALUES ('$email', '$hashed_password')";
        } elseif ($role == 'student') {
            $sql = "INSERT INTO happy__tblstudents (student_id, password) VALUES ('$email', '$hashed_password')";
        }

        if (mysqli_query($happy_conn, $sql)) {
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
            echo "Error: " . mysqli_error($happy_conn);
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-md rounded-lg p-8 w-96">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Register</h2>

        <form action="register.php" method="POST" class="space-y-4">
            <!-- Role Selection -->
            <div>
                <label for="role" class="block text-gray-700 font-medium">Select Role:</label>
                <select name="role" required class="w-full p-2 border border-gray-300 rounded">
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <!-- Email/ID -->
            <div>
                <label for="email" class="block text-gray-700 font-medium">ID:</label>
                <input type="text" name="email" required placeholder="Enter your ID"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-medium">Password:</label>
                <input type="password" name="password" required placeholder="Enter your password"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-gray-600 mt-4">
            Already have an account? <a href="./login.php" class="text-blue-600 font-medium hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
