<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // VALIDASI
    if($email == "" || $password == ""){
        $error = "Email dan password wajib diisi!";
    }else{

        $password_md5 = md5($password);

        $query = mysqli_query($conn,"
        SELECT * FROM user
        WHERE email='$email'
        AND password='$password_md5'
        ");

        $data = mysqli_fetch_assoc($query);

        if($data){

            $_SESSION['user'] = $data;

            // ROLE ADMIN
            if($data['role'] == "admin"){
                header("Location: admin_dashboard.php");
            }

            // ROLE PASIEN
            else{
                header("Location: dashboard.php");
            }

        }else{
            $error = "Email atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login Klinik</title>

<link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">

    <div class="header">
        Login Klinik
    </div>

    <?php if($error != ""){ ?>
        <div class="alert-error">
            <?= $error; ?>
        </div>
    <?php } ?>

    <div class="card">

        <form method="POST">

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

            <button type="submit" name="login">
                Login
            </button>

        </form>

    </div>

    <div class="card">

        Belum punya akun?

        <br><br>

        <a href="register.php">
            <button>
                Register
            </button>
        </a>

    </div>

</div>

</body>
</html>
