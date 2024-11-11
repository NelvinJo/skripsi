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

    $checkKeluar = mysqli_query($connection, "SELECT * FROM barangkeluar WHERE BKID = '$keluarkode'");
    
    if (mysqli_num_rows($checkKeluar) == 0) {
        $namapelanggan = $_POST['inputpelanggan'];
        $tanggal = $_POST['inputtanggal'];

        mysqli_query($connection, "INSERT INTO barangkeluar (BKID, NamaPelanggan, TanggalKeluar) 
                                   VALUES ('$keluarkode', '$namapelanggan', '$tanggal')");
    }

    if (isset($_REQUEST['kodedk'])) {
        $dkkode = $_REQUEST['kodedk'];
    }
    if (!empty($dkkode)) {
        $dkkode = $_REQUEST['kodedk'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Detail Keluar</h1>";
        die('Anda harus memasukkan datanya');
    }

    $kodebk = $keluarkode;
    $namaspek = $_POST['inputspek'];
    $jumlahbarang = $_POST['jumlahbarang'];

    mysqli_query($connection, "INSERT INTO detailbarangkeluar (DetailKeluarID, BKID, SpesifikasiID, JumlahKeluar) 
                               VALUES ('$dkkode', '$kodebk', '$namaspek', '$jumlahbarang')");

    $updateStok = mysqli_query($connection, "UPDATE spesifikasibarang 
                                             SET JumlahStokBarang = JumlahStokBarang - '$jumlahbarang' 
                                             WHERE SpesifikasiID = '$namaspek'");

    if (!$updateStok) {
        echo "<h1>Gagal mengupdate stok barang</h1>";
        die('Terjadi kesalahan dalam mengupdate stok barang');
    }

    header("Location: keluar.php");
    exit();
}

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
                        <h1 class="display-4">Input Barang Keluar</h1>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group row">
                        <label for="kodeproduk" class="col-sm-2 col-form-label">Kode Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodeproduk" name="inputkode" placeholder="Kode Barang Keluar" maxlength="4" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pelanggan" name="inputpelanggan" placeholder="Nama Pelanggan" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Keluar</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="inputtanggal" id="tanggal" placeholder="Tanggal Barang Keluar" required>
                        </div>
                    </div>

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Input Detail Barang Keluar</h1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodekeluar" class="col-sm-2 col-form-label">Kode Detail Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodekeluar" name="kodedk" placeholder="Kode Detail Barang Keluar" maxlength="4" required>
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
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Barang Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jumlahbarang" id="jumlahbarang" placeholder="Jumlah Barang Keluar" required>
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