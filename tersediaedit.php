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
    $spekkode = $_POST['kodespek'];
    $barangID = $_POST['barangid'];
    $namabarang = $_POST['namabarang'];
    $subkategori = $_POST['subkategori'];
    $satuanbarang = $_POST['satuanbarang'];
    $kodetipe = $_POST['kodetipe'];
    $kodewarna = $_POST['kodewarna'];
    $jumlahbarang = $_POST['jumlahbarang'];
    $hargabarang = $_POST['hargabarang'];

    mysqli_query($connection, "UPDATE barangtersedia SET NamaBarang='$namabarang', SubID='$subkategori', SatuanBarang='$satuanbarang' WHERE BarangID='$barangID'");

    mysqli_query($connection, "UPDATE spesifikasibarang SET BarangID='$barangID', BentukID='$kodetipe', WarnaID='$kodewarna', JumlahStokBarang='$jumlahbarang', HargaBarang='$hargabarang' WHERE SpesifikasiID='$spekkode'");

    header("Location: tersedia.php");
    exit();
}

$datasubkategori = mysqli_query($connection, "SELECT * FROM subkategori");
$databentuk = mysqli_query($connection, "SELECT * FROM bentuk");
$datawarna = mysqli_query($connection, "SELECT * FROM warna");

$kodespek = $_GET["ubahspesifikasi"];
$editspek = mysqli_query($connection, "SELECT * FROM spesifikasibarang WHERE SpesifikasiID = '$kodespek'");
$rowspek = mysqli_fetch_array($editspek);

$barangID = $rowspek['BarangID'];
$dataBarangTersedia = mysqli_query($connection, "SELECT * FROM barangtersedia WHERE BarangID = '$barangID'");
$rowBarangTersedia = mysqli_fetch_array($dataBarangTersedia);
?>

<!DOCTYPE html>
<html>
<head>
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
                <form method="POST">
                    <input type="hidden" name="kodespek" value="<?php echo $rowspek['SpesifikasiID']; ?>">
                    <input type="hidden" name="barangid" value="<?php echo $rowBarangTersedia['BarangID']; ?>">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h1 class="h3 mb-3">Edit Barang Tersedia</h1>
                </div>
                    <div class="form-group row">
                        <label for="subkategori" class="col-sm-2 col-form-label">Sub Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="subkategori" name="subkategori">
                                <option value="">Pilih Sub</option>
                                <?php while ($row = mysqli_fetch_array($datasubkategori)) { ?>
                                    <option value="<?php echo $row["SubID"]; ?>" <?php if ($rowBarangTersedia['SubID'] == $row["SubID"]) echo "selected"; ?>><?php echo $row["NamaSubKategori"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namabarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namabarang" name="namabarang" value="<?php echo $rowBarangTersedia['NamaBarang']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="satuanbarang" class="col-sm-2 col-form-label">Satuan Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="satuanbarang" name="satuanbarang" value="<?php echo $rowBarangTersedia['SatuanBarang']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodetipe" class="col-sm-2 col-form-label">Kode Tipe</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodetipe" name="kodetipe">
                                <option value="">Pilih Bentuk</option>
                                <?php while ($row = mysqli_fetch_array($databentuk)) { ?>
                                    <option value="<?php echo $row["BentukID"]; ?>" <?php if ($rowspek['BentukID'] == $row["BentukID"]) echo "selected"; ?>><?php echo $row["NamaBentuk"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodewarna" class="col-sm-2 col-form-label">Kode Warna</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodewarna" name="kodewarna">
                                <option value="">Pilih Warna</option>
                                <?php while ($row = mysqli_fetch_array($datawarna)) { ?>
                                    <option value="<?php echo $row["WarnaID"]; ?>" <?php if ($rowspek['WarnaID'] == $row["WarnaID"]) echo "selected"; ?>><?php echo $row["NamaWarna"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlahbarang" name="jumlahbarang" value="<?php echo $rowspek['JumlahStokBarang']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="hargabarang" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hargabarang" name="hargabarang" value="<?php echo $rowspek['HargaBarang']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 button-group">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="Simpan">
                            <a href="tersedia.php" class="btn btn-secondary">Batal</a>
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
