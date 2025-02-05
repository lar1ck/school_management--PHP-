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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="flex bg-gray-100">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 ml-64 p-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="management-content">
                <?php include($currentPage . '.php'); ?>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('bg-blue-600', 'text-white'));
                this.classList.add('bg-blue-600', 'text-white');

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
                        nav.classList.remove('bg-blue-600', 'text-white');
                        if (nav.href.includes(page)) {
                            nav.classList.add('bg-blue-600', 'text-white');
                        }
                    });
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
