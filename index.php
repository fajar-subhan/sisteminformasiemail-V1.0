<?php
//siapkan pesan error
$pesan_error = "";

include 'connection.php';

//Periksa apakah form sudah di submit
if (isset($_POST["submit"])) {
  //ambil nilai dari form login
  $username = htmlentities(strip_tags(trim($_POST["username"])));
  $password = htmlentities(strip_tags(trim($_POST["password"])));

  //Periksa apakah username sudah di isi
  if (empty($username)) {
    $pesan_error .= "Username belum di isi<br>";
  }

  //Periksa apakah password sudah di isi
  if (empty($password)) {
    $pesan_error .= "Password belum di isi<br>";
  }

  $username = mysqli_real_escape_string($link, $username);
  $password = mysqli_real_escape_string($link, $password);

  $password_sha1 = md5($password);

  $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password_sha1'";
  $result = mysqli_query($link, $query);

  //Periksa apakah username dan password sudah sessuai
  if (mysqli_num_rows($result) == 0) {
    $pesan_error .= "Username atau password tidak sessuai";
  }



  //Jika tidak ada error maka buat lanjutkan
  if ($pesan_error === "") {
    session_start();
    $_SESSION["nama"] = $username;
    header("Location: tampil_email.php");
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
    <div class="row text-center">
      <div class="col-lg-12 mt-5">
        <h1 class="bold text-muted">Sistem Informasi Email</h1>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-lg-6 offset-lg-3">
        <?php
        if ($pesan_error !== "") {
          echo "<div class='error'>$pesan_error</div>";
        }
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4 offset-lg-4 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5">
        <form action="index.php" method="post">
          <div class="form-group">
            <label for="username"><i class="fas fa-user"></i>
              Username
            </label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $username ?>">
          </div>
          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i>
              Password
            </label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?php echo $password ?>">
          </div>
          <button type="submit" name="submit" class="btn btn-primary float-right" id="button">Log in</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>