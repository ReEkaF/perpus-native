<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                <ul class="pb-2 space-y-2">


                    <li>
                        <a href="./index.php"
                            class="flex items-center p-2 mx-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-house"></i>
                            <span class="ml-3" sidebar-toggle-item>Dashboard</span>
                        </a>

                    </li>
                    <li>
                        <a href="./kategori.php"
                            class="flex items-center p-2 mx-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-list"></i>
                            <span class="ml-3" sidebar-toggle-item>Kategori</span>
                        </a>

                    </li>
                    <li>
                        <a href="./buku.php"
                            class="flex items-center p-2 mx-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-book"></i>
                            <span class="ml-3" sidebar-toggle-item>Buku</span>
                        </a>

                    </li>
                    <li>
                        <a href="./peminjaman.php"
                            class="flex items-center p-2 mx-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-bars"></i>
                            <span class="ml-3" sidebar-toggle-item>Peminjaman</span>
                        </a>

                    </li>
                    <li>
                        <a href="./rent.php"
                            class="flex items-center p-2 mx-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-bookmark"></i>
                            <span class="ml-3" sidebar-toggle-item>Status Pinjam</span>
                        </a>

                    </li>
                    <li>
                        <a href="./logout.php"
                            class="flex items-center p-4 text-base text-gray-900 rounded-lg bg-red-500 hover:bg-red-600 group dark:text-gray-200 dark:bg-red-700 dark:hover:bg-red-600">
                            <i class="fa fa-sign-out-alt mr-3"></i> <!-- Ikon logout Font Awesome -->
                            <span>Logout</span> <!-- Menghilangkan sidebar-toggle-item yang tidak diperlukan -->
                        </a>
                    </li>



                </ul>
            </div>
        </div>
    </div>
</aside>