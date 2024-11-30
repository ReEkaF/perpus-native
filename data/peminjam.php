<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

function get_peminjam()
{
  try {
    // Membuat koneksi PDO ke database
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $statement = $db->prepare("SELECT * FROM peminjam");
    $statement->execute();

    // Ambil hasil dalam bentuk array asosiasi
    $books = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $books;
  } catch (PDOException $error) {
    // Jika terjadi kesalahan pada query atau koneksi, lemparkan exception
    throw new Exception($error->getMessage());
  }
}