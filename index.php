<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Link ke Google Fonts untuk Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<?php 
session_start();
if (isset($_SESSION['admin'])){
  header("Location: admin/index.php");
  exit;
}

require 'libs/validation.php';
require 'data/admin.php';

$login_eror = null;

$errors =[];

$old_inputs = [
  'username' => '',
];

if(isset($_POST['submit'])){


  if(!$errors){
    $admin = find_admin($_POST['username']);
    if($admin){
      if($_POST['password'] === $admin['password']){
        $_SESSION['admin'] = $admin['id_admin'];
        header("Location: admin/index.php");
        exit;
      }

      
    }
    $login_eror = 'Username atau password salah';
  }
  $old_inputs['username'] = htmlspecialchars($_POST['username']);
}

$title = 'Login';
?>
<body class="h-screen flex items-center justify-center bg-gray-100">

  <div class="flex w-full max-w-2xl bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Left Side: Image -->
    <div class="w-5/12 bg-cover bg-center" style="background-image: url('assets/img/login/left-image.jpeg');">

    </div>

    <!-- Right Side: Login Form -->
    <div class="w-7/12 p-4 flex flex-col justify-center">
      <div class="flex flex-col items-start p-6">
        <!-- Logo -->
        <img src="assets/img/login/logo.jpeg" alt="Logo" class="h-12 mb-2">

        <!-- Title and Subtitle -->
        <h2 class="text-lg font-semibold text-gray-800 mb-1">Hey, Hello 👋</h2>
        <p class="text-gray-600 mb-4 text-xs">Masukkan informasi yang Anda untuk login</p>
        <!-- Login Heading -->
        <h3 class="text-base font-semibold text-gray-700 mb-3">Login</h3>

        <!-- Login Form -->
        <form class="w-full" method="post" action="index.php">
          <div class="mb-3">
            <label class="block text-gray-700 text-xs mb-1" for="username">Username</label>
            <div class="flex items-center border rounded-lg focus-within:ring-2 focus-within:ring-blue-500">
              <!-- Icon -->
              <span class="pl-2 text-gray-500">
                <img src="assets/img/login/username.png" alt="Username Icon" class="h-4 w-4">
              </span>
              <!-- Input Field -->
              <input type="text" id="username" name="username" placeholder="username" class="w-full px-2 py-1 focus:outline-none text-xs">
            </div>
          </div>

          <div class="mb-3">
            <label class="block text-gray-700 text-xs mb-1" for="password">Password</label>
            <div class="flex items-center border rounded-lg focus-within:ring-2 focus-within:ring-blue-500">
              <!-- Icon for Password -->
              <span class="pl-2 text-gray-500">
                <img src="assets/img/login/Lock 1.png" alt="Password Icon" class="h-4 w-4">
              </span>
              <!-- Input Field for Password -->
              <input type="password" id="password" name="password" placeholder="********" class="w-full px-2 py-1 focus:outline-none text-xs">
            </div>
          </div>
          <button type="submit" name="submit" class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-xs mb-3">Login</button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
