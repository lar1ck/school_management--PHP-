<!-- create_student.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php
    $happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
    // if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    //     header('Location: ../backend/login.php');
    //     exit();
    // }

    function generate_student_id($happy_conn)
    {
        $prefix = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $year = date("Y");
        $random_digit = rand(0, 9);
        $student_id = $prefix . $year . $random_digit;
        while (mysqli_num_rows(mysqli_query($happy_conn, "SELECT id FROM happy__tblstudents WHERE student_id = '$student_id'")) > 0) {
            $random_digit = rand(0, 9);
            $student_id = $prefix . $year . $random_digit;
        }
        return $student_id;
    }
    if (isset($_POST['add_student'])) {
        $name = htmlspecialchars($_POST['name']);
        $student_id = htmlspecialchars($_POST['student_id']);
        $class = htmlspecialchars($_POST['class']);
        $other_details = htmlspecialchars($_POST['other_details']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $happy_conn->prepare("INSERT INTO happy__tblstudents (name, student_id, class, other_details, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $student_id, $class, $other_details, $password);
        $stmt->execute();
        header("Location: list_students.php");
        exit();
    }
    ?>
    <?php include 'sidebar.php'; ?>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mr-32">
        <h1 class="text-2xl font-semibold text-center mb-4">Add New Student</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Name</label>
            <input type="text" name="name" required class="w-full p-2 border rounded">
            <label class="block">Student ID</label>
            <input type="text" name="student_id" value="<?php echo generate_student_id($happy_conn); ?>" readonly required class="w-full p-2 border rounded bg-gray-100">
            <label class="block">Class</label>
            <input type="text" name="class" required class="w-full p-2 border rounded">
            <label class="block">Other Details</label>
            <textarea name="other_details" class="w-full p-2 border rounded"></textarea>
            <label class="block">Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded">
            <button type="submit" name="add_student" class="bg-blue-500 text-white px-4 py-2 rounded">Add Student</button>
        </form>
    </div>
</body>

</html>