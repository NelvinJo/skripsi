<?php
include "includes/config.php";

if (isset($_POST['Simpan'])) {
    if (isset($_REQUEST['inputkode'])) {
        $masukkode = $_REQUEST['inputkode'];
    }
    if (!empty($masukkode)) {
        $masukkode = $_REQUEST['inputkode'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Barang Masuk</h1>";
        die('Anda harus memasukkan datanya');
    }

    $checkMasuk = mysqli_query($connection, "SELECT * FROM barangmasuk WHERE BMID = '$masukkode'");
    
    if (mysqli_num_rows($checkMasuk) == 0) {
        $namasupp = $_POST['inputsupplier'];
        $tanggal = $_POST['inputtanggal'];

        mysqli_query($connection, "INSERT INTO barangmasuk (BMID, NamaSupplier, TanggalMasuk) 
                                   VALUES ('$masukkode', '$namasupp', '$tanggal')");
    }

    if (isset($_REQUEST['kodedm'])) {
        $dmkode = $_REQUEST['kodedm'];
    }
    if (!empty($dmkode)) {
        $dmkode = $_REQUEST['kodedm'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Detail Masuk</h1>";
        die('Anda harus memasukkan datanya');
    }

    $kodebm = $masukkode;
    $namaspek = $_POST['inputspek'];
    $jumlahbarang = $_POST['jumlahbarang'];

    mysqli_query($connection, "INSERT INTO detailbarangmasuk (DetailMasukID, BMID, SpesifikasiID, JumlahMasuk) 
                               VALUES ('$dmkode', '$kodebm', '$namaspek', '$jumlahbarang')");

    $updateStok = mysqli_query($connection, "UPDATE spesifikasibarang 
                                             SET JumlahStokBarang = JumlahStokBarang + '$jumlahbarang' 
                                             WHERE SpesifikasiID = '$namaspek'");

    if (!$updateStok) {
        echo "<h1>Gagal mengupdate stok barang</h1>";
        die('Terjadi kesalahan dalam mengupdate stok barang');
    }

    header("Location: masuk.php");
    exit();
}

$datasupplier = mysqli_query($connection, "SELECT * FROM supplier");
$dataspek = mysqli_query($connection, "SELECT * FROM spesifikasibarang");
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

<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
<title>Barang Masuk dan Detail Barang Masuk</title>

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
                        <h1 class="display-4">Input Barang Masuk</h1>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group row">
                        <label for="kodeproduk" class="col-sm-2 col-form-label">Kode Barang Masuk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodeproduk" name="inputkode" placeholder="Kode Barang Masuk" maxlength="4" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namasupp" class="col-sm-2 col-form-label">Nama Supplier</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="namasupp" name="inputsupplier" required>
                                <?php while ($row = mysqli_fetch_array($datasupplier)) { ?>
                                    <option value="<?php echo $row["NamaSupplier"]; ?>">
                                        <?php echo $row["SupplierID"] . " - " . $row["NamaSupplier"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="inputtanggal" id="tanggal" placeholder="Tanggal" required>
                        </div>
                    </div>

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Input Detail Barang Masuk</h1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodespek" class="col-sm-2 col-form-label">Kode Detail Masuk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodespek" name="kodedm" placeholder="Kode Detail Masuk" maxlength="4" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodespek" class="col-sm-2 col-form-label">Kode Spesifikasi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodespek" name="inputspek" required>
                                <?php while ($row = mysqli_fetch_array($dataspek)) { ?>
                                    <option value="<?php echo $row["SpesifikasiID"]; ?>">
                                        <?php echo $row["SpesifikasiID"] . " - " . $row["NamaTipe"] . " - " . $row["NamaWarna"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jumlahbarang" id="jumlahbarang" placeholder="Jumlah Barang" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 button-group">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="Simpan">
                            <input type="reset" class="btn btn-secondary" value="Batal" name="Batal">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/app.js"></script>
</body>
<?php include "footer.php"; ?>
</html>
