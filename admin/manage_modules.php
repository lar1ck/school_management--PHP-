<?php
if (!defined('IN_DASHBOARD')) {
    die('Access denied.');
}

if (isset($_POST['add_module'])) {
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    try {
        $check_sql = "SELECT id FROM happy__tblmodules WHERE module_name = ?";
        $stmt = $happy_conn->prepare($check_sql);
        $stmt->bind_param("s", $module_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Error: A module with the name '$module_name' already exists.";
        } else {
            $insert_sql = "INSERT INTO happy__tblmodules (module_name, description, parent_module_id, is_active) VALUES (?, ?, ?, ?)";
            $stmt = $happy_conn->prepare($insert_sql);
            $stmt->bind_param("sssi", $module_name, $description, $parent_module_id, $is_active);

            if ($stmt->execute()) {
                $success_message = "Module added successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) { 
            $error_message = "Error: A module with the name '$module_name' already exists.";
        } else {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}

if (isset($_POST['edit_module'])) {
    $id = $_POST['id'];
    $module_name = $_POST['module_name'];
    $description = $_POST['description'];
    $parent_module_id = $_POST['parent_module_id'] ?? NULL;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    try {
        $check_sql = "SELECT id FROM happy__tblmodules WHERE module_name = ? AND id != ?";
        $stmt = $happy_conn->prepare($check_sql);
        $stmt->bind_param("si", $module_name, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Error: A module with the name '$module_name' already exists.";
        } else {
            $update_sql = "UPDATE happy__tblmodules SET module_name = ?, description = ?, parent_module_id = ?, is_active = ? WHERE id = ?";
            $stmt = $happy_conn->prepare($update_sql);
            $stmt->bind_param("sssii", $module_name, $description, $parent_module_id, $is_active, $id);

            if ($stmt->execute()) {
                $success_message = "Module updated successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) { 
            $error_message = "Error: A module with the name '$module_name' already exists.";
        } else {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM happy__tblmodules WHERE id = '$id'";
    if (mysqli_query($happy_conn, $sql)) {
        echo "Module deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($happy_conn);
    }
}

$sql = "SELECT * FROM happy__tblmodules";
$result = mysqli_query($happy_conn, $sql);
?>

<div class="management-section">
  <style>
    .management-section {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      line-height: 1.6;
      padding: 2rem;
      background-color: #f8f9fa;
      color: #2c3e50;
    }
    h1 {
      font-weight: 300;
      margin: 2rem 0;
      text-align: center;
      font-size: 2.25rem;
    }
    form {
      background: white;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 2rem;
      margin: 2rem auto;
      max-width: 600px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    form h2 {
      margin: 0 0 1.5rem;
      font-weight: 400;
      color: #7f8c8d;
      font-size: 1.25rem;
    }
    label {
      display: block;
      margin: 1rem 0 0.5rem;
      color: #95a5a6;
      font-size: 0.9rem;
    }
    input, textarea, select {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #e0e0e0;
      border-radius: 4px;
      margin-bottom: 1rem;
      box-sizing: border-box;
      font-size: 1rem;
    }
    input[type="checkbox"] {
      width: auto;
      margin: 0 0.5rem 0 0;
    }
    button[type="submit"] {
      background: #3498db;
      color: white;
      border: none;
      padding: 0.8rem 1.5rem;
      margin-top: 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: opacity 0.2s;
      width: 100%;
    }
    button[type="submit"]:hover {
      opacity: 0.9;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      margin: 2rem 0;
      overflow: hidden;
    }
    th, td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #f0f0f0;
    }
    th {
      background-color: #f8f9fa;
      color: #7f8c8d;
      font-weight: 500;
    }
    tr:hover {
      background-color: #fafafa;
    }
    .status {
      display: inline-block;
      padding: 0.25rem 0.5rem;
      border-radius: 12px;
      font-size: 0.8rem;
    }
    .status-active {
      background: #e8f5e9;
      color: #2e7d32;
    }
    .status-inactive {
      background: #ffebee;
      color: #c62828;
    }
    td a {
      color: #3498db;
      padding: 0.25rem 0.5rem;
      margin: 0 0.25rem;
      border-radius: 4px;
      transition: background 0.2s;
    }
    td a:hover {
      background: #f0f0f0;
    }
    @media (max-width: 768px) {
      .management-section {
        padding: 1rem;
      }
      table {
        display: block;
        overflow-x: auto;
      }
      form {
        padding: 1.5rem;
        margin: 1rem 0;
      }
      h1 {
        font-size: 1.75rem;
        margin: 2rem 0 1.5rem;
      }
    }
    .message {
      padding: 1rem;
      margin: 1rem 0;
      border-radius: 4px;
    }
    .success {
      background-color: #e8f5e9;
      color: #2e7d32;
    }
    .error {
      background-color: #ffebee;
      color: #c62828;
    }
  </style>

  <h1>Manage Modules</h1>
  <?php if (isset($success_message)): ?>
    <div class="message success"><?php echo $success_message; ?></div>
  <?php endif; ?>

  <?php if (isset($error_message)): ?>
    <div class="message error"><?php echo $error_message; ?></div>
  <?php endif; ?>

  <form method="POST">
    <h2>Add New Module</h2>
    <label for="module_name">Module Name</label>
    <input type="text" name="module_name" required>
    
    <label for="description">Description</label>
    <textarea name="description" rows="4"></textarea>
    
    <label for="parent_module_id">Parent Module (optional)</label>
    <select name="parent_module_id">
      <option value="">-- Select Parent Module --</option>
      <?php
      $parentModules = mysqli_query($happy_conn, "SELECT id, module_name FROM happy__tblmodules WHERE parent_module_id IS NULL");
      while ($module = mysqli_fetch_assoc($parentModules)) {
          echo "<option value='{$module['id']}'>{$module['module_name']}</option>";
      }
      ?>
    </select>
    
    <label>
      <input type="checkbox" name="is_active" checked>
      Active
    </label>
    
    <button type="submit" name="add_module">Add Module</button>
  </form>

  <?php if (isset($_GET['edit'])) { 
      $id = $_GET['edit'];
      $sql = "SELECT * FROM happy__tblmodules WHERE id = '$id'";
      $result = mysqli_query($happy_conn, $sql);
      $module = mysqli_fetch_assoc($result);
  ?>
    <form method="POST">
      <h2>Edit Module</h2>
      <input type="hidden" name="id" value="<?php echo $module['id']; ?>">
      
      <label for="module_name">Module Name</label>
      <input type="text" name="module_name" value="<?php echo $module['module_name']; ?>" required>
      
      <label for="description">Description</label>
      <textarea name="description" rows="4"><?php echo $module['description']; ?></textarea>
      
      <label for="parent_module_id">Parent Module</label>
      <select name="parent_module_id">
        <option value="">-- Select Parent Module --</option>
        <?php
        $parentModules = mysqli_query($happy_conn, "SELECT id, module_name FROM happy__tblmodules WHERE parent_module_id IS NULL AND id != {$module['id']}");
        while ($parent = mysqli_fetch_assoc($parentModules)) {
            $selected = $parent['id'] == $module['parent_module_id'] ? 'selected' : '';
            echo "<option value='{$parent['id']}' $selected>{$parent['module_name']}</option>";
        }
        ?>
      </select>
      
      <label>
        <input type="checkbox" name="is_active" <?php echo $module['is_active'] ? 'checked' : ''; ?>>
        Active
      </label>
      
      <button type="submit" name="edit_module">Update Module</button>
    </form>
  <?php } ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Module Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      mysqli_data_seek($result, 0); 
      while ($row = mysqli_fetch_assoc($result)) { 
          $statusClass = $row['is_active'] ? 'status-active' : 'status-inactive';
          $statusText = $row['is_active'] ? 'Active' : 'Inactive';
      ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['module_name']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><span class="status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
        <td>
        <a href="?page=manage_modules&edit=<?php echo $row['id']; ?>">Edit</a>
          <!-- Delete link (if needed) -->
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php
// create_module.php
require 'db_connect.php';

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

<?php
// edit_module.php
require 'db_connect.php';

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
    <div class="max-w-3xl mx-auto bg-gray-900 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-center mb-4">Edit Module</h1>
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
