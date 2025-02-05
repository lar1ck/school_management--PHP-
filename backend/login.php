<?php
session_start();
include_once('../backend/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($role == 'admin') {
        $query = "SELECT * FROM happy__tbladmins WHERE username = ?";
        $stmt = mysqli_prepare($happy_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_type'] = 'admin';
                $_SESSION['username'] = $username;
                header("Location: ../admin/dashboard.php");
                exit();
            }
        }
    } elseif ($role == 'teacher') {
        $query = "SELECT * FROM happy__tblteachers WHERE username = ?";
        $stmt = mysqli_prepare($happy_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($teacher = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $teacher['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_type'] = 'teacher';
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $teacher['id'];
                header("Location: ../teacher/dashboard.php");
                exit();
            }
        }
    } elseif ($role == 'student') {
        $query = "SELECT * FROM happy__tblstudents WHERE student_id = ?";
        $stmt = mysqli_prepare($happy_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white border border-border rounded-lg p-8 w-96">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>

        <?php if (isset($error_message)) { ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded-md rounded-l-none">
                <p><?php echo htmlspecialchars($error_message); ?></p>
            </div>
        <?php } ?>

        <form action="login.php" method="POST" class="space-y-4">
            <!-- User Role -->
            <div>
                <label class="block font-semibold text-gray-700 mb-1" for="role">User Role</label>
                <select name="role" class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 outline-none" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <!-- Username -->
            <div>
                <label class="block font-semibold text-gray-700 mb-1" for="username">Username</label>
                <input type="text" name="username" placeholder="Enter your username"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 outline-none" required>
            </div>

            <!-- Password -->
            <div>
                <label class="block font-semibold text-gray-700 mb-1" for="password">Password</label>
                <input type="password" name="password" placeholder="Enter your password"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 outline-none" required>
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">
                Login
            </button>
        </form>
    </div>
</body>

</html>
