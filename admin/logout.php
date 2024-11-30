<?php

session_start();

// menghapus semua session
unset($_SESSION['admin']);

// redirect ke halaman login
header('Location: ../index.php');
exit();
