<?php
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

require '../data/rent.php';
$rent = get_rent();
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
                <a href="" class="text-black-500 hover:underline"><b>Daftar Peminjaman</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Daftar Peminjaman</h3>

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
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Peminjam</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Judul Buku</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Admin</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">dibuat pada</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rent as $i => $r): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700"><?= $i + 1 ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($r['peminjam_nama']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($r['buku_judul']) ?></td>
                                <td class="px-4 py-2 text-sm 
    <?php
                            // Array untuk warna teks berdasarkan status
                            $statusClass = [
                                0 => 'text-blue-800',  // Untuk status "Rent"
                                1 => 'text-green-800', // Untuk status "Done"
                            ];
                            echo $statusClass[$r['status']] ?? 'text-gray-700'; // Menambahkan warna teks sesuai status, default jika tidak ada status
    ?>
    font-semibold">
                                    <?php
                                    // Array untuk teks status yang sesuai
                                    $statusText = [
                                        0 => 'Rent',
                                        1 => 'Done',
                                    ];
                                    echo $statusText[$r['status']] ?? 'Unknown'; // Menampilkan teks berdasarkan status
                                    ?>
                                </td>

                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($r['created_by']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($r['create_date']) ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <a href="./peminjaman-done.php?id_peminjaman=<?= $r['id_peminjaman'] ?>" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Done</a>
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