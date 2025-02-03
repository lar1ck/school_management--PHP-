<?php
session_start();
include_once('../backend/config.php'); 

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../frontend/login.html');  
    exit();
}


if (isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO teachers (name, subject, username, password) VALUES ('$name', '$subject', '$username', '$password')";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

if (isset($_POST['edit_teacher'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE teachers SET name = '$name', subject = '$subject', username = '$username', password = '$password' WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Teacher updated successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM teachers WHERE id = '$id'";
    if (mysqli_query($karine_conn, $sql)) {
        echo "Teacher deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($karine_conn);
    }
}

$sql = "SELECT * FROM teachers";
$result = mysqli_query($karine_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 2rem;
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        a[href="../backend/logout.php"], 
        button[onclick="window.history.back()"] {
            position: fixed;
            top: 1rem;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: white;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.9rem;
            color: #7f8c8d;
            z-index: 100;
        }

        a[href="../backend/logout.php"] { right: 1rem; }
        button[onclick="window.history.back()"] { left: 1rem; }

        h1 {
            font-weight: 300;
            margin: 4rem 0 2rem;
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

        input, textarea {
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

        /* Data Table */
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

        /* Action Links */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
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
                margin: 3rem 0 1.5rem;
            }
        }
    </style>
</head>
<body>

<a href="../backend/logout.php">Logout</a>
<a href="dashboard.php">back to dashboard</a>

<h1>Manage Teachers</h1>

<form method="POST">
    <h2>Add New Teacher</h2>
    <label for="name">Name</label>
    <input type="text" name="name" required>
    
    <label for="subject">Subject</label>
    <input type="text" name="subject" required>
    
    <label for="username">Username</label>
    <input type="text" name="username" required>
    
    <label for="password">Password</label>
    <input type="password" name="password" required>
    
    <button type="submit" name="add_teacher">Add Teacher</button>
</form>

<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM teachers WHERE id = '$id'";
    $result = mysqli_query($karine_conn, $sql);
    $teacher = mysqli_fetch_assoc($result);
?>
    <form method="POST">
        <h2>Edit Teacher</h2>
        <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
        
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo $teacher['name']; ?>" required>
        
        <label for="subject">Subject</label>
        <input type="text" name="subject" value="<?php echo $teacher['subject']; ?>" required>
        
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo $teacher['username']; ?>" required>
        
        <label for="password">Password</label>
        <input type="password" name="password" required>
        
        <button type="submit" name="edit_teacher">Update Teacher</button>
    </form>
<?php
}
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject</th>
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
                <a href="?edit=<?php echo $row['id']; ?>">Edit</a> 
                <!-- | -->
                <!-- <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a> -->
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
