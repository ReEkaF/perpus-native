<?php

require '../data/peminjaman.php';
$peminjaman = get_peminjaman();
$title = 'Peminjaman';
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
                <a href="" class="text-black-500 hover:underline"><b>Kelola Peminjaman</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Kelola Peminjaman</h3>

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
                    <a href="./peminjaman-add.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah Peminjaman</a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Peminjam</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Judul Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Admin</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">dibuat pada</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">terakhir di update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peminjaman as $i => $p): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700"><?= $i + 1 ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($p['peminjam_name']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($p['buku_title']) ?></td>
                                <td class="px-4 py-2 text-sm 
    <?php
                            // Array untuk warna teks berdasarkan status
                            $statusClass = [
                                0 => 'text-blue-800',  // Untuk status "Rent"
                                1 => 'text-green-800', // Untuk status "Done"
                                3 => 'text-red-800',   // Untuk status "Late"
                            ];
                            echo $statusClass[$p['status']] ?? 'text-gray-700'; // Menambahkan warna teks sesuai status, default jika tidak ada status
    ?>
    font-semibold">
                                    <?php
                                    // Array untuk teks status yang sesuai
                                    $statusText = [
                                        0 => 'Rent',
                                        1 => 'Done',
                                        3 => 'Late',
                                    ];
                                    echo $statusText[$p['status']] ?? 'Unknown'; // Menampilkan teks berdasarkan status
                                    ?>
                                </td>

                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($p['admin_name']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($p['create_date']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= !empty($p['update_date']) ? htmlspecialchars($p['update_date']) : '' ?></td>

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