<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_POST['EditSub'])) {
    if (!empty($_POST['kategoridropdown']) && !empty($_POST['inputsub'])) {
        $kodesub = $_POST['subid'];
        $kodekategori = $_POST['kategoridropdown'];
        $namasub = $_POST['inputsub'];

        mysqli_query($connection, "UPDATE subkategori SET KategoriID='$kodekategori', NamaSubKategori='$namasub' WHERE SubID='$kodesub'");
        
        header("Location: kategori.php");
        exit();
    } else {
        echo "<h1>Anda harus memilih Kategori dan mengisi Nama Sub Kategori</h1>";
    }
}

$datakategori = mysqli_query($connection, "SELECT * FROM kategori");

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
                        <label for="kategoridropdown" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategoridropdown" id="kategoridropdown">
                                <?php while ($row = mysqli_fetch_array($datakategori)) { ?>
                                    <option value="<?php echo $row["KategoriID"]; ?>" 
                                        <?php echo ($row["KategoriID"] == $rowsub['KategoriID']) ? 'selected' : ''; ?>>
                                        <?php echo $row["NamaKategori"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputsub" class="col-sm-2 col-form-label">Nama Sub Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputsub" id="inputsub" placeholder="Nama Sub Kategori" value="<?php echo $rowsub['NamaSubKategori']; ?>">
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