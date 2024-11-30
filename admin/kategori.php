<?php
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

require '../data/jenis_buku.php';
require '../data/buku.php';

$categories = get_categories();

$title = 'Kategori';
require 'layouts/header.php';

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
                <a href="" class="text-black-500 hover:underline"><b>Kelola Kategori Buku</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Kelola Kategori Buku</h3>
            
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

            <div class="mb-4 flex justify-between items-center">
                <div>
                    <a href="./kategori-add.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Kategori Buku</a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Kategori</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Jumlah Judul Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $categories as $i => $cat): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $i + 1 ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($cat['nama_kategori_buku']) ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= count_related_book($cat['id_kategori_buku'])['count_related_books'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                <a href="./kategori-edit.php?id_kategori_buku=<?= $cat['id_kategori_buku']?>" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Edit</a> | 
                                <a href="./kategori-delete.php?id_kategori_buku=<?= $cat['id_kategori_buku']?>" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- End of Table Section -->

        </div>
    </div>
</div>

<?php require 'layouts/footer.php'; ?>
