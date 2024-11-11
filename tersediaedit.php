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

    // Update barangtersedia untuk NamaBarang, SubKategori, dan SatuanBarang
    mysqli_query($connection, "UPDATE barangtersedia SET NamaBarang='$namabarang', SubID='$subkategori', SatuanBarang='$satuanbarang' WHERE BarangID='$barangID'");

    // Update spesifikasibarang untuk atribut terkait lainnya
    mysqli_query($connection, "UPDATE spesifikasibarang SET BarangID='$barangID', BentukID='$kodetipe', WarnaID='$kodewarna', JumlahStokBarang='$jumlahbarang', HargaBarang='$hargabarang' WHERE SpesifikasiID='$spekkode'");

    header("Location: tersedia2.php");
    exit();
}

// Fetch data from related tables
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
    <title>Edit Spesifikasi Barang</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <form method="POST">
                    <input type="hidden" name="kodespek" value="<?php echo $rowspek['SpesifikasiID']; ?>">
                    <input type="hidden" name="barangid" value="<?php echo $rowBarangTersedia['BarangID']; ?>">

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

                    <!-- Input for Nama Barang -->
                    <div class="form-group row">
                        <label for="namabarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namabarang" name="namabarang" value="<?php echo $rowBarangTersedia['NamaBarang']; ?>">
                        </div>
                    </div>

                    <!-- Input for Satuan Barang -->
                    <div class="form-group row">
                        <label for="satuanbarang" class="col-sm-2 col-form-label">Satuan Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="satuanbarang" name="satuanbarang" value="<?php echo $rowBarangTersedia['SatuanBarang']; ?>">
                        </div>
                    </div>

                    <!-- Dropdown for Kode Tipe -->
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

                    <!-- Dropdown for Kode Warna -->
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

                    <!-- Input for Jumlah Stok -->
                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlahbarang" name="jumlahbarang" value="<?php echo $rowspek['JumlahStokBarang']; ?>">
                        </div>
                    </div>

                    <!-- Input for Harga Barang -->
                    <div class="form-group row">
                        <label for="hargabarang" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hargabarang" name="hargabarang" value="<?php echo $rowspek['HargaBarang']; ?>">
                        </div>
                    </div>

                    <!-- Submit and Reset buttons -->
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

<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</body>
</html>
