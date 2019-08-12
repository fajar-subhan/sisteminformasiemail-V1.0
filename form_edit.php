<?php
//Periksa apakah user sudah login dan cek kehadiran session nama
session_start();
if (!isset($_SESSION["nama"])) {
  header("Location: index.php");
}

//Masukan database
include 'connection.php';

//siapkan pesan error
$pesan_error .= "";

//Periksa apakah form sudah di submit
if (isset($_POST["submit"])) {
  //Periksa apakah form berasal dari 'Edit' edit_email.php atau dari 'Ubah' form_edit.php

  if ($_POST["submit"] == "Edit") {
    $nip = htmlentities(strip_tags(trim($_POST["nip"])));

    $nip = mysqli_real_escape_string($link, $nip);

    //ambil data nip dari database
    $query = "SELECT * FROM staff WHERE Nip = '$nip'";
    $result = mysqli_query($link, $query);

    if (!$result) {
      die("Query error : " . mysqli_errno($link) . "-" . mysqli_error($link));
    }

    $data = mysqli_fetch_assoc($result);

    $nama = $data["Nama"];
    $email = $data["Email"];
    $telephone = $data["Telephone"];
    $cabang = $data["Cabang"];

    //mysqli_free_result
    mysqli_free_result($result);
  } else if ($_POST["submit"] == "Ubah") {
    //ambil nilai
    $nip = htmlentities(strip_tags(trim($_POST["nip"])));
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $email = htmlentities(strip_tags(trim($_POST["email"])));
    $telephone = htmlentities(strip_tags(trim($_POST["telephone"])));
    $cabang = htmlentities(strip_tags(trim($_POST["cabang"])));
  }

  //Periksa apakah nip sudah di isi
  if (empty($nip)) {
    $pesan_error .= "Nip belum di isi<br>";
  } elseif (!preg_match("/^[0-9]{8}$/", $nip)) {
    $pesan_error .= "Nip harus berupa angka 8 digit<br>";
  }

  //Nama sudah di isi
  if (empty($nama)) {
    $pesan_error .= "Nama belum di isi<br>";
  }

  //Periksa apakah email sudah di isi
  if (empty($email)) {
    $pesan_error .= "Email belum di isi<br>";
  } elseif (!preg_match("/@/", $email)) {
    $pesan_error .= "Isi email sesuai dengan format (name@domain.com)";
  }
  //Periksa apakah telephone sudah di isi
  if (empty($telephone)) {
    $pesan_error .= "Telephone belum di isi<br>";
  }

  //Periksa apakah cabang sudah di isi
  if (empty($cabang)) {
    $pesan_error .= "Cabang belum di isi<br>";
  }

  //Jika tidak ada error
  if (($pesan_error === "") and ($_POST["submit"] == "Ubah")) {
    //filter database
    $nip = mysqli_real_escape_string($link, $nip);
    $nama = mysqli_real_escape_string($link, $nama);
    $email = mysqli_real_escape_string($link, $email);
    $telephone = mysqli_real_escape_string($link, $telephone);
    $cabang = mysqli_real_escape_string($link, $cabang);

    //Update ke database
    $query = "UPDATE staff SET Nama = '$nama',Email = '$email',Telephone = '$telephone',Cabang = '$cabang' WHERE Nip = '$nip'";
    $result = mysqli_query($link, $query);

    if ($result == false) {
      die("Query error NIH : " . mysqli_errno($link) . "-" . mysqli_error($link));
    }

    if ($result) {
      $pesan = "Staff Karyawan dengan nama : <b>$nama</b> berhasil di ubah<br>";
      $pesan = urlencode($pesan);
      header("Location: tampil_email.php?pesan={$pesan}");
    }
  }
} else {
  header("Location: edit_email.php");
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
        <h1 class="bold text-muted text-center mt-3">Edit Data Staff</h1>
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

    <!-- Start Form -->
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <form action="form_edit.php" method="post">
          <div class="form-group">
            <label for="nip">Nip</label>
            <input type="text" name="nip" value="<?Php echo "$data[Nip]"; ?>" id="nip" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" value="<?php echo $nama ?>" class="form-control">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $email ?>" class="form-control">
          </div>

          <div class="form-group">
            <label for="telephone">No Telephone</label>
            <input type="tel" name="telephone" id="telephone" value="<?php echo $telephone ?>" class="form-control">
          </div>

          <div class="form-group">
            <label for="cabang">Cabang</label>
            <input type="text" name="cabang" id="cabang" value="<?php echo $cabang; ?>" class="form-control">
          </div>
          <button type="submit" name="submit" value="Ubah" class="btn btn-primary float-right">Send</button>
        </form>
      </div>
    </div>
    <!-- End Form -->

    <!-- Start Footer -->
    <div class="row">
      <div class="col-lg-12 mb-0">
        <footer class="blockqute-footer text-center text-dark" style="margin-top:0px">
          &copy; Copyright 2018 | Built By Fajar Subhan
        </footer>
      </div>
    </div>
    <!-- End Footer -->
  </div>
</body>

</html>