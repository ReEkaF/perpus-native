<?php 
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

if (!isset($_GET['id_kategori_buku'])) {
    header('Location: ./kategori.php');
    exit();
}

require '../data/jenis_buku.php';
require '../data/buku.php';

$cat = find_category($_GET['id_kategori_buku']);

count_related_book($cat['id_kategori_buku'])['count_related_books'];

if (count_related_book($cat['id_kategori_buku'])['count_related_books'] > 0) {
    // Set the error message
    $error_message = "Tidak dapat menghapus kategori karena masih ada buku terkait.";
    
    // Redirect to kategori.php with the error message as a query parameter
    header('Location: ./kategori.php?error=' . urlencode($error_message));
    exit();
}


if (!$cat) {
    header('Location: ./kategori.php');
    exit();
}

delete_category($cat['id_kategori_buku']);
header('Location: ./kategori.php');
exit();

