<?php
//Periksa apakah user sudah login,dan cek kehadiran session name
session_start();
if (!isset($_SESSION["nama"])) {
  header("Location: index.php");
}

//connection
include 'connection.php';

//pesan error
$pesan_error = "";

//Periksa apakah form sudah di submit
if (isset($_POST["submit"])) {
  //ambil nilai dari form
  $nip = htmlentities(strip_tags(trim($_POST["nip"])));
  $nama = htmlentities(strip_tags(trim($_POST["nama"])));
  $email = htmlentities(strip_tags(trim($_POST["email"])));
  $telephone = htmlentities(strip_tags(trim($_POST["telephone"])));
  $cabang = htmlentities(strip_tags(trim($_POST["cabang"])));

  //Periksa apakah no sudah di isi
  //Periksa apakah nip sudah di isi
  if (empty($nip)) {
    $pesan_error .= "Nip belum di isi<br>";
  }

  //Periksa apakah nip berisi angka sebanyak 8 digit
  elseif (!preg_match("/^[0-9]{8}$/", $nip)) {
    $pesan_error .= "Nip harus berupa angka sebanyak 8 digit<br>";
  }

  //Periksa apakah ada nip yang sama
  $query  = "SELECT * FROM staff WHERE Nip ='$nip'";
  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) >= 1) {
    $pesan_error .= "Nip sudah di gunakan<br>";
  }

  //Periksa apakah nama sudah di isi
  if (empty($nama)) {
    $pesan_error .= "Nama belum di isi<br>";
  }

  //Periksa apakah email sudah di isi
  if (empty($email)) {
    $pesan_error .= "Email belum di isi<br>";
  } elseif (!preg_match("/@/", $email)) {
    $pesan_error .= "Isi email sessuai dengan format (name@domain.com)<br>";
  }

  //Periksa apakah no telephone sudah di isi
  if (empty($telephone)) {
    $pesan_error .= "No telephone belum di isi<br>";
  }
  //dan harus berupa angka
  elseif (!is_numeric($telephone)) {
    $pesan_error .= "No telephone harus berupa angka<br>";
  }

  //Periksa apakah cabang sudah di isi
  if (empty($cabang)) {
    $pesan_error .= "Cabang belum di isi<br>";
  }

  //jika tidak ada error
  if ($pesan_error === "") {
    //filter sql
    $nip = mysqli_real_escape_string($link, $nip);
    $nama = mysqli_real_escape_string($link, $nama);
    $email = mysqli_real_escape_string($link, $email);
    $telephone = mysqli_real_escape_string($link, $telephone);
    $cabang = mysqli_real_escape_string($link, $cabang);

    //Masukan data ke database
    $query  = "INSERT INTO staff VALUES";
    $query .= "('$nip','$nama','$email','$telephone','$cabang')";
    $result = mysqli_query($link, $query);

    //Periksa apakah query berhasil
    if (!$result) {
      die("Query tambah data berhasil : " . mysqli_errno($link) . "-" . mysqli_error($link));
    }

    if ($result) {
      $pesan = "Staff Karyawan dengan nama : <b>$nama</b> berhasil di tambahkan<br>";
      $pesan = urlencode($pesan);
      header("Location:tampil_email.php?pesan={$pesan}");
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.css">
  <link rel="shortcut icon" href="assets/fav/favicon.ico" type="image/ico">
  <title>Hello, world!</title>
</head>

<body>
  <div class="container">
    <!-- Start Navbar -->
    <div class="row">
      <div class="col-lg-12">
        <nav class="navbar navbar-expand-lg black">
          <button class="navbar-toggler" type="button" data-toggler="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto ml-2">
              <li class="nav-item">
                <a class="nav-link" href="tampil_email.php">Tampil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tambah_email.php">Tambah</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="edit_email.php">Edit</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="hapus_email.php">Hapus</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
            </ul>
            <form action="tampil_email.php" method="post" class="form-inline my-1 my-lg">
              <input class="form-control mr-sm-2" type="search" placeholder="Nama" aria-label="Search" name="nama">
              <button name="submit" class="btn btn-outline-success my-1 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
          </div>
        </nav>
      </div>
    </div>
    <!-- End Navbar -->

    <div class="row">
      <div class="col-lg-12">
        <h1 class="bold text-muted text-center mt-4">Tambah Data Staff</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <?php
        //Periksa apakah ada pesan error
        if ($pesan_error !== "") {
          echo "<div class='alert alert-danger error' role='alert'>$pesan_error</div>";
        }
        ?>

      </div>
    </div>

    <!-- Start Tambah -->
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <form action="tambah_email.php" method="post">
          <!-- Nip -->
          <div class="form-group">
            <label for="nip">Nip (*)</label>
            <input type="text" name="nip" id="nip" class="form-control" value="<?php echo $nip ?>" placeholder="masukan nip">
          </div>
          <!-- Nama -->
          <div class="form-group">
            <label for="nama">Nama (*)</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama ?>" placeholder="masukan nama lengkap">
          </div>
          <!-- Email -->
          <div class="form-group">
            <label for="email">Email (*)</label>
            <input type="text" name="email" id="email" class="form-control" value="<?php echo $email ?>" placeholder="masukan email">
          </div>
          <!-- Telephone -->
          <div class="form-group">
            <label for="telephone">Telephone (*)</label>
            <input type="tel" name="telephone" id="telephone" class="form-control" value="<?php echo $telephone ?>" placeholder="masukan no telephone">
          </div>
          <!-- Cabang -->
          <div class="form-group">
            <label for="cabang">Cabang (*)</label>
            <input type="text" name="cabang" id="cabang" class="form-control" value="<?php echo $cabang ?>" placeholder="masukan daerah cabang">
          </div>

          <button type="submit" name="submit" class="btn btn-primary float-right">Send</button>
        </form>
      </div>
    </div>
    <!-- End Tambah -->

    <!-- Start Footer -->
    <div class="row">
      <div class="col-lg-12">
        <footer class="blockqute-footer text-center text-dark mt-0">
          &copy; Copyright 2018 | Built By Fajar Subhan
        </footer>
      </div>
    </div>
    <!-- End Footer -->
  </div>
</body>

</html>