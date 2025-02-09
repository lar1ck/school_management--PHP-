<?php
session_start();
include_once('../backend/config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'teacher') {
  header('Location: ../backend/login.php');
  exit();
}

$allowedPages = ['marks_entry', 'view_students'];
$currentPage = $_GET['page'] ?? 'marks_entry';
if (!in_array($currentPage, $allowedPages)) {
  $currentPage = 'marks_entry';
}

if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
  include($currentPage . '.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-950 h-screen flex">
  <aside class="bg-gray-900 text-white w-64 p-6 flex flex-col h-screen">
    <a href="?page=marks_entry" class=" flex gap-2 items-center space-y-2 mb-2">
      <img src="../images/1.png" alt="Panel Logo" class="w-12 h-12">
      <h1 class="text-lg font-bold text-white">Teacher</h1>
    </a>
    <nav class="flex flex-col space-y-2">
      <a href="?page=marks_entry" class="py-2 px-4 rounded-lg <?php echo ($currentPage == 'marks_entry' ? 'bg-gray-700' : 'hover:bg-gray-800'); ?>">Dashboard</a>
      <a href="?page=view_students" class="py-2 px-4 rounded-lg <?php echo ($currentPage == 'view_students' ? 'bg-gray-800' : 'hover:bg-gray-800'); ?>">View Students</a>
    </nav>
    <a href="../backend/logout.php" class="mt-auto py-2 px-4 rounded-lg bg-red-600 hover:bg-red-700 text-center">Logout</a>
  </aside>

  <main class="flex-1 p-6">
    <div class="bg-gray-900 p-6 rounded-lg shadow-lg">
      <?php include($currentPage . '.php'); ?>
    </div>
  </main>

  <script>
    document.querySelectorAll('nav a').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('nav a').forEach(nav => nav.classList.remove('bg-gray-800'));
        this.classList.add('bg-gray-800');

        fetch(this.href + '&ajax=1')
          .then(response => response.text())
          .then(data => {
            document.querySelector('main div').innerHTML = data;
            history.pushState(null, '', this.href);
          })
          .catch(error => console.error('Error:', error));
      });
    });
  </script>
</body>

</html>