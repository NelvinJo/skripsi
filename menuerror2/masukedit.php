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

    $namasupp = $_POST['inputsupplier'];
    $tanggal = $_POST['inputtanggal'];

    mysqli_query($connection, "UPDATE barangmasuk SET NamaSupplier='$namasupp', TanggalMasuk='$tanggal' WHERE BMID = '$masukkode'");

    if (isset($_REQUEST['kodedm'])) {
        $dmkode = $_REQUEST['kodedm'];
    }
    if (!empty($dmkode)) {
        $dmkode = $_REQUEST['kodedm'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Detail Barang Masuk</h1>";
        die('Anda harus memasukkan datanya');
    }
    $kodebm = $masukkode;
    $namaspek = $_POST['inputspek'];
    $jumlahbarang_baru = $_POST['jumlahbarang'];

    $query = mysqli_query($connection, "SELECT JumlahMasuk FROM detailbarangmasuk WHERE DetailMasukID = '$dmkode'");
    $row = mysqli_fetch_array($query);
    $jumlahbarang_lama = $row['JumlahMasuk'];

    $selisih = $jumlahbarang_baru - $jumlahbarang_lama;
    mysqli_query($connection, "UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang + $selisih WHERE SpesifikasiID = '$namaspek'");

    mysqli_query($connection, "UPDATE detailbarangmasuk SET BMID='$kodebm', SpesifikasiID='$namaspek', JumlahMasuk='$jumlahbarang_baru' WHERE DetailMasukID = '$dmkode'");

    header("Location: masuk.php");
    exit();
}

$datasupplier = mysqli_query($connection, "SELECT * FROM supplier");
$dataspek = mysqli_query($connection, "SELECT * FROM spesifikasibarang");

$kodemasuk = $_GET["ubahmasuk"];
$editmasuk = mysqli_query($connection, "SELECT * FROM barangmasuk WHERE BMID = '$kodemasuk'");
$rowedit = mysqli_fetch_array($editmasuk);

$kodedm = $_GET["ubahdm"];
$editdm = mysqli_query($connection, "SELECT * FROM detailbarangmasuk WHERE DetailMasukID = '$kodedm'");
$rowdm = mysqli_fetch_array($editdm);

$editsupplier = mysqli_query($connection, "SELECT * FROM barangmasuk, supplier WHERE barangmasuk.BMID = '$kodemasuk' AND barangmasuk.NamaSupplier = supplier.NamaSupplier");
$rowedit2 = mysqli_fetch_array($editsupplier);

$editspek = mysqli_query($connection, "SELECT * FROM detailbarangmasuk, spesifikasibarang WHERE detailbarangmasuk.DetailMasukID = '$kodedm' AND detailbarangmasuk.SpesifikasiID = spesifikasibarang.SpesifikasiID");
$rowedit3 = mysqli_fetch_array($editspek);
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
                        <h1 class="display-4">Edit Barang Masuk</h1>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group row">
                        <label for="kodebarang" class="col-sm-2 col-form-label">Kode Barang Masuk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodebarang" name="inputkode" value="<?php echo $rowedit['BMID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namasupp" class="col-sm-2 col-form-label">Nama Supplier</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="namasupp" name="inputsupplier">
                                <option value="<?php echo $rowedit['NamaSupplier']; ?>"> <?php echo $rowedit['NamaSupplier'] . " - " . $rowedit2['SupplierID']; ?> </option>
                                <?php while ($row = mysqli_fetch_array($datasupplier)) { ?>
                                    <option value="<?php echo $row["NamaSupplier"]; ?>"><?php echo $row["SupplierID"] . " - " . $row["NamaSupplier"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Barang Masuk</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="inputtanggal" id="tanggal" value="<?php echo $rowedit['TanggalMasuk']; ?>">
                        </div>
                    </div>

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Edit Detail Barang Masuk</h1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodedm" class="col-sm-2 col-form-label">Kode Detail Barang Masuk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodedm" name="kodedm" value="<?php echo $rowdm['DetailMasukID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namaspek" class="col-sm-2 col-form-label">Spesifikasi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="namaspek" name="inputspek">
                                <option value="<?php echo $rowdm['SpesifikasiID']; ?>"> <?php echo $rowdm['SpesifikasiID'] . " - " . $rowedit3['NamaTipe']. " - " . $rowedit3['NamaWarna']; ?> </option>
                                <?php while ($row = mysqli_fetch_array($dataspek)) { ?>
                                    <option value="<?php echo $row["SpesifikasiID"]; ?>"><?php echo $row["SpesifikasiID"] . " - " . $row["NamaTipe"]. " - " . $row["NamaWarna"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Barang Masuk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jumlahbarang" id="jumlahbarang" value="<?php echo $rowdm['JumlahMasuk']; ?>">
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

</body>
<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</html>