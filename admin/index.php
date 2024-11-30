<?php
session_start();
if (!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}
require 'layouts/header.php';

?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            <div>SELAMAT DATANG ADMIN PERPUSTAKAAN</div>
        </div>
    </div>
</div>



<?php require 'layouts/footer.php'; ?>