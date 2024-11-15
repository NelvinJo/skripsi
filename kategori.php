<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Kategori</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<?php include "header.php";?>
<div class="container-fluid">
<div class="card shadow mb-4">
<?php
  include "includes/config.php";
?>

<body>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="jumbotron jumbotron-fluid"></div>

            <div style="text-align: right; margin: 20px;">
                <a href="kategoriform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                    Form Tambah
                </a>
            </div>

            <form method="POST">
                <div class="form-group row mb-2">
                    <label for="searchKategori" class="col-sm-3">Nama Kategori</label>
                    <div class="col-sm-6">
                        <input type="text" name="searchKategori" class="form-control" id="searchKategori" value="<?php if(isset($_POST['searchKategori'])) {echo $_POST['searchKategori'];} ?>" placeholder="Cari Nama Kategori">
                    </div>
                    <input type="submit" style="background-color: #222e3c" name="kirimKategori" class="col-sm-1 btn btn-primary" value="Search">
                </div>
            </form>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Nama Sub Kategori</th>
                                    <th colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>		

                            <?php
                            if(isset($_POST["kirimKategori"])) {
                                $search = $_POST['searchKategori'];
                                $query = mysqli_query($connection, "SELECT subkategori.SubID, subkategori.NamaSubKategori, kategori.NamaKategori 
                                                                    FROM subkategori 
                                                                    JOIN kategori ON subkategori.KategoriID = kategori.KategoriID
                                                                    WHERE kategori.NamaKategori LIKE '%$search%' 
                                                                    OR subkategori.NamaSubKategori LIKE '%$search%'");
                            } else {
                                $query = mysqli_query($connection, "SELECT subkategori.SubID, subkategori.NamaSubKategori, kategori.NamaKategori 
                                                                    FROM subkategori 
                                                                    JOIN kategori ON subkategori.KategoriID = kategori.KategoriID");
                            }

                            $nomor = 1;
                            while($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $row['NamaKategori']; ?></td>
                                    <td><?php echo $row['NamaSubKategori']; ?></td>
                                    <td>
                                    <a href="kategoriedit.php?ubahsub=<?php echo $row["SubID"] ?>&ubahkategori=<?php echo $row["NamaKategori"] ?>" class="btn btn-success btn-sm" title="Edit">
                                        <i class="bi bi-pencil-square"><img src="icon/pencil-square.svg"></i>
                                            </a>

                                    </td>
                                    <td>
                                    <a href="kategorihapus.php?hapussub=<?php echo $row["SubID"] ?>&hapuskategori=<?php echo $row["NamaKategori"] ?>" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="bi bi-trash-fill.svg"><img src="icon/trash-fill.svg"></i>
                                            </a>
                                        
			</td>
                                </tr>
                            <?php $nomor++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
	</div>
	<?php include "footer.php"; ?>
	<script src="js/app.js"></script>
	
</body>
</html>