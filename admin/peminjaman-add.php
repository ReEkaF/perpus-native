<?php

session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

require '../data/jenis_buku.php';
require '../libs/validation.php';
require '../data/buku.php';
require '../data/peminjam.php';
require '../data/peminjaman.php';


$errors = [];
$old_inputs = [
    'peminjam' => '',
    'buku' => '',
];
$book = get_book();
$peminjam = get_peminjam();
$categories = get_categories();
var_dump($_SESSION['admin']);
// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    $buku = $_POST['buku'];
    $peminjam = $_POST['peminjam'];
    // cek apakah tidak ada error
    if (!$errors) {
        create_rent($buku, $peminjam, $_SESSION['admin']);
        header('Location: ./peminjaman.php');
        exit();
    }

    $old_inputs['name'] = htmlspecialchars($_POST['name']);
}

// inisialisasi variabel untuk halaman dan komponen header
$title = 'Tambah Buku';

require 'layouts/header.php';

?>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="./index.php" class="text-black-500 hover:underline">Dashboard </a> >
                <a href="./buku.php" class="text-black-500 hover:underline">Kelola peminjaman ></a>
                <a href="" class="text-black-500 hover:underline"><b>Tambah peminjaman</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Tambah peminjaman</h3>

            <!-- Form untuk menambah kategori -->
            <form action="./peminjaman-add.php" method="post" class="space-y-4">
                    <div>
                    <label for="peminjam" class="block text-sm font-medium text-gray-700">peminjam</label>
                    <select name="peminjam" id="peminjam" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Pilih peminjam</option>
                        <!-- Add the options dynamically, assuming you have an array of available book titles -->
                        <?php foreach ($peminjam as $p):  ?>

                            <option value="<?= htmlspecialchars($p['id_peminjam']) ?>" <?= isset($old_inputs['peminjam']) && $old_inputs['peminjam'] == $p['nama_peminjam'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['nama_peminjam']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                    <div>

                        <div>
                            <label for="buku" class="block text-sm font-medium text-gray-700">buku</label>
                            <select name="buku" id="buku" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled selected>Pilih buku</option>
                                <!-- Add the options dynamically, assuming you have an array of available book titles -->
                                <?php foreach ($book as $b):  ?>

                                    <option value="<?= htmlspecialchars($b['id_buku']) ?>" <?= isset($old_inputs['buku']) && $old_inputs['buku'] == $b['judul_buku'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($b['judul_buku']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (isset($errors['judul_buku'])) : ?>
                            <div class="text-red-500">
                                <?= $errors['judul_buku'] ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex justify-center">
                            <button type="submit" name="submit" class=" py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50">
                                Tambah Buku
                            </button>
                        </div>
            </form>
        </div>
    </div>
</div>


<?php require 'layouts/footer.php'; ?>