<!DOCTYPE html>
<html lang="en">
<head>
<?php
include "includes/config.php";
ob_start();
session_start();

if (isset($_POST["submitlogin"])) {
    $emailuser = mysqli_real_escape_string($connection, $_POST["useremail"]);
    $passuser = md5($_POST["pass"]);

    $sql_login = mysqli_query($connection, "SELECT * FROM admin WHERE Email = '$emailuser' AND Password = '$passuser'");

    if (mysqli_num_rows($sql_login) > 0) {
        $row_admin = mysqli_fetch_array($sql_login);

        $_SESSION['NamaDepan'] = $row_admin['NamaDepan'];
        $_SESSION['NamaBelakang'] = $row_admin['NamaBelakang'];
        $_SESSION['Email'] = $emailuser;
        $_SESSION['Role'] = $row_admin['Role'];

        header("Location: menuutama.php");
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Toko Arloji Pasar Baru</title>
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                    <img src="img/logo.png" alt="Logo Toko Arloji Pasar Baru" class="mb-3" style="max-width: 150px;">
                        <h1 class="h2">Selamat Datang!</h1>
                        <p class="lead">Masukkan akun anda untuk melanjutkan</p>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <?php
                                if (isset($error_message)) {
                                    echo "<p style='color:red;'>$error_message</p>";
                                }
                                ?>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg" type="email" name="useremail" placeholder="Masukkan email anda" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="pass" placeholder="Masukkan password anda" required />
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" name="submitlogin" class="btn btn-lg btn-primary">Masuk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/app.js"></script>
</body>
</html>