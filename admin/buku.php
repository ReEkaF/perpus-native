<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

require '../data/jenis_buku.php';
require '../data/buku.php';

$book = get_book();
$title = 'Buku';
require 'layouts/header.php';

$errors = [];



?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            <nav class="text-sm text-gray-500 mb-4">
                <a href="./index.php" class="text-black-500 hover:underline">Dashboard </a> >
                <a href="" class="text-black-500 hover:underline"><b>Kelola Buku</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Kelola Buku</h3>

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
                <div class="flex-1">
                    <a href="./buku-add.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Buku</a>
                </div>
                <div>
                    <a href="./recap.php" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Recap</a>
                </div>
            </div>


            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Judul Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Pengarang</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Tahun Terbit</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Kategori</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Jumlah Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($book as $i => $b): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700"><?= $i + 1 ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($b['judul_buku']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($b['pengarang']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($b['tahun_terbit']) ?></td>

                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($b['nama_kategori_buku']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($b['stok']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <a href="./buku-edit.php?id_buku=<?= $b['id_buku'] ?>" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Edit</a> |
                                    <a href="./buku-delete.php?id_buku=<?= $b['id_buku'] ?>" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600">Hapus</a>
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