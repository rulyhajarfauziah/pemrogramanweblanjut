<?php
include 'koneksi.php';

$error = "";
$success = "";

if(isset($_POST['register'])){

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // VALIDASI
    if($nama == "" || $email == "" || $password == ""){

        $error = "Semua field wajib diisi!";

    }else{

        // CEK EMAIL SUDAH ADA
        $cek = mysqli_query($conn,"
        SELECT * FROM user
        WHERE email='$email'
        ");

        if(mysqli_num_rows($cek) > 0){

            $error = "Email sudah digunakan!";

        }else{

            // INSERT USER
            $password_md5 = md5($password);

            mysqli_query($conn,"
            INSERT INTO user(
                nama,
                email,
                password,
                role
            )
            VALUES(
                '$nama',
                '$email',
                '$password_md5',
                'pasien'
            )
            ");

            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register Klinik</title>

<link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">

    <div class="header">
        Register Pasien
    </div>

    <!-- ALERT ERROR -->
    <?php if($error != ""){ ?>
        <div class="alert-error">
            <?= $error; ?>
        </div>
    <?php } ?>

    <!-- ALERT SUCCESS -->
    <?php if($success != ""){ ?>
        <div class="alert-success">
            <?= $success; ?>
        </div>
    <?php } ?>

    <div class="card">

        <form method="POST">

            <div class="label">
                Nama Lengkap
            </div>

            <input
                type="text"
                name="nama"
                placeholder="Masukkan nama lengkap"
            >

            <div class="label">
                Email
            </div>

            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
            >

            <div class="label">
                Password
            </div>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
            >

            <button type="submit" name="register">
                Register
            </button>

        </form>

    </div>

    <div class="card">

        Sudah punya akun?

        <br><br>

        <a href="login.php">
            <button>
                Login
            </button>
        </a>

    </div>

</div>

</body>
</html>
