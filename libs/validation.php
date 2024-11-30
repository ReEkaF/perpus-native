<?php

// fungsi untuk mengecek apakah suatu nilai ada isinya
function is_filled($value)
{
  $value = trim($value);
  return !empty($value);
}
// fungsi validasi nama
function validate_name(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar a-z A-Z - ' dan spasi
  $pattern = "/^[a-zA-Z-' ]{1,}+$/";
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan harus berupa huruf saja!';
    return false;
  }

  return true;
}
function validate_year(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom hanya berisi angka dan panjangnya tepat 4 digit
  $pattern = "/^\d{4}$/";  // Validasi hanya angka dan panjangnya 4 digit
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan harus berupa 4 digit angka!';
    return false;
  }

  return true;
}
function validate_numeric(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom hanya berisi angka dan panjangnya antara 1 hingga 11 digit
  $pattern = "/^\d{1,11}$/";  // Validasi hanya angka dengan panjang 1 hingga 11 digit
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan harus berupa angka dengan panjang 1 sampai 11 digit!';
    return false;
  }

  return true;
}

// fungsi validasi karakter alfabet dan numerik
function validate_alphanum(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah kolom mengandung karakter diluar alfabet & numerik
  $pattern = "/^[a-zA-Z]+[0-9]+$/";
  if (!preg_match($pattern, $field_list[$field_name])) {
    $errors[$field_name] = "Masukan harus berupa huruf dan angka!";
    return false;
  }

  return true;
}
// fungsi validasi password
function validate_password(&$errors, $field_list, $field_name)
{
  // cek apakah kolom tidak terisi
  if (!is_filled($field_list[$field_name])) {
    $errors[$field_name] = 'Kolom wajib diisi!';
    return false;
  }

  // cek apakah panjang karakter diluar 8-16 karakter
  if (strlen($field_list[$field_name]) < 8 || strlen($field_list[$field_name]) > 16) {
    $errors[$field_name] = 'Panjang password 8 hingga 16 karakter!';
    return false;
  }

  // cek apakah kolom tidak mengandung huruf besar
  if (!preg_match('/[A-Z]/', $field_list[$field_name])) {
    $errors[$field_name] = 'Harus terdapat minimal 1 huruf besar!';
    return false;
  }

  // cek apakah kolom tidak mengandung huruf kecil
  if (!preg_match('/[a-z]/', $field_list[$field_name])) {
    $errors[$field_name] = 'Harus terdapat minimal 1 huruf kecil!';
    return false;
  }

  // cek apakah kolom tidak mengandung karakter spesial
  if (!preg_match('/\W/', $field_list[$field_name])) {
    $errors[$field_name] = 'Harus terdapat minimal 1 karakter spesial!';
    return false;
  }

  // cek apakah kolom mengandung karakter spasi
  if (preg_match('/\s/', $field_list[$field_name])) {
    $errors[$field_name] = 'Masukan tidak boleh mengandung spasi!';
    return false;
  }

  return true;
}
