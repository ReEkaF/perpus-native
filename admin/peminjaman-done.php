<?php 

session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

if (!isset($_GET['id_peminjaman'])) {
    header('Location: ./rent.php');
    exit();
}

require '../data/rent.php';

$rent= find_rent($_GET['id_peminjaman']);


if (!$rent) {
    header('Location: ./rent.php');
    exit();
}
done($_GET['id_peminjaman'],$_SESSION['admin']);
header('Location: ./rent.php');
exit();
