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
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background-color: #f0f2f5;
      min-height: 100vh;
      display: flex;
    }
    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      padding: 20px;
      color: white;
      height: 100vh;
      position: fixed;
    }
    .sidebar h1 {
      font-size: 1.5em;
      margin-bottom: 20px;
    }
    .nav-link {
      display: block;
      padding: 10px 15px;
      margin: 5px 0;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }
    .nav-link:hover {
      background-color: #34495e;
    }
    .nav-link.active {
      background-color: #3498db;
    }
    .content-area {
      margin-left: 250px;
      width: calc(100% - 250px);
      padding: 20px;
    }
    .logout-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 8px 12px;
      background-color: #e74c3c;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h1>Teacher Portal</h1>
    <nav>
      <a href="?page=marks_entry" class="nav-link <?php echo ($currentPage == 'marks_entry' ? 'active' : ''); ?>">Dashboard</a>
      <a href="?page=view_students" class="nav-link <?php echo ($currentPage == 'view_students' ? 'active' : ''); ?>">View Students</a>
    </nav>
    <a href="../backend/logout.php" class="logout-btn">Logout</a>
  </div>

  <div class="content-area">
    <div class="management-content">
      <?php include($currentPage . '.php'); ?>
    </div>
  </div>

  <script>
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');

        const url = this.href + '&ajax=1';
        fetch(url)
          .then(response => response.text())
          .then(data => {
            document.querySelector('.management-content').innerHTML = data;
            history.pushState(null, '', this.href);
          })
          .catch(error => console.error('Error:', error));
      });
    });

    window.addEventListener('popstate', function() {
      const params = new URLSearchParams(window.location.search);
      const page = params.get('page') || 'marks_entry';
      const ajaxUrl = '?page=' + page + '&ajax=1';
      fetch(ajaxUrl)
          .then(response => response.text())
          .then(data => {
              document.querySelector('.management-content').innerHTML = data;
              document.querySelectorAll('.nav-link').forEach(nav => {
                  nav.classList.remove('active');
                  if (nav.href.includes('page=' + page)) {
                      nav.classList.add('active');
                  }
              });
          });
    });
  </script>
</body>
</html>
