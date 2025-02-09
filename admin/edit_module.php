<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $happy_conn->prepare("SELECT * FROM happy__tblmodules WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $module = $result->fetch_assoc();
}

if (isset($_POST['edit_module'])) {
    $id = $_POST['id'];
    $module_name = htmlspecialchars($_POST['module_name']);
    $description = htmlspecialchars($_POST['description']);
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $stmt = $happy_conn->prepare("UPDATE happy__tblmodules SET module_name = ?, description = ?, parent_module_id = ?, is_active = ? WHERE id = ?");
    $stmt->bind_param("sssii", $module_name, $description, $parent_module_id, $is_active, $id);
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
    <title>Edit Module</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" bg-gray-950  text-whitebg-gray-950 text-white">
    <?php include 'sidebar.php'; ?>
    <div class="max-w-3xl mt-20 mx-auto bg-gray-900 p-6 rounded-lg mt-16 ">
        <div class=" flex gap-4 items-center">
            <button onclick="window.history.back()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 mb-6">
                Go Back
            </button>
            <h1 class="text-2xl font-semibold text-center mb-4">Edit Module</h1>
        </div>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $module['id']; ?>">
            <label class="block">Module Name</label>
            <input type="text" name="module_name" value="<?php echo $module['module_name']; ?>" required class="w-full p-2 border rounded bg-gray-800">
            <label class="block">Description</label>
            <textarea name="description" class="w-full p-2 border rounded bg-gray-800"><?php echo $module['description']; ?></textarea>
            <label class="block">Parent Module</label>
            <select name="parent_module_id" class="w-full p-2 border rounded bg-gray-800">
                <option value="">-- Select Parent Module --</option>
                <?php $modules = mysqli_query($happy_conn, "SELECT id, module_name FROM happy__tblmodules WHERE parent_module_id IS NULL AND id != {$module['id']}");
                while ($parent = mysqli_fetch_assoc($modules)) {
                    $selected = $parent['id'] == $module['parent_module_id'] ? 'selected' : '';
                    echo "<option value='{$parent['id']}' $selected>{$parent['module_name']}</option>";
                } ?>
            </select>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" <?php echo $module['is_active'] ? 'checked' : ''; ?> class="mr-2"> Active
            </label>
            <button type="submit" name="edit_module" class="bg-blue-500 text-white px-4 py-2 rounded">Update Module</button>
        </form>
    </div>
</body>

</html>