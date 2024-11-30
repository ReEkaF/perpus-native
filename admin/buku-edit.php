<?php
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

if (!isset($_GET['id_buku'])) {
    header('Location: ./buku.php');
    exit();
}
require '../data/jenis_buku.php';
require '../libs/validation.php';
require '../data/buku.php';

$errors = [];
$id= $_GET['id_buku'];
$book= find_book($id);

if (!$book) {
    header('Location: ./buku.php');
    exit();
}

$old_inputs = [
    'name' => $book['judul_buku'],
    'pengarang' => $book['pengarang'],
    'kategori_buku_id' => $book['kategori_buku_id'],
    'tahun_terbit' => $book['tahun_terbit'],
    'stok' => $book['stok'],
];

$categories = get_categories();

// cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    validate_name($errors, $_POST, 'name');
    validate_year($errors, $_POST, 'tahun_terbit');
    validate_name($errors, $_POST, 'pengarang');
    validate_numeric($errors, $_POST, 'stok');
    $id_kategori_buku = $_POST['kategori'];
    $judul_buku = $_POST['name'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];
    // cek apakah tidak ada error
    if (!$errors) {
        
        update_book($_GET['id_buku'],$id_kategori_buku, $judul_buku, $pengarang, $tahun_terbit, $stok);
        header('Location: ./buku.php');
        exit();
    }

    $old_inputs['name'] = htmlspecialchars($_POST['name']);
}

// inisialisasi variabel untuk halaman dan komponen header
$title = 'Edit Buku';

require 'layouts/header.php';

?>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <nav class="text-sm text-gray-500 mb-4">
                <a href="./index.php" class="text-black-500 hover:underline">Dashboard </a> >
                <a href="./buku.php" class="text-black-500 hover:underline">Kelola Buku ></a>
                <a href="" class="text-black-500 hover:underline"><b>Edit Buku</b></a>
            </nav>
            <h3 class="text-lg font-semibold mb-4">Edit Buku</h3>

            <!-- Form untuk menambah kategori -->
            <form action="./buku-edit.php" method="post" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Masukkan judul buku" value="<?= $old_inputs['name'] ?>">
                </div>
                <?php if (isset($errors['name'])) : ?>
                    <div class="text-red-500">
                        <?= $errors['name'] ?>
                    </div>
                <?php endif; ?>

                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Pilih Kategori</option>
                        <!-- Add the options dynamically, assuming you have an array of available book titles -->
                        <?php foreach ($categories as $cat):  ?>

                            <option value="<?= htmlspecialchars($cat['id_kategori_buku']) ?>" <?= isset($old_inputs['kategori']) && $old_inputs['kategori'] == $cat['nama_kategori_buku'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nama_kategori_buku']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if (isset($errors['kategori'])) : ?>
                    <div class="text-red-500">
                        <?= $errors['kategori'] ?>
                    </div>
                <?php endif; ?>

                <div>
                    <label for="pengarang" class="block text-sm font-medium text-gray-700">Pengarang</label>
                    <input type="text" name="pengarang" id="pengarang" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Masukkan pengarang buku" value="<?= $old_inputs['pengarang'] ?>">
                </div>
                <?php if (isset($errors['pengarang'])) : ?>
                    <div class="text-red-500">
                        <?= $errors['pengarang'] ?>
                    </div>
                <?php endif; ?>
                <div>
                    <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                    <input type="text" name="tahun_terbit" id="tahun_terbit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="msukkan tahun terbit" value="<?= $old_inputs['tahun_terbit'] ?>" maxlength="4">
                </div>
                <?php if (isset($errors['tahun_terbit'])) : ?>
                    <div class="text-red-500">
                        <?= $errors['tahun_terbit'] ?>
                    </div>
                <?php endif; ?>

                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="text" name="stok" id="stok" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Masukkan Stok Buku" value="<?= $old_inputs['stok'] ?>">
                </div>
                <?php if (isset($errors['stok'])) : ?>
                    <div class="text-red-500">
                        <?= $errors['stok'] ?>
                    </div>
                <?php endif; ?>

                <div class="flex justify-center">
                    <button type="submit" name="submit" class=" py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50">
                        Edit Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require 'layouts/footer.php'; ?>