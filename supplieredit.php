<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}

include "includes/config.php";

$supplierkode = $_GET['ubahsupplier'];

$query = mysqli_query($connection, "SELECT * FROM supplier WHERE SupplierID = '$supplierkode'");
$rowedit = mysqli_fetch_assoc($query);

if (isset($_POST['Edit'])) {
    $namasupplier = $_POST['inputnama'];
    $telp = $_POST['inputtelp'];
    $alamat = $_POST['inputalamat'];
    $kota = $_POST['inputkota'];
    $provinsi = $_POST['inputprovinsi'];

    if (empty($namasupplier) || empty($telp) || empty($alamat) || empty($kota) || empty($provinsi)) {
        echo '<h1>Anda harus mengisi semua data</h1>';
        die("Anda harus memasukkan datanya");
    }

    $existingQuery = mysqli_query($connection, "SELECT * FROM supplier WHERE NamaSupplier = '$namasupplier' AND SupplierID != '$supplierkode'");
    if (mysqli_num_rows($existingQuery) == 0) {
        mysqli_query($connection, "UPDATE supplier SET NamaSupplier='$namasupplier', NoTelp='$telp', Alamat='$alamat', Kota='$kota', Provinsi='$provinsi' WHERE SupplierID = '$supplierkode'");

        header("Location:supplier.php");
        exit();
    } else {
        echo "<script>alert('Nama Supplier ini sudah ada. Tidak dapat diinput ulang.');</script>";
    }
}
$kodesupplier = $_GET["ubahsupplier"];
$editsupplier = mysqli_query($connection, "SELECT * FROM supplier WHERE SupplierID = '$kodesupplier'");
$rowedit = mysqli_fetch_array($editsupplier);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Edit Supplier</title>
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="h3 mb-3">Ubah Supplier</h1>
                        </div>

                        <form method="POST">
                            <div class="form-group row">
                                <label for="namasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="inputnama" id="namasupplier" placeholder="Nama Supplier" value="<?php echo htmlspecialchars($rowedit["NamaSupplier"]); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telp" class="col-sm-2 col-form-label">No Telp Supplier</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="inputtelp" id="telp" placeholder="Nomor Telepon Supplier" value="<?php echo htmlspecialchars($rowedit["NoTelp"]); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat Supplier</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="inputalamat" id="alamat" placeholder="Alamat Supplier" value="<?php echo htmlspecialchars($rowedit["Alamat"]); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kota" class="col-sm-2 col-form-label">Kota Supplier</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="inputkota" id="kota" placeholder="Kota Supplier" value="<?php echo htmlspecialchars($rowedit["Kota"]); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="provinsi" class="col-sm-2 col-form-label">Provinsi Supplier</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="inputprovinsi" id="provinsi" placeholder="Provinsi Supplier" value="<?php echo htmlspecialchars($rowedit["Provinsi"]); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Ubah" name="Edit">
                                    <a href="supplier.php" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>
    <script src="js/app.js"></script>
</main>
</body>
</html>
