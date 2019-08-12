<?php
//Periksa apakah user sudah login,dan cek kehadiran session nama
session_start();
if(!isset($_SESSION["nama"])) {
  header("Location: index.php");
}

session_start();

unset($_SESSION["nama"]);
header("Location: index.php");

session_destroy();
?>
