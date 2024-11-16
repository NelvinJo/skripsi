<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}

include "includes/config.php";

if (isset($_POST['EditSub'])) {
    $kodesub = $_POST['subid'];
    $namakategori = trim($_POST['inputkategori']) ?? '';
    $namasubkategori = trim($_POST['inputsub']) ?? '';

    if (!empty($namakategori) && !empty($namasubkategori)) {
        // Cek apakah kategori sudah ada
        $checkKategori = mysqli_query($connection, "SELECT * FROM kategori WHERE NamaKategori = '$namakategori'");
        if (mysqli_num_rows($checkKategori) == 0) {
            // Tambahkan kategori baru jika tidak ada
            mysqli_query($connection, "INSERT INTO kategori (NamaKategori) VALUES ('$namakategori')");
        }

        // Ambil ID Kategori
        $kategoriRow = mysqli_fetch_assoc(mysqli_query($connection, "SELECT KategoriID FROM kategori WHERE NamaKategori = '$namakategori'"));
        $kategoriID = $kategoriRow['KategoriID'];

        // Cek apakah SubKategori dengan nama yang sama dan kategori yang sama sudah ada
        $checkSubKategori = mysqli_query($connection, "SELECT * FROM subkategori WHERE NamaSubKategori = '$namasubkategori' AND KategoriID = '$kategoriID' AND SubID != '$kodesub'");
        if (mysqli_num_rows($checkSubKategori) == 0) {
            // Update subkategori jika tidak duplikat
            mysqli_query($connection, "UPDATE subkategori SET KategoriID='$kategoriID', NamaSubKategori='$namasubkategori' WHERE SubID='$kodesub'");
            header("Location: kategori.php");
            exit();
        } else {
            echo "<script>alert('Data ini sudah ada. Tidak dapat diinput ulang.');</script>";
        }
    } else {
        echo "<script>alert('Data kategori atau subkategori tidak boleh kosong.');</script>";
    }
}

$kodesub = $_GET["ubahsub"];
$editsub = mysqli_query($connection, "SELECT * FROM subkategori s JOIN kategori k ON s.KategoriID = k.KategoriID WHERE s.SubID = '$kodesub'");
$rowsub = mysqli_fetch_array($editsub);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Edit Sub Kategori</title>
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
            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h1 class="h3 mb-3">Edit Kategori</h1>
                </div>

                <form method="POST">
                    <input type="hidden" name="subid" value="<?php echo $rowsub['SubID']; ?>">

                    <div class="form-group row">
                        <label for="inputkategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputkategori" id="inputkategori" placeholder="Nama Kategori" value="<?php echo $rowsub['NamaKategori']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputsub" class="col-sm-2 col-form-label">Nama Sub Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputsub" id="inputsub" placeholder="Nama Sub Kategori" value="<?php echo $rowsub['NamaSubKategori']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" name="EditSub">Simpan</button>
                            <a href="kategori.php" class="btn btn-secondary">Batal</a>
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
