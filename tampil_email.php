<?php
//Periksa apakah user sudah login dan cek kehadiran session name
session_start();
if (!isset($_SESSION["nama"])) {
  //Jika tidak ada pindahkan ke login kembali
  header("Location: index.php");
}


//Periksa apakah ada pesan
if (isset($_GET["pesan"])) {
  $pesan = $_GET["pesan"];
}
include 'connection.php';


//Page

//Jumlah data perhalaman
$jumlahdataperhalaman = 5;

//Jumlah data berasal dari database
$query  = "SELECT * FROM staff";
$result = mysqli_query($link, $query);

//Hitung baris di database
$jumlahdatadb = mysqli_num_rows($result);



//jumlah halaman
$jumlahhalaman = ceil($jumlahdatadb / $jumlahdataperhalaman);

//halaman yang sedang aktif di url
$halamanaktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

//Awal data
//halaman = 1; awal data = 0;
//halaman = 2; awal data = 5;

$awaldata = ($jumlahdataperhalaman * $halamanaktif) - $jumlahdataperhalaman;


//Periksa apakah form search sudah di submit
if (isset($_POST["submit"])) {
  //ambil nilai dari form search
  $nama = htmlentities(strip_tags(trim($_POST["nama"])));

  $nama = mysqli_real_escape_string($link, $nama);

  //Search dari database
  $query  = "SELECT * FROM staff WHERE Nama LIKE '%$nama%' ORDER BY Nama ASC LIMIT $awaldata,$jumlahdataperhalaman";
  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) === 1) {
    //Pesan
    $pesan = "Pencarian atas nama <strong>$nama</strong> berhasil ditemukan";
  }

  if (mysqli_num_rows($result) === 0) {
    $pesan_error = "Pencarian atas nama <strong>$nama</strong> tidak ditemukan";
  }
} else {
  $query = "SELECT * FROM staff LIMIT $awaldata,$jumlahdataperhalaman ";
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
  <link rel="shortcut icon" href="fav/favicon.ico" type="image/ico">
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

    <!-- Start Tampil Table Email -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="bold text-muted text-center mt-5">Sistem Informasi</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 text-center text-success">
        <?php
        //Periksa apakah ada pesan
        if (isset($pesan)) {
          echo "<div class='alert alert-success' role='alert'>$pesan</div>";
        }

        //Periksa apakah ada pesan error
        if (isset($pesan_error)) {
          echo "<div class='alert alert-danger' role='alert'>$pesan_error</div>";
        }
        ?>

      </div>
    </div>

    <div class="row mt-3">
      <div class="col-lg-12">
        <table class="table table-bordered table-striped">
          <thead class="text-center">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nip</th>
              <th scope="col">Nama</th>
              <th scope="col">Email</th>
              <th scope="col">Telephone</th>
              <th scope="col">Cabang</th>
            </tr>
          </thead>

          <tbody>
            <?php
            //Tampilkan data dari database
            $result = mysqli_query($link, $query);

            //Periksa apakah query berhasil
            if (!$result) {
              die("Query error : " . mysqli_errno($link) . "-" . mysqli_error($link));
            }

            //Buat perulangan while untuk menampilkan dan menarik data ke website
            $no = 0;
            while ($data = mysqli_fetch_assoc($result)) {
              $no++;
              echo "<tr>";
              echo "<td class='text-center'>$no</td>";
              echo "<td class='text-center'>$data[Nip]</td>";
              echo "<td class='text-center'>$data[Nama]</td>";
              echo "<td class='text-center'>$data[Email]</td>";
              echo "<td class='text-center'>$data[Telephone]</td>";
              echo "<td class='text-center'>$data[Cabang]</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
        <div class="row">
          <div class="col-lg-12 text-right">
            <?php if ($halamanaktif > 1) : ?>
            <a href="?halaman=<?php echo $halamanaktif - 1 ?>"><?php echo " <i class='fas fa-arrow-circle-left'></i></a>" ?></a>
            <?php endif; ?>

            <?php if ($halamanaktif < $jumlahhalaman) : ?>
            <a href="?halaman=<?php echo $halamanaktif + 1 ?>"><?php echo "<i class='fas fa-arrow-circle-right'></i>" ?></a>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
    <!-- End Tampil Table Email -->

    <!-- Start Footer -->
    <div class="row">
      <div class="col-lg-12 mt-3">
        <footer class="blockqute-footer text-center text-dark">
          &copy; Copyright 2018 | Built By Fajar Subhan
        </footer>
      </div>
    </div>
    <!-- End Footer -->
  </div>
</body>

</html>