<nav class="bg-gray-900 text-white fixed w-full top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <a href="dashboard.php" class="flex items-center gap-2">
                <img src="../images/1.png" alt="Admin Panel Logo" class="w-10 h-10">
                <h1 class="text-lg font-bold">Admin</h1>
            </a>
            <div class="hidden md:flex space-x-4">
                <a href="dashboard.php" class="px-4 py-2 rounded-md transition-colors <?= $currentPage === 'dashboard' ? 'bg-blue-600' : 'hover:bg-gray-800' ?>">
                    <i class="bi bi-grid-1x2-fill mr-2"></i> Dashboard
                </a>
                <a href="list_students.php" class="px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_students' ? 'bg-blue-600' : 'hover:bg-gray-800' ?>">
                    <i class="bi bi-person-lines-fill mr-2"></i> Students
                </a>
                <a href="list_teachers.php" class="px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_teachers' ? 'bg-blue-600' : 'hover:bg-gray-800' ?>">
                    <i class="bi bi-people-fill mr-2"></i> Teachers
                </a>
                <a href="list_modules.php" class="px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_modules' ? 'bg-blue-600' : 'hover:bg-gray-800' ?>">
                    <i class="bi bi-book-fill mr-2"></i> Modules
                </a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
            <a href="../backend/logout.php" class="text-red-500 font-semibold hover:underline ml-4">
                <i class="bi bi-box-arrow-right mr-2"></i> Logout
            </a>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-gray-800 text-white p-4 space-y-2">
        <a href="dashboard.php" class="block py-2 px-4 rounded-md <?= $currentPage === 'dashboard' ? 'bg-blue-600' : 'hover:bg-gray-700' ?>">
            <i class="bi bi-grid-1x2-fill mr-2"></i> Dashboard
        </a>
        <a href="list_students.php" class="block py-2 px-4 rounded-md <?= $currentPage === 'manage_students' ? 'bg-blue-600' : 'hover:bg-gray-700' ?>">
            <i class="bi bi-person-lines-fill mr-2"></i> Students
        </a>
        <a href="list_teachers.php" class="block py-2 px-4 rounded-md <?= $currentPage === 'manage_teachers' ? 'bg-blue-600' : 'hover:bg-gray-700' ?>">
            <i class="bi bi-people-fill mr-2"></i> Teachers
        </a>
        <a href="list_modules.php" class="block py-2 px-4 rounded-md <?= $currentPage === 'manage_modules' ? 'bg-blue-600' : 'hover:bg-gray-700' ?>">
            <i class="bi bi-book-fill mr-2"></i> Modules
        </a>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>