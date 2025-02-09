<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php
    session_start();
    $happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ../backend/login.php');
        exit();
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = mysqli_query($happy_conn, "SELECT * FROM happy__tblstudents WHERE id = $id");
        $student = mysqli_fetch_assoc($result);
    }

    if (isset($_POST['edit_student'])) {
        $name = htmlspecialchars($_POST['name']);
        $class = htmlspecialchars($_POST['class']);
        $other_details = htmlspecialchars($_POST['other_details']);

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $happy_conn->prepare("UPDATE happy__tblstudents SET name=?, class=?, other_details=?, password=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $class, $other_details, $password, $id);
        } else {
            $stmt = $happy_conn->prepare("UPDATE happy__tblstudents SET name=?, class=?, other_details=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $class, $other_details, $id);
        }
        $stmt->execute();
        header("Location: list_students.php");
        exit();
    }
    ?>
 <?php include 'sidebar.php'; ?>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mr-32">
        <h1 class="text-2xl font-semibold text-center mb-4">Edit Student</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required class="w-full p-2 border rounded">
            <label class="block">Class</label>
            <input type="text" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" required class="w-full p-2 border rounded">
            <label class="block">Other Details</label>
            <textarea name="other_details" class="w-full p-2 border rounded"><?php echo htmlspecialchars($student['other_details']); ?></textarea>
            <label class="block">Password (Leave empty to keep current password)</label>
            <input type="password" name="password" class="w-full p-2 border rounded">
            <button type="submit" name="edit_student" class="bg-blue-500 text-white px-4 py-2 rounded">Update Student</button>
        </form>
    </div>
</body>

</html>