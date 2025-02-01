<?php
// admin/manage_teachers.php
session_start();
include_once('../backend/config.php'); // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../frontend/login.html');  // Redirect to login if not admin
    exit();
}

// Handle Add Teacher
if (isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Encrypt password

    $sql = "INSERT INTO teachers (name, subject, username, password) VALUES ('$name', '$subject', '$username', '$password')";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Handle Edit Teacher
if (isset($_POST['edit_teacher'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);  // Encrypt password

    $sql = "UPDATE teachers SET name = '$name', subject = '$subject', username = '$username', password = '$password' WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Teacher updated successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Handle Delete Teacher
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM teachers WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Teacher deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Fetch all teachers for viewing
$sql = "SELECT * FROM teachers";
$result = mysqli_query($karine_conn, $sql);
?>

<h1>Manage Teachers</h1>
<!-- Add Teacher Form -->
<form method="POST" class="mb-6">
    <h2>Add New Teacher</h2>
    <label for="name">Name</label><input type="text" name="name" required class="border p-2" />
    <label for="subject">Subject</label><input type="text" name="subject" required class="border p-2" />
    <label for="username">Username</label><input type="text" name="username" required class="border p-2" />
    <label for="password">Password</label><input type="password" name="password" required class="border p-2" />
    <button type="submit" name="add_teacher" class="bg-blue-500 text-white p-2">Add Teacher</button>
</form>

<!-- Edit Teacher Form (will populate on clicking 'Edit') -->
<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM teachers WHERE id = '$id'";
    $result = mysqli_query($karine_conn, $sql);
    $teacher = mysqli_fetch_assoc($result);
?>
    <form method="POST" class="mb-6">
        <h2>Edit Teacher</h2>
        <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>" />
        <label for="name">Name</label><input type="text" name="name" value="<?php echo $teacher['name']; ?>" required class="border p-2" />
        <label for="subject">Subject</label><input type="text" name="subject" value="<?php echo $teacher['subject']; ?>" required class="border p-2" />
        <label for="username">Username</label><input type="text" name="username" value="<?php echo $teacher['username']; ?>" required class="border p-2" />
        <label for="password">Password</label><input type="password" name="password" value="<?php echo $teacher['password']; ?>" required class="border p-2" />
        <button type="submit" name="edit_teacher" class="bg-blue-500 text-white p-2">Update Teacher</button>
    </form>
<?php
}
?>

<!-- Display all teachers -->
<table class="min-w-full table-auto mt-4">
    <thead><tr><th>ID</th><th>Name</th><th>Subject</th><th>Username</th><th>Actions</th></tr></thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
