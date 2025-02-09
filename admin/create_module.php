<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_POST['add_module'])) {
    $module_name = htmlspecialchars($_POST['module_name']);
    $description = htmlspecialchars($_POST['description']);
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $stmt = $happy_conn->prepare("INSERT INTO happy__tblmodules (module_name, description, parent_module_id, is_active) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $module_name, $description, $parent_module_id, $is_active);
    $stmt->execute();
    header("Location: list_modules.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Module</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" bg-gray-950  text-whitebg-gray-950 text-white">
    <?php include 'sidebar.php'; ?>
    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-center mb-4">Add New Module</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Module Name</label>
            <input type="text" name="module_name" required class="w-full p-2 border rounded bg-gray-800">
            <label class="block">Description</label>
            <textarea name="description" class="w-full p-2 border rounded bg-gray-800"></textarea>
            <label class="block">Parent Module</label>
            <select name="parent_module_id" class="w-full p-2 border rounded bg-gray-800">
                <option value="">-- Select Parent Module --</option>
                <?php $modules = mysqli_query($happy_conn, "SELECT id, module_name FROM happy__tblmodules WHERE parent_module_id IS NULL");
                while ($module = mysqli_fetch_assoc($modules)) {
                    echo "<option value='{$module['id']}'>{$module['module_name']}</option>";
                } ?>
            </select>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" class="mr-2"> Active
            </label>
            <button type="submit" name="add_module" class="bg-blue-500 text-white px-4 py-2 rounded">Add Module</button>
        </form>
    </div>
</body>

</html>