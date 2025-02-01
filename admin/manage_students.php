<?php
// admin/manage_students.php
session_start();
include_once('../backend/config.php');  // Include database connection

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../frontend/login.html');  // Redirect to login if not admin
    exit();
}

// Handle Add Student
if (isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $other_details = $_POST['other_details'];
    $password = $_POST['password'];  // Get the password input

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert student data into the database, including the hashed password
    $sql = "INSERT INTO students (name, student_id, class, other_details, password) 
            VALUES ('$name', '$student_id', '$class', '$other_details', '$hashed_password')";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Handle Edit Student
if (isset($_POST['edit_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $other_details = $_POST['other_details'];
    $password = $_POST['password'];  // Get the password input (optional)

    // If a new password is provided, hash it and update the password
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE students SET name = '$name', student_id = '$student_id', class = '$class', other_details = '$other_details', password = '$hashed_password' WHERE id = '$id'";
    } else {
        $sql = "UPDATE students SET name = '$name', student_id = '$student_id', class = '$class', other_details = '$other_details' WHERE id = '$id'";
    }

    if (mysqli_query($karine_conn, $sql)) {
        echo "Student updated successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Handle Delete Student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM students WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Student deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

// Fetch all students for viewing
$sql = "SELECT * FROM students";
$result = mysqli_query($karine_conn, $sql);
?>

<h1>Manage Students</h1>

<!-- Add Student Form -->
<form method="POST" class="mb-6">
    <h2>Add New Student</h2>
    <label for="name">Name</label><input type="text" name="name" required class="border p-2" />
    <label for="student_id">Student ID</label><input type="text" name="student_id" required class="border p-2" />
    <label for="class">Class</label><input type="text" name="class" required class="border p-2" />
    <label for="other_details">Other Details</label><textarea name="other_details" class="border p-2"></textarea>
    <label for="password">Password</label><input type="password" name="password" required class="border p-2" />  <!-- New password field -->
    <button type="submit" name="add_student" class="bg-blue-500 text-white p-2">Add Student</button>
</form>

<!-- Edit Student Form (will populate on clicking 'Edit') -->
<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM students WHERE id = '$id'";
    $result = mysqli_query($karine_conn, $sql);
    $student = mysqli_fetch_assoc($result);
?>
    <form method="POST" class="mb-6">
        <h2>Edit Student</h2>
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>" />
        <label for="name">Name</label><input type="text" name="name" value="<?php echo $student['name']; ?>" required class="border p-2" />
        <label for="student_id">Student ID</label><input type="text" name="student_id" value="<?php echo $student['student_id']; ?>" required class="border p-2" />
        <label for="class">Class</label><input type="text" name="class" value="<?php echo $student['class']; ?>" required class="border p-2" />
        <label for="other_details">Other Details</label><textarea name="other_details" class="border p-2"><?php echo $student['other_details']; ?></textarea>
        <label for="password">Password (Leave empty if you don't want to change)</label><input type="password" name="password" class="border p-2" />  <!-- Password field for editing -->
        <button type="submit" name="edit_student" class="bg-blue-500 text-white p-2">Update Student</button>
    </form>
<?php
}
?>

<!-- Display all students -->
<table class="min-w-full table-auto mt-4">
    <thead><tr><th>ID</th><th>Name</th><th>Student ID</th><th>Class</th><th>Actions</th></tr></thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
