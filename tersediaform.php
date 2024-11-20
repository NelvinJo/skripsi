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
    $subkategori = $_POST['subkategori'];
    $namabarang = $_POST['inputbarang'];
    $satuanbarang = $_POST['inputsatuan'];
    $bentukid = $_POST['bentukid'];
    $warnaid = $_POST['warnaid'];
    $jumlahbarang = $_POST['jumlahbarang'];
    $hargabarang = $_POST['hargabarang'];

    $existingQuery = mysqli_query($connection, "SELECT * FROM barangtersedia 
                                                JOIN spesifikasibarang 
                                                ON barangtersedia.BarangID = spesifikasibarang.BarangID 
                                                WHERE barangtersedia.SubID = '$subkategori' 
                                                AND barangtersedia.NamaBarang = '$namabarang' 
                                                AND spesifikasibarang.BentukID = '$bentukid' 
                                                AND spesifikasibarang.WarnaID = '$warnaid'");
    
    if (mysqli_num_rows($existingQuery) == 0) {
        mysqli_query($connection, "INSERT INTO barangtersedia (SubID, NamaBarang, SatuanBarang) 
                                   VALUES ('$subkategori', '$namabarang', '$satuanbarang')");
        $barangid = mysqli_insert_id($connection);

        mysqli_query($connection, "INSERT INTO spesifikasibarang (BarangID, BentukID, WarnaID, JumlahStokBarang, HargaBarang) 
                                   VALUES ('$barangid', '$bentukid', '$warnaid', '$jumlahbarang', '$hargabarang')");

        header("Location: tersedia.php");
        exit();
    }
    else {
        echo "<script>alert('Data ini sudah ada. Tidak dapat diinput ulang.');</script>";
    }
}

if (isset($_POST['SimpanBentuk'])) {
    $namaBentuk = $_POST['namabentuk'];
    mysqli_query($connection, "INSERT INTO bentuk (NamaBentuk) VALUES ('$namaBentuk')");
}

if (isset($_POST['SimpanWarna'])) {
    $namaWarna = $_POST['namawarna'];
    mysqli_query($connection, "INSERT INTO warna (NamaWarna) VALUES ('$namaWarna')");
}

if (isset($_POST['HapusBentuk'])) {
    $bentukID = $_POST['bentukid'];
    mysqli_query($connection, "DELETE FROM bentuk WHERE BentukID = '$bentukID'");
}

if (isset($_POST['HapusWarna'])) {
    $warnaID = $_POST['warnaid'];
    mysqli_query($connection, "DELETE FROM warna WHERE WarnaID = '$warnaID'");
}

$datasubkategori = mysqli_query($connection, "SELECT * FROM subkategori");
$databentuk = mysqli_query($connection, "SELECT * FROM bentuk");
$datawarna = mysqli_query($connection, "SELECT * FROM warna");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Barang Tersedia dan Spesifikasi</title>
<link href="css/app.css" rel="stylesheet">
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
    .popup-form input, .popup-form button {
        width: 100%;
        margin-top: 10px;
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
                <div class="jumbotron jumbotron-fluid"></div>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h1 class="h3 mb-3">Form Barang Tersedia</h1>
                </div>
                
                <form method="POST">
                    <div class="form-group row">
                        <label for="subkategori" class="col-sm-2 col-form-label">Sub Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="subkategori" required>
                                <?php while ($row = mysqli_fetch_array($datasubkategori)) { ?>
                                    <option value="<?php echo $row["SubID"]; ?>">
                                        <?php echo $row["NamaSubKategori"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="namabarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputbarang" id="namabarang" placeholder="Nama Barang" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuanbarang" class="col-sm-2 col-form-label">Satuan Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputsatuan" id="satuanbarang" placeholder="Satuan Barang" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bentukid" class="col-sm-2 col-form-label">Bentuk</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="bentukid" required>
                                <?php while ($row = mysqli_fetch_array($databentuk)) { ?>
                                    <option value="<?php echo $row["BentukID"]; ?>">
                                        <?php echo $row["NamaBentuk"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="warnaid" class="col-sm-2 col-form-label">Warna</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="warnaid" required>
                                <?php while ($row = mysqli_fetch_array($datawarna)) { ?>
                                    <option value="<?php echo $row["WarnaID"]; ?>">
                                        <?php echo $row["NamaWarna"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlahbarang" class="col-sm-2 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="jumlahbarang" id="jumlahbarang" placeholder="Jumlah Barang" min="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hargabarang" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="hargabarang" id="hargabarang" placeholder="Harga Barang" min="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="Simpan">
                            <a href="tersedia.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="button" style="background-color: #222e3c" onclick="openPopup('bentukForm')" class="btn btn-secondary mr-2">Form Bentuk</button>
                            <button type="button" style="background-color: #222e3c" onclick="openPopup('warnaForm')" class="btn btn-secondary">Form Warna</button>
                        </div>
                    </div>
                </form>

                <div id="bentukForm" class="popup-form">
                    <div class="close-popup" onclick="closePopup('bentukForm')">&times;</div>
                    <h4>Form Bentuk</h4>
                    <form method="POST">
                        <input type="text" name="namabentuk" class="form-control" placeholder="Nama Bentuk" required>
                        <button type="submit" name="SimpanBentuk" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                    <form method="POST" class="mt-3">
                        <select name="bentukid" class="form-control" required>
                            <option value="" disabled selected>Pilih Bentuk untuk Dihapus</option>
                            <?php mysqli_data_seek($databentuk, 0); while ($row = mysqli_fetch_array($databentuk)) { ?>
                                <option value="<?php echo $row['BentukID']; ?>">
                                    <?php echo $row['NamaBentuk']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" name="HapusBentuk" class="btn btn-danger mt-3">Hapus
                        </form>
                </div>

                <div id="warnaForm" class="popup-form">
                    <div class="close-popup" onclick="closePopup('warnaForm')">&times;</div>
                    <h4>Form Warna</h4>
                    <form method="POST">
                        <input type="text" name="namawarna" class="form-control" placeholder="Nama Warna" required>
                        <button type="submit" name="SimpanWarna" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                    <form method="POST" class="mt-3">
                        <select name="warnaid" class="form-control" required>
                            <option value="" disabled selected>Pilih Warna untuk Dihapus</option>
                            <?php mysqli_data_seek($datawarna, 0); while ($row = mysqli_fetch_array($datawarna)) { ?>
                                <option value="<?php echo $row['WarnaID']; ?>">
                                    <?php echo $row['NamaWarna']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" name="HapusWarna" class="btn btn-danger mt-3">Hapus
                        </form>
                </div>
                </div>
                    
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <?php include "footer.php"; ?>
                    <script src="js/app.js"></script>
                    </main>
    </div>


<script>
function openPopup(formId) {
    document.getElementById(formId).style.display = 'block';
}

function closePopup(formId) {
    document.getElementById(formId).style.display = 'none';
}
</script>
</body>
</html>