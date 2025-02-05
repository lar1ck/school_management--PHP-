<?php
session_start();
include_once('../backend/config.php');

if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../backend/login.php');
    exit();
}

define('IN_DASHBOARD', true);

$allowedPages = ['manage_students', 'manage_teachers', 'manage_modules'];
$currentPage = $_GET['page'] ?? 'manage_students'; 

if (!in_array($currentPage, $allowedPages)) {
    $currentPage = 'manage_students';
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
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      min-height: 100vh;
      display: flex;
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 250px;
      background: white;
      border-right: 1px solid #e0e0e0;
      padding: 2rem;
      position: fixed;
      height: 100%;
    }
    .content-area {
      flex: 1;
      margin-left: 250px;
      padding: 2rem;
    }
    .nav-link {
      display: block;
      padding: 0.75rem 1rem;
      margin: 0.5rem 0;
      border-radius: 6px;
      color: #2c3e50;
      text-decoration: none;
      transition: all 0.2s;
    }
    .nav-link:hover {
      background-color: #f0f0f0;
    }
    .nav-link.active {
      background-color: #3498db;
      color: white;
    }
    .management-content {
      animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    .logout-btn {
      display: block;
      margin-top: 2rem;
      text-decoration: none;
      color: #c62828;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h1>Admin Panel</h1>
    <nav>
      <a href="?page=manage_students" class="nav-link <?= $currentPage === 'manage_students' ? 'active' : '' ?>">Students</a>
      <a href="?page=manage_teachers" class="nav-link <?= $currentPage === 'manage_teachers' ? 'active' : '' ?>">Teachers</a>
      <a href="?page=manage_modules" class="nav-link <?= $currentPage === 'manage_modules' ? 'active' : '' ?>">Modules</a>
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

        document.querySelectorAll('.nav-link').forEach(nav => {
          nav.classList.remove('active');
        });
        this.classList.add('active');

        const url = this.getAttribute('href') + '&ajax=1';

        fetch(url)
          .then(response => response.text())
          .then(data => {
            document.querySelector('.management-content').innerHTML = data;
            history.pushState(null, '', this.getAttribute('href'));
          })
          .catch(error => console.error('Error:', error));
      });
    });

    window.addEventListener('popstate', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const page = urlParams.get('page') || 'manage_students';
      const ajaxUrl = `?page=${page}&ajax=1`;
      
      fetch(ajaxUrl)
        .then(response => response.text())
        .then(data => {
          document.querySelector('.management-content').innerHTML = data;
          document.querySelectorAll('.nav-link').forEach(nav => {
            nav.classList.remove('active');
            if (nav.href.includes(page)) {
              nav.classList.add('active');
            }
          });
        });
    });
  </script>
</body>
</html>
