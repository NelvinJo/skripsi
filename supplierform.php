<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_POST['Simpan'])) {
    $namasupplier = $_POST['inputnama'];
    $telp = $_POST['inputtelp'];
    $alamat = $_POST['inputalamat'];
    $kota = $_POST['inputkota'];
    $provinsi = $_POST['inputprovinsi'];

    if (empty($namasupplier) || empty($telp) || empty($alamat) || empty($kota) || empty($provinsi)) {
        echo '<h1>Anda harus mengisi semua data</h1>';
        die();
    }

    // Cek apakah NamaSupplier sudah ada
    $existingQuery = mysqli_query($connection, "SELECT * FROM supplier WHERE NamaSupplier = '$namasupplier'");
    if (mysqli_num_rows($existingQuery) == 0) {
        mysqli_query($connection, "INSERT INTO supplier (NamaSupplier, NoTelp, Alamat, Kota, Provinsi) 
                                   VALUES ('$namasupplier', '$telp', '$alamat', '$kota', '$provinsi')");

        header("Location:supplier.php");
        exit();
    } else {
        echo "<script>alert('Nama Supplier ini sudah ada. Tidak dapat diinput ulang.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <title>Input Supplier</title>
    <link href="css/app.css" rel="stylesheet">
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
                    <h1 class="h3 mb-3">Edit Supplier</h1>
                </div>

                <form method="POST">
                    <div class="form-group row">
                        <label for="namasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputnama" id="namasupplier" placeholder="Nama Supplier" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="telp" class="col-sm-2 col-form-label">No Telp Supplier</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputtelp" id="telp" placeholder="Nomor Telepon Supplier" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat Supplier</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputalamat" id="alamat" placeholder="Alamat Supplier" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kota" class="col-sm-2 col-form-label">Kota Supplier</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputkota" id="kota" placeholder="Kota Supplier" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi Supplier</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputprovinsi" id="provinsi" placeholder="Provinsi Supplier" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="Simpan">
                            <a href="supplier.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</main>
</body>
</html>
