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

    $checkBarang = mysqli_query($connection, "SELECT * FROM barangtersedia WHERE BarangID = '$barangkode'");
    
    if (mysqli_num_rows($checkBarang) == 0) {
        $kodekategori = $_POST['kodekategori'];
        $namabarang = $_POST['inputbarang'];
        $satuanbarang = $_POST['inputsatuan'];

        mysqli_query($connection, "INSERT INTO barangtersedia (BarangID, NamaKategori, NamaBarang, SatuanBarang) 
                                   VALUES ('$barangkode', '$kodekategori', '$namabarang', '$satuanbarang')");
    }

    if (isset($_REQUEST['kodespek'])) {
        $spekkode = $_REQUEST['kodespek'];
    }
    if (!empty($spekkode)) {
        $spekkode = $_REQUEST['kodespek'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Spesifikasi</h1>";
        die('Anda harus memasukkan datanya');
    }

    $kodetersedia = $barangkode;
    $kodetipe = $_POST['kodetipe'];
    $kodewarna = $_POST['kodewarna'];
    $jumlahbarang = $_POST['jumlahbarang'];
    $hargabarang = $_POST['hargabarang'];

    mysqli_query($connection, "INSERT INTO spesifikasibarang (SpesifikasiID, BarangID, NamaTipe, NamaWarna, JumlahStokBarang, HargaBarang) 
                               VALUES ('$spekkode', '$kodetersedia', '$kodetipe', '$kodewarna', '$jumlahbarang', '$hargabarang')");

    header("Location: tersedia.php");
    exit();
}

if (isset($_POST['SimpanWarna'])) {
    $warnaID = $_POST['warnaid'];
    $namaWarna = $_POST['namawarna'];
    mysqli_query($connection, "INSERT INTO warna (WarnaID, NamaWarna) VALUES ('$warnaID', '$namaWarna')");
}

if (isset($_POST['SimpanTipe'])) {
    $tipeID = $_POST['tipeid'];
    $namaTipe = $_POST['namatipe'];
    mysqli_query($connection, "INSERT INTO tipe (TipeID, NamaTipe) VALUES ('$tipeID', '$namaTipe')");
}
if (isset($_POST['HapusWarna'])) {
    $warnaID = $_POST['warnaid'];
    mysqli_query($connection, "DELETE FROM warna WHERE WarnaID = '$warnaID'");
}

if (isset($_POST['HapusTipe'])) {
    $tipeID = $_POST['tipeid'];
    mysqli_query($connection, "DELETE FROM tipe WHERE TipeID = '$tipeID'");
}

$datakategori = mysqli_query($connection, "SELECT * FROM kategori");
$databentuk = mysqli_query($connection, "SELECT * FROM bentuk");
$datawarna = mysqli_query($connection, "SELECT * FROM warna");
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
    .button-group {
        margin-top: 10px;
    }
</style>
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
                        <label for="kodeproduk" class="col-sm-2 col-form-label">Kode Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodeproduk" name="inputkode" placeholder="Kode Barang" maxlength="4" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodekategori" class="col-sm-2 col-form-label">Kode Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kategori" name="kodekategori" required>
                                <?php while ($row = mysqli_fetch_array($datakategori)) { ?>
                                    <option value="<?php echo $row["NamaKategori"]; ?>">
                                        <?php echo $row["KategoriID"] . " - " . $row["NamaKategori"]; ?>
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

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Input Spesifikasi Barang</h1>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kodespek" class="col-sm-2 col-form-label">Kode Spesifikasi Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kodespek" name="kodespek" placeholder="Kode Spesifikasi Barang" maxlength="4" required>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="kodetipe" class="col-sm-2 col-form-label">Kode Tipe</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodetipe" name="kodetipe" required>
                                <?php while ($row = mysqli_fetch_array($databentuk)) { ?>
                                    <option value="<?php echo $row["NamaBentuk"]; ?>">
                                        <?php echo $row["BentukID"] . " - " . $row["NamaBentuk"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="kodewarna" class="col-sm-2 col-form-label">Kode Warna</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kodewarna" name="kodewarna" required>
                                <?php while ($row = mysqli_fetch_array($datawarna)) { ?>
                                    <option value="<?php echo $row["NamaWarna"]; ?>">
                                        <?php echo $row["WarnaID"] . " - " . $row["NamaWarna"]; ?>
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
                        <label for="hargabarang" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="hargabarang" id="hargabarang" placeholder="Harga Barang" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 button-group">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="Simpan">
                            <input type="reset" class="btn btn-secondary" value="Batal" name="Batal">
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="button" style="background-color: #222e3c" onclick="openPopup('tipeForm')" class="btn btn-secondary mr-2">Tipe</button>
                            <button type="button" style="background-color: #222e3c" onclick="openPopup('warnaForm')" class="btn btn-secondary">Warna</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="tipeForm" class="popup-form">
    <span class="close-popup" onclick="closePopup('tipeForm')">&times;</span>
    <h3>Tipe</h3>
    <form method="POST">
        <input type="text" name="tipeid" placeholder="Tipe ID" required>
        <input type="text" name="namatipe" placeholder="Nama Tipe" required>
        <button type="submit" class="btn btn-primary" name="SimpanTipe">Simpan Tipe</button>
    </form>
    <form method="POST" class="mt-2">
        <select name="tipeid" required>
            <?php
            $datatipe = mysqli_query($connection, "SELECT * FROM tipe"); // Refresh data
            while ($row = mysqli_fetch_array($datatipe)) { ?>
                <option value="<?php echo $row["TipeID"]; ?>"><?php echo $row["NamaTipe"]; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="HapusTipe" class="btn btn-danger">Hapus Tipe</button>
    </form>
</div>

<div id="warnaForm" class="popup-form">
    <span class="close-popup" onclick="closePopup('warnaForm')">&times;</span>
    <h3>Warna</h3>
    <form method="POST">
        <input type="text" name="warnaid" placeholder="Warna ID" required>
        <input type="text" name="namawarna" placeholder="Nama Warna" required>
        <button type="submit" name="SimpanWarna" class="btn btn-primary">Simpan Warna</button>
    </form>
    <form method="POST" class="mt-2">
        <select name="warnaid" required>
            <?php
            $datawarna = mysqli_query($connection, "SELECT * FROM warna"); // Refresh data
            while ($row = mysqli_fetch_array($datawarna)) { ?>
                <option value="<?php echo $row["WarnaID"]; ?>"><?php echo $row["NamaWarna"]; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="HapusWarna" class="btn btn-danger">Hapus Warna</button>
    </form>
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
<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</html>