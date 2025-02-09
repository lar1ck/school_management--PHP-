<aside class="w-64 h-screen bg-gray-900 border-r border-gray-200 p-4 fixed">
    <a href="dashboard.php" class=" flex gap-2 items-center  mb-2">
        <img src="../images/1.png" alt="Admin Panel Logo" class="w-12 h-12">
        <h1 class="text-lg font-bold ">Admin</h1>
    </a>
    <nav class="space-y-2 text-white">
        <a href="dashboard.php" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_students' ? 'bg-blue-600 text-white' : 'text-white hover:bg-gray-950' ?>">
            <i class="bi bi-grid-1x2-fill mr-2"></i> Dashboard
        </a>
        <a href="list_students.php" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_students' ? 'bg-blue-600 text-white' : 'text-white hover:bg-gray-950' ?>">
            <i class="bi bi-person-lines-fill mr-2"></i> Students
        </a>
        <a href="list_teachers.php" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_teachers' ? 'bg-blue-600 text-white' : 'text-white hover:bg-gray-950' ?>">
            <i class="bi bi-people-fill mr-2"></i> Teachers
        </a>
        <a href="list_modules.php" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_modules' ? 'bg-blue-600 text-white' : 'text-white hover:bg-gray-950' ?>">
            <i class="bi bi-book-fill mr-2"></i> Modules
        </a>
    </nav>
    <a href="../backend/logout.php" class="flex items-center mt-6 text-red-600 font-semibold hover:underline">
        <i class="bi bi-box-arrow-right mr-2"></i> Logout
    </a>
</aside>