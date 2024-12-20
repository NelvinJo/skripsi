<?php
session_start();
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'owner') {
    header("Location: menuutama.php");
    exit();
}

include "includes/config.php";

if (isset($_POST['Simpan'])) {
    $depanadmin = $_POST['inputdepan'];
    $belakangadmin = $_POST['inputbelakang'];
    $hp = $_POST['inputhp'];
    $email = $_POST['inputemail'];
    $password = md5($_POST['inputpassword']);
    $role = $_POST['inputrole'];

    if (empty($depanadmin) || empty($belakangadmin) || empty($hp) || empty($email) || empty($password) || empty($role)) {
        echo '<h1>Anda harus mengisi semua data</h1>';
        die();
    }

    $existingQuery = mysqli_query($connection, "SELECT * FROM admin WHERE Email = '$email'");
    if (mysqli_num_rows($existingQuery) == 0) {
        mysqli_query($connection, "INSERT INTO admin (NamaDepan, NamaBelakang, NoHp, Email, Password, Role) 
                                   VALUES ('$depanadmin', '$belakangadmin', '$hp', '$email', '$password', '$role')");

        header("Location:admin.php");
        exit();
    } else {
        echo "<script>alert('Nama Admin ini sudah ada. Tidak dapat diinput ulang.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />
    <title>Admin</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    .popup-form {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 10px;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .popup-form input, .popup-form button, .popup-form select {
        width: 100%;
        margin-top: 10px;
        padding: 10px;
        border: 2px solid black;
        border-radius: 5px;
    }
    .popup-form button {
        background-color: #222e3c;
        color: white;
    }
    .close-popup {
        float: right;
        cursor: pointer;
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .popup-form input, 
    .popup-form button, 
    .popup-form select, 
    .form-control {
    padding: 10px;
    border: 1px solid rgba(0, 0, 0, 0.7) !important;
    border-radius: 5px;
    }

    .btn {
        padding: 10px 15px;
        font-size: 14px;
    }
</style>
</head>
<body>
<?php include "header.php"; ?>

<main class="content">
<div class="container-fluid p-0">
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid"></div>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h1 class="h3 mb-3">Form Admin</h1>
                </div>

                <form method="POST">
                    <div class="form-group row">
                        <label for="depanadmin" class="col-sm-2 col-form-label">Nama Depan Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputdepan" id="depanadmin" placeholder="Nama Depan Admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="belakangadmin" class="col-sm-2 col-form-label">Nama Belakang Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputbelakang" id="belakangadmin" placeholder="Nama Belakang Admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="hp" class="col-sm-2 col-form-label">Nomor HP Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputhp" id="hp" placeholder="Nomor Handphone Admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputemail" id="email" placeholder="Email Admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password Admin</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="inputpassword" id="password" placeholder="Password Admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputrole" id="role" placeholder="Role Admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="Simpan">
                            <a href="admin.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/app.js"></script>
</main>
</body>
</html>