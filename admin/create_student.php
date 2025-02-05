<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  
    exit();
}

function generate_student_id($happy_conn) {
    $prefix = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);      
    $year = date("Y");         
    $random_digit = rand(0, 9);  

    $student_id = $prefix . $year . $random_digit;
    $exists = true;
    while ($exists) {
        $query = "SELECT id FROM happy__tblstudents WHERE student_id = '$student_id'";
        $result = mysqli_query($happy_conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $random_digit = rand(0, 9);
            $student_id = $prefix . $year . $random_digit;
        } else {
            $exists = false;
        }
    }
    return $student_id;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $class = htmlspecialchars($_POST['class']);
    $other_details = htmlspecialchars($_POST['other_details']);
    $password = $_POST['password'];
    $student_id = generate_student_id($happy_conn);
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $happy_conn->prepare("INSERT INTO happy__tblstudents (name, student_id, class, other_details, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $student_id, $class, $other_details, $hashed_password);

    if ($stmt->execute()) {
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<?php include 'sidebar.php'; ?>
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 text-center">Add New Student</h2>
        <form method="POST" class="mt-4">
            <label class="block text-gray-600">Name</label>
            <input type="text" name="name" required class="w-full p-2 border rounded mt-1">
            
            <label class="block text-gray-600 mt-2">Class</label>
            <input type="text" name="class" required class="w-full p-2 border rounded mt-1">
            
            <label class="block text-gray-600 mt-2">Other Details</label>
            <textarea name="other_details" class="w-full p-2 border rounded mt-1"></textarea>
            
            <label class="block text-gray-600 mt-2">Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded mt-1">
            
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded mt-4 hover:bg-blue-600">Add Student</button>
        </form>
    </div>
</body>
</html>
