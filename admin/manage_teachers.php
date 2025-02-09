<?php 
if (!defined('IN_DASHBOARD')) {
    die('Access denied.');
}

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');  
    exit();
}

// Fetch all active modules from the modules table
$sql_modules = "SELECT * FROM happy__tblmodules WHERE is_active = 1";
$result_modules = mysqli_query($happy_conn, $sql_modules);

if (isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    // Instead of a free-text subject, we now take the selected module
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO happy__tblteachers (name, subject, username, password) VALUES ('$name', '$subject', '$username', '$password')";
    if (mysqli_query($happy_conn, $sql)) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . mysqli_error($happy_conn);
    }
}

if (isset($_POST['edit_teacher'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    // Use the selected module from the dropdown
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    
    // If password is provided, update it; otherwise, leave it unchanged.
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE happy__tblteachers SET name = '$name', subject = '$subject', username = '$username', password = '$password' WHERE id = '$id'";
    } else {
        $sql = "UPDATE happy__tblteachers SET name = '$name', subject = '$subject', username = '$username' WHERE id = '$id'";
    }
    
    if (mysqli_query($happy_conn, $sql)) {
        echo "Teacher updated successfully!";
    } else {
        echo "Error: " . mysqli_error($happy_conn);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM happy__tblteachers WHERE id = '$id'";
    if (mysqli_query($happy_conn, $sql)) {
        echo "Teacher deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($happy_conn);
    }
}

$sql = "SELECT * FROM happy__tblteachers";
$result = mysqli_query($happy_conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
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
        margin: 2rem 0;
      }
    }
  </style>
  <h1>Manage Teachers</h1>

  <!-- Add Teacher Form -->
  <form method="POST">
    <h2>Add New Teacher</h2>
    <label for="name">Name</label>
    <input type="text" name="name" required>
    
    <label for="subject">Module</label>
    <select name="subject" required>
      <option value="">Select Module</option>
      <?php while ($module = mysqli_fetch_assoc($result_modules)) { ?>
        <option value="<?php echo $module['module_name']; ?>">
          <?php echo $module['module_name']; ?>
        </option>
      <?php } ?>
    </select>
    
    <label for="username">Username</label>
    <input type="text" name="username" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" required>
    
    <button type="submit" name="add_teacher">Add Teacher</button>
  </form>

  <!-- Edit Teacher Form -->
  <?php
  if (isset($_GET['edit'])) {
      $id = $_GET['edit'];
      $sql = "SELECT * FROM happy__tblteachers WHERE id = '$id'";
      $resultEdit = mysqli_query($happy_conn, $sql);
      $teacher = mysqli_fetch_assoc($resultEdit);
      if (!$teacher) {
          echo "Teacher not found.";
      } else {
  ?>
    <form method="POST">
      <h2>Edit Teacher</h2>
      <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
      
      <label for="name">Name</label>
      <input type="text" name="name" value="<?php echo $teacher['name']; ?>" required>
      
      <label for="subject">Module</label>
      <select name="subject" required>
        <option value="">Select Module</option>
        <?php 
        // Reuse the same modules result; if needed, re-query for fresh result
        $result_modules = mysqli_query($happy_conn, $sql_modules);
        while ($module = mysqli_fetch_assoc($result_modules)) { ?>
          <option value="<?php echo $module['module_name']; ?>" <?php if($teacher['subject'] == $module['module_name']) echo 'selected'; ?>>
            <?php echo $module['module_name']; ?>
          </option>
        <?php } ?>
      </select>
      
      <label for="username">Username</label>
      <input type="text" name="username" value="<?php echo $teacher['username']; ?>" required>
      
      <label for="password">Password (Leave empty to keep unchanged)</label>
      <input type="password" name="password">
      
      <button type="submit" name="edit_teacher">Update Teacher</button>
    </form>
  <?php
      }
  } 
  ?>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Module</th>
        <th>Username</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['subject']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td>
          <a href="?page=manage_teachers&edit=<?php echo $row['id']; ?>">Edit</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>