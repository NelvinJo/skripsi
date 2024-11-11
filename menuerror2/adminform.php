<?php
include "includes/config.php";

if (isset($_POST['Simpan'])) {
    if (isset($_REQUEST['inputkode'])) {
        $adminkode = $_REQUEST['inputkode'];
    }
    if (!empty($adminkode)) {
        $adminkode = $_REQUEST['inputkode'];
    } else {
        echo "<h1>Anda harus mengisi data</h1>";
        die('Anda harus memasukkan datanya');
    }

    $depanadmin = $_POST['inputdepan'];
    $belakangadmin = $_POST['inputbelakang'];
    $hp = $_POST['inputhp'];
    $email = $_POST['inputemail'];
    $password = $_POST['inputpassword'];
    $role = $_POST['inputrole'];

    mysqli_query($connection, "insert into admin values ('$adminkode','$depanadmin','$belakangadmin', '$hp','$email','$password','$role')") ;

    header("Location: admin.php");
    exit();
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
</head>
<body>
<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4">Input Admin</h1>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group row">
                        <label for="kodeadmin" class="col-sm-2 col-form-label">Kode Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodeadmin" name="inputkode" placeholder="Kode Admin" maxlength="4">
                        </div>
                    </div>

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
                        <label for="password" class="col-sm-2 col-form-label">Password Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputpassword" id="password" placeholder="Password Admin">
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
                            <input type="reset" class="btn btn-secondary" value="Batal" name="Batal">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<?php include "footer.php";?>
<script src="js/app.js"></script>
</html>
