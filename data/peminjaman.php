<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mencari pelanggan
function create_rent($buku, $peminjam, $admin_id)
{
    try {
        // Koneksi ke database
        $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Set variabel sesi @user_id (ID admin yang sedang login)
        $statement = $db->prepare("SET @user_id = :admin_id");
        $statement->bindValue(":admin_id", htmlspecialchars(trim($admin_id)), PDO::PARAM_INT);
        $statement->execute();

        // Siapkan query INSERT
        $statement = $db->prepare("INSERT INTO peminjaman (buku_id, peminjam_id) VALUES (:buku, :peminjaman)");
        $statement->bindValue(":buku", htmlspecialchars(trim($buku)), PDO::PARAM_INT);
        $statement->bindValue(":peminjaman", htmlspecialchars(trim($peminjam)), PDO::PARAM_INT);
        $statement->execute();

        // Ambil ID peminjaman yang baru dimasukkan (jika diperlukan)
        $lastInsertId = $db->lastInsertId();

        return $lastInsertId;  // Mengembalikan ID peminjaman yang baru dibuat

    } catch (PDOException $error) {
        // Menangani error jika terjadi kesalahan pada database
        throw new Exception($error->getMessage());
    }
}

function get_peminjaman()
{
    try {
        // Koneksi ke database
        $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);


        $statement = $db->prepare("
        SELECT 
            peminjaman.*, 
            admins.nama_admin AS admin_name, 
            buku.judul_buku AS buku_title, 
            peminjam.nama_peminjam AS peminjam_name
        FROM peminjaman
        JOIN admins ON peminjaman.admin_id = admins.id_admin
        JOIN buku ON peminjaman.buku_id = buku.id_buku
        JOIN peminjam ON peminjaman.peminjam_id = peminjam.id_peminjam
    ");
    
        $statement->execute();

        // Ambil hasil dalam bentuk array asosiasi
        $peminjaman = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $peminjaman;
    } catch (PDOException $error) {
        // Jika terjadi kesalahan pada query atau koneksi, lemparkan exception
        throw new Exception($error->getMessage());
    }
}
