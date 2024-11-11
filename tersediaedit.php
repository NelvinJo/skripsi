<?php
include "includes/config.php";

if (isset($_POST['Simpan'])) {
    if (isset($_REQUEST['inputkode'])) {
        $barangkode = $_REQUEST['inputkode'];
    }
    if (!empty($barangkode)) {
        $barangkode = $_REQUEST['inputkode'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Barang</h1>";
        die('Anda harus memasukkan datanya');
    }

    $kodekategori = $_POST['kodekategori'];
    $namabarang = $_POST['inputbarang'];
    $satuanbarang = $_POST['inputsatuan'];

    mysqli_query($connection, "UPDATE barangtersedia SET NamaKategori='$kodekategori', NamaBarang='$namabarang', SatuanBarang='$satuanbarang' WHERE BarangID = '$barangkode'");

    if (isset($_REQUEST['kodespek'])) {
        $spekkode = $_REQUEST['kodespek'];
    }
    if (!empty($spekkode)) {
        $spekkode = $_REQUEST['kodespek'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Detail Barang</h1>";
        die('Anda harus memasukkan datanya');
    }
    $kodetersedia = $barangkode;
    $kodetipe = $_POST['kodetipe'];
    $kodewarna = $_POST['kodewarna'];
    $jumlahbarang = $_POST['jumlahbarang'];
    $hargabarang = $_POST['hargabarang'];

    mysqli_query($connection, "UPDATE spesifikasibarang SET BarangID='$kodetersedia',NamaTipe='$kodetipe', NamaWarna='$kodewarna', JumlahStokBarang='$jumlahbarang', HargaBarang='$hargabarang' WHERE SpesifikasiID = '$spekkode'");

    header("Location: tersedia.php");
    exit();
}

$datakategori = mysqli_query($connection, "SELECT * FROM kategori");
$datatipe = mysqli_query($connection, "SELECT * FROM tipe");
$datawarna = mysqli_query($connection, "SELECT * FROM warna");

$kodebarang = $_GET["ubahtersedia"];
$editbarang = mysqli_query($connection, "SELECT * FROM barangtersedia WHERE BarangID = '$kodebarang'");
$rowedit = mysqli_fetch_array($editbarang);

$kodespek = $_GET["ubahspesifikasi"];
$editspek = mysqli_query($connection, "SELECT * FROM spesifikasibarang WHERE SpesifikasiID = '$kodespek'");
$rowspek = mysqli_fetch_array($editspek);

$editkategori = mysqli_query($connection, "SELECT * FROM barangtersedia, kategori WHERE barangtersedia.BarangID = '$kodebarang' AND barangtersedia.NamaKategori = kategori.NamaKategori");
$rowedit2 = mysqli_fetch_array($editkategori);

$edittipe = mysqli_query($connection, "SELECT * FROM spesifikasibarang, tipe WHERE spesifikasibarang.SpesifikasiID = '$kodespek' AND spesifikasibarang.NamaTipe = tipe.NamaTipe");
$rowtipe = mysqli_fetch_array($edittipe);

$editwarna = mysqli_query($connection, "SELECT * FROM spesifikasibarang, warna WHERE spesifikasibarang.SpesifikasiID = '$kodespek' AND spesifikasibarang.NamaWarna = warna.NamaWarna");
$rowwarna = mysqli_fetch_array($editwarna);
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
<title>Barang Tersedia dan Spesifikasi</title>

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
                        <h1 class="display-4">Input Barang Tersedia</h1>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group row">
                        <label for="kodebarang" class="col-sm-2 col-form-label">Kode Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodebarang" name="inputkode" value="<?php echo $rowedit['BarangID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kategori" class="col-sm-2 col-form-label">Kode Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kategori" name="kodekategori">
                                <option value="<?php echo $rowedit['NamaKategori']; ?>"> <?php echo $rowedit['NamaKategori'] . " - " . $rowedit2['KategoriID']; ?> </option>
                                <?php while ($row = mysqli_fetch_array($datakategori)) { ?>
                                    <option value="<?php echo $row["NamaKategori"]; ?>"><?php echo $row["KategoriID"] . " - " . $row["NamaKategori"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namabarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputbarang" id="namabarang" value="<?php echo $rowedit['NamaBarang']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="satuanbarang" class="col-sm-2 col-form-label">Satuan Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputsatuan" id="satuanbarang" value="<?php echo $rowedit['SatuanBarang']; ?>">
                        </div>
                    </div>

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Input Spesifikasi Barang</h1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodespek" class="col-sm-2 col-form-label">ID Spesifikasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodespek" name="kodespek" value="<?php echo $rowspek['SpesifikasiID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodetipe" class="col-sm-2 col-form-label">Kode Tipe</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodetipe" name="kodetipe">
                                <option value="<?php echo $rowspek['NamaTipe']; ?>"> <?php echo $rowspek['NamaTipe'] . " - " . $rowtipe['TipeID']; ?> </option>
                                <?php while ($row = mysqli_fetch_array($datatipe)) { ?>
                                    <option value="<?php echo $row["NamaTipe"]; ?>"><?php echo $row["TipeID"] . " - " . $row["NamaTipe"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="kodewarna" class="col-sm-2 col-form-label">Kode Warna</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodewarna" name="kodewarna">
                                <option value="<?php echo $rowspek['NamaWarna']; ?>"> <?php echo $rowspek['NamaWarna'] . " - " . $rowwarna['WarnaID']; ?> </option>
                                <?php while ($row = mysqli_fetch_array($datawarna)) { ?>
                                    <option value="<?php echo $row["NamaWarna"]; ?>"><?php echo $row["WarnaID"] . " - " . $row["NamaWarna"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jumlahbarang" id="jumlahbarang" value="<?php echo $rowspek['JumlahStokBarang']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="hargabarang" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="hargabarang" id="hargabarang" value="<?php echo $rowspek['HargaBarang']; ?>">
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
