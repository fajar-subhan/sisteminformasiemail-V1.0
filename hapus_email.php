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
//Form delete
if (isset($_POST["submit"])) {
  //ambil nilai
  $hapus = htmlentities(strip_tags(trim($_POST["hapus"])));
  $nama = htmlentities(strip_tags(trim($_POST["nama"])));

  //filter
  $hapus = mysqli_real_escape_string($link, $hapus);
  $nama = mysqli_real_escape_string($link, $nama);

  //Delete
  $query = "DELETE FROM staff WHERE Nip = '$hapus'";
  $result = mysqli_query($link, $query);

  if (!$result) {
    die("Query hapus error : " . mysqli_errno($link) . "-" . mysqli_error($link));
  } elseif ($result) {
    $pesan = "Staff karyawan dengan <b>$nama</b> berhasil di hapus<br>";
    $pesan = urlencode($pesan);
    header("Location: tampil_email.php?pesan={$pesan}");
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
        <h1 class="bold text-muted text-center mt-5">Hapus Data Staff</h1>
      </div>
    </div>

    <!-- Start Tampil -->
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
              <th scope="col">Hapus</th>
            </tr>
          </thead>

          <tbody>
            <?php
            //Tampilkan data dari database
            $query = "SELECT * FROM staff LIMIT $awaldata,$jumlahdataperhalaman";
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
              echo "<td>";
              ?>
            <form action="hapus_email.php" method="post">
              <input type="text" hidden name="hapus" value="<?php echo "$data[Nip]" ?>">
              <input type="text" hidden name="nama" value="<?php echo "$data[Nama]"; ?>">
              <button type="submit" name="submit" class="ml-5 btn btn-primary" value="Edit" onclick="return confirm('Apakah anda yakin?')"><i class="fas fa-trash-alt"></i></button>
            </form>
            <?php
              echo "</td>";
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

    <!-- End Tampil -->

    <!-- Start Footer -->
    <div class="row">
      <div class="col-lg-12 mb-0">
        <footer class="blockqute-footer text-center text-dark" style="margin-top:15px;">
          &copy; Copyright 2018 | Built By Fajar Subhan
        </footer>
      </div>
    </div>
    <!-- End Footer -->
  </div>
</body>

</html>