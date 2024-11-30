<?php
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}
require '../data/peminjaman.php';
require '../data/recap.php';

$title = 'Peminjaman';
require 'layouts/header.php';
$recap=recap();
$errors = [];

// Check if there are errors passed via query parameters
if (isset($_GET['error']) && !empty($_GET['error'])) {
    $errors[] = $_GET['error'];
}

?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            <nav class="text-sm text-gray-500 mb-4">
                <a href="./index.php" class="text-black-500 hover:underline">Dashboard </a> >
                <a href="" class="text-black-500 hover:underline"><b>Recap</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Recap</h3>

            <!-- Display error messages -->
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 text-red-600 p-4 mb-4 rounded-md">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total Judul Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Buku terpakai</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Buku tersisa</th>

                        </tr>
                    </thead>
                    <tbody>

                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700"><?= 1 ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($recap['TotalBuku']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($recap['TotalStok']) ?></td>

                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($recap['StokTerpakai']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($recap['StokTersisa']) ?></td>
                                
                            </tr>
                    </tbody>
                </table>
            </div>
            <!-- End of Table Section -->

        </div>
    </div>
</div>

<?php require 'layouts/footer.php'; ?>