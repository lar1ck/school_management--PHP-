<?php
// admin/manage_modules.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../frontend/login.html');  // Redirect to login if not admin
    exit();
}

// Handle Add Module
if (isset($_POST['add_module'])) {
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $sql = "INSERT INTO modules (module_name, description, parent_module_id, is_active) VALUES ('$module_name', '$description', '$parent_module_id', '$is_active')";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Module added successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Handle Edit Module
if (isset($_POST['edit_module'])) {
    $id = $_POST['id'];
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $sql = "UPDATE modules SET module_name = '$module_name', description = '$description', parent_module_id = '$parent_module_id', is_active = '$is_active' WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Module updated successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Handle Delete Module
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM modules WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Module deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Fetch all modules for viewing
$sql = "SELECT * FROM modules";
$result = mysqli_query($karine_conn, $sql);
?>

<h1>Manage Modules</h1>
<!-- Add Module Form -->
<form method="POST" class="mb-6">
    <h2>Add New Module</h2>
    <label for="module_name">Module Name</label><input type="text" name="module_name" required class="border p-2" />
    <label for="description">Description</label><textarea name="description" class="border p-2"></textarea>
    <label for="parent_module_id">Parent Module (optional)</label><input type="text" name="parent_module_id" class="border p-2" />
    <label for="is_active">Active</label><input type="checkbox" name="is_active" checked />
    <button type="submit" name="add_module" class="bg-blue-500 text-white p-2">Add Module</button>
</form>
<a href="../backend/login.php">logout</a>


<!-- Edit Module Form (will populate on clicking 'Edit') -->
<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM modules WHERE id = '$id'";
    $result = mysqli_query($karine_conn, $sql);
    $module = mysqli_fetch_assoc($result);
?>
    <form method="POST" class="mb-6">
        <h2>Edit Module</h2>
        <input type="hidden" name="id" value="<?php echo $module['id']; ?>" />
        <label for="module_name">Module Name</label><input type="text" name="module_name" value="<?php echo $module['module_name']; ?>" required class="border p-2" />
        <label for="description">Description</label><textarea name="description" class="border p-2"><?php echo $module['description']; ?></textarea>
        <label for="parent_module_id">Parent Module</label><input type="text" name="parent_module_id" value="<?php echo $module['parent_module_id']; ?>" class="border p-2" />
        <label for="is_active">Active</label><input type="checkbox" name="is_active" <?php echo $module['is_active'] ? 'checked' : ''; ?> />
        <button type="submit" name="edit_module" class="bg-blue-500 text-white p-2">Update Module</button>
    </form>
    <a href="../backend/login.php">logout</a>

<?php
}
?>

<!-- Display all modules -->
<table class="min-w-full table-auto mt-4">
    <thead><tr><th>ID</th><th>Module Name</th><th>Description</th><th>Active</th><th>Actions</th></tr></thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['module_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['is_active'] ? 'Yes' : 'No'; ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
    
</table>
<a href="../backend/login.php">logout</a>
