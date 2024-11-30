<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

function get_rent()
{
  try {
    // Membuat koneksi PDO ke database
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $statement = $db->prepare("SELECT * FROM rent");
    $statement->execute();

    // Ambil hasil dalam bentuk array asosiasi
    $books = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $books;
  } catch (PDOException $error) {
    // Jika terjadi kesalahan pada query atau koneksi, lemparkan exception
    throw new Exception($error->getMessage());
  }
}

function find_rent($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM rent WHERE id_peminjaman = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $category = $statement->fetch(PDO::FETCH_ASSOC);

    return $category;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
function done($id,$id_admin)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE peminjaman SET admin_id = :id_admin WHERE id_peminjaman = :id");
    $statement->bindValue(":id_admin", $id_admin);
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
