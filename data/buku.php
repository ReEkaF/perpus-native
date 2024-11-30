<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

function get_book()
{
  try {
    // Membuat koneksi PDO ke database
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $statement = $db->prepare("SELECT * FROM buku INNER JOIN kategori ON kategori.id_kategori_buku = buku.kategori_buku_id  ORDER BY buku.id_buku DESC");
    $statement->execute();

    // Ambil hasil dalam bentuk array asosiasi
    $books = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $books;
  } catch (PDOException $error) {
    // Jika terjadi kesalahan pada query atau koneksi, lemparkan exception
    throw new Exception($error->getMessage());
  }
}
function get_book_stock()
{
  try {
    // Membuat koneksi PDO ke database
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $statement = $db->prepare(" CALL GetBookStock()");
    $statement->execute();

    // Ambil hasil dalam bentuk array asosiasi
    $books = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $books;
  } catch (PDOException $error) {
    // Jika terjadi kesalahan pada query atau koneksi, lemparkan exception
    throw new Exception($error->getMessage());
  }
}

function count_related_book($category_id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT COUNT(*) AS count_related_books FROM buku WHERE kategori_buku_id = :id_kategori_buku");
    $statement->bindValue(":id_kategori_buku", $category_id);
    $statement->execute();

    $plant = $statement->fetch(PDO::FETCH_ASSOC);

    return $plant;
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
}

function create_book($p_kategori_buku, $p_judul_buku, $p_pengarang, $p_tahun_terbit, $p_stok)
{
  try {
    // Membuat koneksi PDO (jika belum ada)
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Menyiapkan dan memanggil stored procedure insert_buku
    $statement = $db->prepare("CALL insert_buku(:kategori_buku_id,:judul_buku, :pengarang, :tahun_terbit, :stok)");

    // Mengikat parameter ke variabel
    $statement->bindParam(':kategori_buku_id', $p_kategori_buku);
    $statement->bindParam(':judul_buku', $p_judul_buku);
    $statement->bindParam(':pengarang', $p_pengarang);
    $statement->bindParam(':tahun_terbit', $p_tahun_terbit);
    $statement->bindParam(':stok', $p_stok);

    // Menjalankan query
    $statement->execute();

    echo "Data buku berhasil dimasukkan!";
  } catch (PDOException $e) {
    // Menangani error
    echo "Terjadi kesalahan: " . $e->getMessage();
  }
}
function find_book($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("CALL GetBukuById(:id)");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $category = $statement->fetch(PDO::FETCH_ASSOC);

    return $category;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}

function update_book($p_id_buku,$p_kategori_buku, $p_judul_buku, $p_pengarang, $p_tahun_terbit, $p_stok)
{
  try {
    // Membuat koneksi PDO (jika belum ada)
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Menyiapkan dan memanggil stored procedure insert_buku
    $statement = $db->prepare("CALL update_buku_with_stok(:id_buku,:input_stok,:input_kategori_buku_id,:input_judul_buku, :input_pengarang, :input_tahun_terbit, )");

    // Mengikat parameter ke variabel
    $statement->bindParam(':id_buku', $p_id_buku);
    $statement->bindParam(':input_kategori_buku_id', $p_kategori_buku);
    $statement->bindParam(':input_judul_buku', $p_judul_buku);
    $statement->bindParam(':input_pengarang', $p_pengarang);
    $statement->bindParam(':tahun_terbit', $p_tahun_terbit);
    $statement->bindParam(':input_stok', $p_stok);

    // Menjalankan query
    $statement->execute();

    echo "Data buku berhasil dimasukkan!";
  } catch (PDOException $e) {
    // Menangani error
    echo "Terjadi kesalahan: " . $e->getMessage();
  }
}