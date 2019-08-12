<?php
//Hubungkan ke database
$dbhost = "localhost";
$dbuser = "";
$dbpass = "";
$dbname = "";
$link   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//Periksa koneksi
if (!$link) {
  die("Koneksi gagal : " . mysqli_connect_errno($link) . "-" . mysqli_connect_error($link));
}
