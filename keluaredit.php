<?php
include "includes/config.php";

if (isset($_POST['Simpan'])) {
    if (isset($_REQUEST['inputkode'])) {
        $keluarkode = $_REQUEST['inputkode'];
    }
    if (!empty($keluarkode)) {
        $keluarkode = $_REQUEST['inputkode'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Barang Keluar</h1>";
        die('Anda harus memasukkan datanya');
    }

    $namapelanggan = $_POST['inputpelanggan'];
    $tanggal = $_POST['inputtanggal'];

    mysqli_query($connection, "UPDATE barangkeluar SET NamaPelanggan='$namapelanggan', TanggalKeluar='$tanggal' WHERE BKID = '$keluarkode'");

    if (isset($_REQUEST['kodedk'])) {
        $dkkode = $_REQUEST['kodedk'];
    }
    if (!empty($dkkode)) {
        $dkkode = $_REQUEST['kodedk'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Detail Barang Keluar</h1>";
        die('Anda harus memasukkan datanya');
    }
    $kodebk = $keluarkode;
    $namaspek = $_POST['inputspek'];
    $jumlahbarang_baru = $_POST['jumlahbarang'];

    $query = mysqli_query($connection, "SELECT JumlahKeluar FROM detailbarangkeluar WHERE DetailKeluarID = '$dkkode'");
    $row = mysqli_fetch_array($query);
    $jumlahbarang_lama = $row['JumlahKeluar'];

    $selisih = $jumlahbarang_baru - $jumlahbarang_lama;
    mysqli_query($connection, "UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang - $selisih WHERE SpesifikasiID = '$namaspek'");

    mysqli_query($connection, "UPDATE detailbarangkeluar SET BKID='$kodebk', SpesifikasiID='$namaspek', JumlahKeluar='$jumlahbarang_baru' WHERE DetailKeluarID = '$dkkode'");

    header("Location: keluar.php");
    exit();
}

$dataspek = mysqli_query($connection, "SELECT * FROM spesifikasibarang");

$kodekeluar = $_GET["ubahkeluar"];
$editkeluar = mysqli_query($connection, "SELECT * FROM barangkeluar WHERE BKID = '$kodekeluar'");
$rowedit = mysqli_fetch_array($editkeluar);

$kodedk = $_GET["ubahdk"];
$editdk = mysqli_query($connection, "SELECT * FROM detailbarangkeluar WHERE DetailKeluarID = '$kodedk'");
$rowdk = mysqli_fetch_array($editdk);

$editspek = mysqli_query($connection, "SELECT * FROM detailbarangkeluar, spesifikasibarang WHERE detailbarangkeluar.DetailKeluarID = '$kodedk' AND detailbarangkeluar.SpesifikasiID = spesifikasibarang.SpesifikasiID");
$rowedit2 = mysqli_fetch_array($editspek);

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
<title>Barang Keluar dan Detail</title>

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
                        <h1 class="display-4">Edit Barang Keluar</h1>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group row">
                        <label for="kodebarang" class="col-sm-2 col-form-label">Kode Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodebarang" name="inputkode" value="<?php echo $rowedit['BKID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pelanggan" name="inputpelanggan" value="<?php echo $rowedit['NamaPelanggan']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="inputtanggal" id="tanggal" value="<?php echo $rowedit['TanggalKeluar']; ?>">
                        </div>
                    </div>

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Edit Detail Barang Keluar</h1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodedk" class="col-sm-2 col-form-label">Kode Detail Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodedk" name="kodedk" value="<?php echo $rowdk['DetailKeluarID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namaspek" class="col-sm-2 col-form-label">Kode Spesifikasi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="namaspek" name="inputspek">
                                <option value="<?php echo $rowdk['SpesifikasiID']; ?>"> <?php echo $rowdk['SpesifikasiID'] . " - " . $rowedit2['NamaTipe']. " - " . $rowedit2['NamaWarna']; ?> </option>
                                <?php while ($row = mysqli_fetch_array($dataspek)) { ?>
                                    <option value="<?php echo $row["SpesifikasiID"]; ?>"><?php echo $row["SpesifikasiID"] . " - " . $row["NamaTipe"]. " - " . $row["NamaWarna"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jumlahbarang" id="jumlahbarang" value="<?php echo $rowdk['JumlahKeluar']; ?>">
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
