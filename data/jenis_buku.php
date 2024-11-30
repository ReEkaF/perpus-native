<?php

error_reporting(E_ALL);

require_once(__DIR__ . '/../config/database.php');

function find_category($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM kategori WHERE id_kategori_buku = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $category = $statement->fetch(PDO::FETCH_ASSOC);

    return $category;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
function get_categories()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("SELECT * FROM kategori ORDER BY id_kategori_buku DESC");
    $statement->execute();

    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
function save_category($category)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("INSERT INTO kategori (nama_kategori_buku) VALUES (:name)");
    $statement->bindValue(":name", htmlspecialchars(trim($category['name'])));
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
function update_category($id, $category)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("UPDATE kategori SET nama_kategori_buku = :name WHERE id_kategori_buku = :id");
    $statement->bindValue(":name", htmlspecialchars(trim($category['name'])));
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}
function delete_category($id)
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $statement = $db->prepare("DELETE FROM kategori WHERE id_kategori_buku = :id");
    $statement->bindValue(":id", $id);
    $statement->execute();
  } catch (PDOException $error) {
    throw new Exception($error->getMessage());
  }
}