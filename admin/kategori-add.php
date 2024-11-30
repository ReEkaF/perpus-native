<?php
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

require '../data/jenis_buku.php';
require '../libs/validation.php';

$errors = [];
$old_inputs = [
    'name' => '',
];


// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    validate_name($errors, $_POST, 'name');
    // cek apakah tidak ada error
    if (!$errors) {
        save_category($_POST);
        header('Location: ./kategori.php');
        exit();
    }

    $old_inputs['name'] = htmlspecialchars($_POST['name']);
}

// inisialisasi variabel untuk halaman dan komponen header
$title = 'Tambah Kategori';

require 'layouts/header.php';

?>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="./index.php" class="text-black-500 hover:underline">Dashboard </a> >
                <a href="./kategori.php" class="text-black-500 hover:underline">Kelola Kategori Buku ></a>
                <a href="" class="text-black-500 hover:underline"><b>Tambah Kategori Buku</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Tambah Kategori Buku</h3>

            <!-- Form untuk menambah kategori -->
            <form action="./kategori-add.php" method="post" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Masukkan nama kategori buku" value="<?= $old_inputs['name'] ?>">
                </div>
                <?php if (isset($errors['name'])) : ?>
                    <div class="text-red-500">
                        <?= $errors['name'] ?>
                    </div>
                <?php endif; ?>

                <div class="flex justify-center">
                    <button type="submit" name="submit" class=" py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50">
                        Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require 'layouts/footer.php'; ?>