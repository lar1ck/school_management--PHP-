<!-- list_teachers.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-4">
    <?php
    session_start();
    $happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: ../backend/login.php');
        exit();
    }
    
    $result = mysqli_query($happy_conn, "SELECT * FROM happy__tblteachers");
    ?>
     <?php include 'sidebar.php'; ?>
    <div class="max-w-3xl mx-auto mr-32">
    <div class=" flex justify-between items-center pb-4">
      <h1 class=" text-2xl font-semibold">Teachers List</h1>
      <a href="create_teacher.php" class="bg-blue-600 px-4 py-3 text-center text-sm font-semibold inline-block text-white cursor-pointer uppercase transition duration-200 ease-in-out rounded-md hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 active:scale-95">Add New Teacher</a>
    </div>
        <table class="w-full bg-white rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Username</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="border-b">
                        <td class="p-3"><?php echo $row['id']; ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($row['username']); ?></td>
                        <td class="p-3">
                            <a href="edit_teacher.php?id=<?php echo $row['id']; ?>" class="text-blue-500">Edit</a> |
                            <a href="delete_teacher.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-500">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>