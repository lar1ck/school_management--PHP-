<aside class="w-64 h-screen bg-white border-r border-gray-200 p-4 fixed">
    <div class=" flex gap-2 items-center">
    <img src="../images/1.png" alt="Admin Panel Logo" class="w-12 h-12">
    <h1 class="text-lg font-bold ">School management</h1>
    </div>
    <nav class="space-y-2">
        <a href="?page=manage_students" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_students' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
            <i class="bi bi-person-lines-fill mr-2"></i> Students
        </a>
        <a href="?page=manage_teachers" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_teachers' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
            <i class="bi bi-people-fill mr-2"></i> Teachers
        </a>
        <a href="?page=manage_modules" class="flex items-center px-4 py-2 rounded-md transition-colors <?= $currentPage === 'manage_modules' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
            <i class="bi bi-book-fill mr-2"></i> Modules
        </a>
    </nav>
    <a href="../backend/logout.php" class="flex items-center mt-6 text-red-600 font-semibold hover:underline">
        <i class="bi bi-box-arrow-right mr-2"></i> Logout
    </a>
</aside>
