<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" bg-gray-950  text-whitebg-gray-950 text-white">
    <?php
    session_start();
    $happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ../backend/login.php');
        exit();
    }
    
    $result_modules = mysqli_query($happy_conn, "SELECT * FROM happy__tblmodules WHERE is_active = 1");

    if (isset($_POST['add_teacher'])) {
        $name = htmlspecialchars($_POST['name']);
        $subject = htmlspecialchars($_POST['subject']);
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $stmt = $happy_conn->prepare("INSERT INTO happy__tblteachers (name, subject, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $subject, $username, $password);
        $stmt->execute();
        header("Location: list_teachers.php");
        exit();
    }
    ?>
      <?php include 'sidebar.php'; ?>
      <div class="max-w-3xl mt-20 mx-auto  ">
        <h1 class="text-2xl font-semibold text-center mb-4">Add New Teacher</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Name</label>
            <input type="text" name="name" required class="w-full p-2 border rounded bg-gray-800">
            <label class="block">Module</label>
            <select name="subject" required class="w-full p-2 border rounded bg-gray-800">
                <option value="">Select Module</option>
                <?php while ($module = mysqli_fetch_assoc($result_modules)) { ?>
                    <option value="<?php echo $module['module_name']; ?>">
                        <?php echo $module['module_name']; ?>
                    </option>
                <?php } ?>
            </select>
            <label class="block">Username</label>
            <input type="text" name="username" required class="w-full p-2 border rounded bg-gray-800">
            <label class="block">Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded bg-gray-800">
            <button type="submit" name="add_teacher" class="bg-blue-500 text-white px-4 py-2 rounded">Add Teacher</button>
        </form>
    </div>
</body>
</html>