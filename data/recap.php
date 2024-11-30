<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

function recap()
{
    try {
        // Membuat koneksi PDO ke database
        $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        // Menjalankan stored procedure
        $statement = $db->prepare("CALL Recap(@total_buku, @total_stok, @total_stok_terpakai, @total_stok_tersisa)");
        $statement->execute();

        // Ambil hasil OUT parameters
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
        
    } catch (PDOException $error) {
        // Jika terjadi kesalahan pada query atau koneksi, lemparkan exception
        throw new Exception($error->getMessage());
    }
}
