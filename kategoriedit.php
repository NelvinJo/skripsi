<?php
include "includes/config.php";

if (isset($_POST['Simpan'])) {
    if (isset($_REQUEST['inputkode'])) {
        $kategorikode = $_REQUEST['inputkode'];
    }
    if (!empty($kategorikode)) {
        $kategorikode = $_REQUEST['inputkode'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Kategori</h1>";
        die('Anda harus memasukkan datanya');
    }

    $namakategori = $_POST['inputkategori'];

    mysqli_query($connection, "UPDATE kategori SET NamaKategori='$namakategori' WHERE KategoriID = '$kategorikode'");

    if (isset($_REQUEST['kodesub'])) {
        $subkode = $_REQUEST['kodesub'];
    }
    if (!empty($subkode)) {
        $subkode = $_REQUEST['kodesub'];
    } else {
        echo "<h1>Anda harus mengisi data Kode Sub Kategori</h1>";
        die('Anda harus memasukkan datanya');
    }
    $kodekategori = $kategorikode;
    $namasub = $_POST['inputsub'];

    mysqli_query($connection, "UPDATE subkategori SET KategoriID='$kodekategori',NamaSubKategori='$namasub' WHERE SubID = '$subkode'");

    header("Location: kategori.php");
    exit();
}

$kodekategori = $_GET["ubahkategori"];
$editkategori = mysqli_query($connection, "SELECT * FROM kategori WHERE KategoriID = '$kodekategori'");
$rowedit = mysqli_fetch_array($editkategori);

$kodesub = $_GET["ubahsub"];
$editsub = mysqli_query($connection, "SELECT * FROM subkategori WHERE SubID = '$kodesub'");
$rowsub = mysqli_fetch_array($editsub);

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
<title>Kategori dan Sub Kategori</title>

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
                        <h1 class="display-4">Input Kategori</h1>
                    </div>
                </div>
                <form method="POST">
						<div class="form-group row">
							<label for="kodekategori" class="col-sm-2 col-form-label">Kode Kategori</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="kodekategori" name="inputkode" placeholder="Kode Kategori" maxlength="4" value="<?php echo $rowedit["KategoriID"]?>" readonly>
							</div>
						</div>

						<div class="form-group row">
							<label for="namakategori" class="col-sm-2 col-form-label">Nama Kategori</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputkategori" id="namakategori" placeholder="Nama Kategori" value="<?php echo $rowedit["NamaKategori"]?>">
							</div>
						</div>

                    <div class="jumbotron jumbotron-fluid mt-4">
                        <div class="container">
                            <h1 class="display-5">Input Sub Kategori</h1>
                        </div>
                    </div>

                    <form method="POST">
						<div class="form-group row">
							<label for="kodesub" class="col-sm-2 col-form-label">Kode Sub Kategori</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="kodesub" name="kodesub" placeholder="Kode Sub Kategori" maxlength="4" value="<?php echo $rowsub["SubID"]?>" readonly>
							</div>
						</div>

						<div class="form-group row">
							<label for="namasub" class="col-sm-2 col-form-label">Nama Sub Kategori</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputsub" id="namasub" placeholder="Nama Sub Kategori" value="<?php echo $rowsub["NamaSubKategori"]?>">
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
