<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

// fungsi untuk mencari pelanggan
function find_admin($username)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM admins WHERE username = :username");
    $statement->bindValue(":username", htmlspecialchars(trim($username)));
    $statement->execute();

    $admin = $statement->fetch(PDO::FETCH_ASSOC);

    return $admin;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}