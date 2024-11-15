<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_POST['SimpanKategori'])) {
    if (!empty($_POST['inputkategori'])) {
        $namakategori = $_POST['inputkategori'];
        
        $checkKategori = mysqli_query($connection, "SELECT * FROM kategori WHERE NamaKategori = '$namakategori'");
        
        if (mysqli_num_rows($checkKategori) == 0) {
            mysqli_query($connection, "INSERT INTO kategori (NamaKategori) VALUES ('$namakategori')");
        }
    } else {
        echo "<h1>Anda harus mengisi Nama Kategori</h1>";
        die('Anda harus memasukkan data Nama Kategori');
    }
}

if (isset($_POST['SimpanSubKategori'])) {
    if (!empty($_POST['kategoridropdown']) && !empty($_POST['inputsub'])) {
        $kodekategori = $_POST['kategoridropdown'];
        $namasub = $_POST['inputsub'];

        mysqli_query($connection, "INSERT INTO subkategori (KategoriID, NamaSubKategori) VALUES ('$kodekategori', '$namasub')");
    } else {
        echo "<h1>Anda harus memilih Kategori dan mengisi Nama Sub Kategori</h1>";
        die('Anda harus memasukkan datanya');
    }

    header("Location: kategori.php");
    exit();
}

$datakategori = mysqli_query($connection, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
<meta name="author" content="AdminKit">
<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
<title>Kategori dan Sub Kategori</title>

<link href="css/app.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
                    <h1 class="h3 mb-3">Form Kategori</h1>
                </div>

                <form method="POST">
                    <div class="form-group row">
                        <label for="inputkategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputkategori" id="inputkategori" placeholder="Nama Kategori">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 button-group">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="SimpanKategori">
                            <input type="reset" class="btn btn-secondary" value="Reset" name="Reset">
                        </div>
                    </div>
                </form>

                <hr>

                <form method="POST">
                    <div class="form-group row">
                        <label for="kategoridropdown" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategoridropdown" id="kategoridropdown">
                                <option value="">Pilih Kategori</option>
                                <?php while ($row = mysqli_fetch_array($datakategori)) { ?>
                                    <option value="<?php echo $row['KategoriID']; ?>"><?php echo $row['NamaKategori']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputsub" class="col-sm-2 col-form-label">Nama Sub Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputsub" id="inputsub" placeholder="Nama Sub Kategori">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 button-group">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Simpan" name="SimpanSubKategori">
                            <input type="reset" class="btn btn-secondary" value="Reset" name="Reset">
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
</main>
</html>