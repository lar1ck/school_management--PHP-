<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}


$sql = "SELECT * FROM happy__tblmodules";
$result = mysqli_query($happy_conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Modules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" bg-gray-950  text-whitebg-gray-950 text-white">
<?php include 'sidebar.php'; ?>
<div class="max-w-3xl mx-auto mr-32 pt-6">
<div class=" flex justify-between items-center pb-4">
      <h1 class=" text-2xl font-semibold">Modules List</h1>
      <a href="create_student.php" class="bg-blue-600 px-4 py-3 text-center text-sm font-semibold inline-block text-white cursor-pointer uppercase transition duration-200 ease-in-out rounded-md hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 active:scale-95">Add New Module</a>
    </div>
        <table class="w-full border-collapse bg-gray-900 rounded-lg overflow-hidden">
            <thead class="bg-gray-800">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Module Name</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="border-b">
                        <td class="p-3"> <?php echo $row['id']; ?> </td>
                        <td class="p-3"> <?php echo $row['module_name']; ?> </td>
                        <td class="p-3"> <?php echo $row['description']; ?> </td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded <?php echo $row['is_active'] ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700'; ?>">
                                <?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="edit_module.php?id=<?php echo $row['id']; ?>" class="text-blue-600">Edit</a> |
                            <a href="delete_module.php?id=<?php echo $row['id']; ?>" class="text-red-600">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
