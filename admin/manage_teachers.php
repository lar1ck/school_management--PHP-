<!-- list_teachers.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Teachers</title>
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
    
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-center mb-4">List of Teachers</h1>
        <a href="create_teacher.php" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Teacher</a>
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
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

<!-- edit_teacher.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = mysqli_query($happy_conn, "SELECT * FROM happy__tblteachers WHERE id = $id");
        $teacher = mysqli_fetch_assoc($result);
    }
    
    if (isset($_POST['edit_teacher'])) {
        $name = htmlspecialchars($_POST['name']);
        $subject = htmlspecialchars($_POST['subject']);
        $username = htmlspecialchars($_POST['username']);
        
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $happy_conn->prepare("UPDATE happy__tblteachers SET name=?, subject=?, username=?, password=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $subject, $username, $password, $id);
        } else {
            $stmt = $happy_conn->prepare("UPDATE happy__tblteachers SET name=?, subject=?, username=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $subject, $username, $id);
        }
        $stmt->execute();
        header("Location: list_teachers.php");
        exit();
    }
    ?>
    
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-center mb-4">Edit Teacher</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required class="w-full p-2 border rounded">
            <label class="block">Subject</label>
            <input type="text" name="subject" value="<?php echo htmlspecialchars($teacher['subject']); ?>" required class="w-full p-2 border rounded">
            <label class="block">Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($teacher['username']); ?>" required class="w-full p-2 border rounded">
            <label class="block">Password (Leave empty to keep current password)</label>
            <input type="password" name="password" class="w-full p-2 border rounded">
            <button type="submit" name="edit_teacher" class="bg-blue-500 text-white px-4 py-2 rounded">Update Teacher</button>
        </form>
    </div>
</body>
</html>

<!-- delete_teacher.php -->
<?php
session_start();
$happy_conn = mysqli_connect("localhost", "root", "", "happy_db");
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $happy_conn->prepare("DELETE FROM happy__tblteachers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: list_teachers.php");
    exit();
}
?>



<!-- list_teachers.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Teachers</title>
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
    
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-center mb-4">List of Teachers</h1>
        <a href="create_teacher.php" class="bg-blue-500 text-white px-4 py-2 rounded">Add Teacher</a>
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Module</th>
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

<!-- create_teacher.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
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
    
    $result_modules = mysqli_query($happy_conn, "SELECT * FROM happy__tblmodules WHERE is_active = 1");

    if (isset($_POST['add_teacher'])) {
        $name = htmlspecialchars($_POST['name']);
        $subject = htmlspecialchars($_POST['subject']);
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $stmt = $happy_conn->prepare("INSERT INTO happy__tblteachers (name, subject, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $subject, $username, $password);
        $stmt->execute();
        header("Location: list_teachers.php");
        exit();
    }
    ?>
    
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-center mb-4">Add New Teacher</h1>
        <form method="POST" class="space-y-4">
            <label class="block">Name</label>
            <input type="text" name="name" required class="w-full p-2 border rounded">
            <label class="block">Module</label>
            <select name="subject" required class="w-full p-2 border rounded">
                <option value="">Select Module</option>
                <?php while ($module = mysqli_fetch_assoc($result_modules)) { ?>
                    <option value="<?php echo $module['module_name']; ?>">
                        <?php echo $module['module_name']; ?>
                    </option>
                <?php } ?>
            </select>
            <label class="block">Username</label>
            <input type="text" name="username" required class="w-full p-2 border rounded">
            <label class="block">Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded">
            <button type="submit" name="add_teacher" class="bg-blue-500 text-white px-4 py-2 rounded">Add Teacher</button>
        </form>
    </div>
</body>
</html>
