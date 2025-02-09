<!-- edit_teacher.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
    
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ../backend/login.php');
        exit();
    }
    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = mysqli_query($happy_conn, "SELECT * FROM happy__tblteachers WHERE id = $id");
        $teacher = mysqli_fetch_assoc($result);
    }
    
    $result_modules = mysqli_query($happy_conn, "SELECT * FROM happy__tblmodules WHERE is_active = 1");
    
    if (isset($_POST['edit_teacher'])) {
        $name = htmlspecialchars($_POST['name']);
        $subject = htmlspecialchars($_POST['subject']);
        $username = htmlspecialchars($_POST['username']);
        
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $happy_conn->prepare("UPDATE happy__tblteachers SET name=?, subject=?, username=?, password=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $subject, $username, $password, $id);
        } else {
            $stmt = $happy_conn->prepare("UPDATE happy__tblteachers SET name=?, subject=?, username=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $subject, $username, $id);
        }
        $stmt->execute();
        header("Location: list_teachers.php");
        exit();
    }
    ?>
      <?php include 'sidebar.php'; ?>
      <div class="max-w-3xl mx-auto mr-32">
        <h1 class="text-2xl font-semibold text-center mb-4">Edit Teacher</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required class="w-full p-2 border rounded bg-gray-800">
            <label class="block">Module</label>
            <select name="subject" required class="w-full p-2 border rounded bg-gray-800">
                <option value="">Select Module</option>
                <?php while ($module = mysqli_fetch_assoc($result_modules)) { ?>
                    <option value="<?php echo $module['module_name']; ?>" <?php if($teacher['subject'] == $module['module_name']) echo 'selected'; ?>>
                        <?php echo $module['module_name']; ?>
                    </option>
                <?php } ?>
            </select>
            <label class="block">Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($teacher['username']); ?>" required class="w-full p-2 border rounded bg-gray-800">
            <label class="block">Password (Leave empty to keep current password)</label>
            <input type="password" name="password" class="w-full p-2 border rounded bg-gray-800">
            <button type="submit" name="edit_teacher" class="bg-blue-500 text-white px-4 py-2 rounded">Update Teacher</button>
        </form>
    </div>
</body>
</html>
