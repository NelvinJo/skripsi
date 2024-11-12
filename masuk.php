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

	<title>Barang Masuk</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<?php include "header.php";?>
<div class="container-fluid">
<div class="card shadow mb-4">
<?php
  include "includes/config.php";
?>

	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="jumbotron jumbotron-fluid"></div>

            <!-- Form Pencarian Kategori -->
            <div style="text-align: right; margin: 20px;">
                <a href="masukform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                    Form Tambah
                </a>
            </div>

            <form method="POST">
                <div class="form-group row mb-2">
                    <label for="searchMasuk" class="col-sm-3">Nama Barang Masuk</label>
                    <div class="col-sm-6">
                        <input type="text" name="searchMasuk" class="form-control" id="searchMasuk" value="<?php if(isset($_POST['searchMasuk'])) {echo $_POST['searchMasuk'];} ?>" placeholder="Cari Nama Barang Masuk">
                    </div>
                    <input type="submit" style="background-color: #222e3c" name="kirimMasuk" class="col-sm-1 btn btn-primary" value="Search">
                </div>
            </form>

            <!-- Tabel Kategori dan Sub Kategori -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Masuk</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sub Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Bentuk</th>
                                    <th>Nama Warna</th>
                                    <th>Jumlah Barang Masuk</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal Barang Masuk</th>
                                    <th colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>		

                            <?php
                            if(isset($_POST["kirimMasuk"])) {
                                $search = $_POST['searchMasuk'];
                                $query = mysqli_query($connection, "SELECT detailbarangmasuk.DetailMasukID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, bentuk.NamaBentuk, 
                                                                            warna.NamaWarna, detailbarangmasuk.JumlahMasuk, supplier.NamaSupplier,
                                                                            barangmasuk.TanggalMasuk
                                                                    FROM detailbarangmasuk
                                                                    JOIN barangmasuk ON detailbarangmasuk.BMID = barangmasuk.BMID
                                                                    JOIN supplier ON barangmasuk.SupplierID = supplier.SupplierID
                                                                    JOIN spesifikasibarang ON detailbarangmasuk.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                                    WHERE subkategori.NamaSubKategori LIKE '%$search%' 
                                                                    OR barangtersedia.NamaBarang LIKE '%$search%'
                                                                    OR bentuk.NamaBentuk LIKE '%$search%'
                                                                    OR warna.NamaWarna LIKE '%$search%'
                                                                    OR detailbarangmasuk.JumlahMasuk LIKE '%$search%'
                                                                    OR supplier.NamaSupplier LIKE '%$search%'
                                                                    OR barangmasuk.TanggalMasuk LIKE '%$search%'");
                            } else {
                                $query = mysqli_query($connection, "SELECT detailbarangmasuk.DetailMasukID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, bentuk.NamaBentuk, 
                                                                            warna.NamaWarna, detailbarangmasuk.JumlahMasuk, supplier.NamaSupplier,
                                                                            barangmasuk.TanggalMasuk
                                                                    FROM detailbarangmasuk
                                                                    JOIN barangmasuk ON detailbarangmasuk.BMID = barangmasuk.BMID
                                                                    JOIN supplier ON barangmasuk.SupplierID = supplier.SupplierID
                                                                    JOIN spesifikasibarang ON detailbarangmasuk.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID");
                            }

                            $nomor = 1;
                            while($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $row['NamaSubKategori']; ?></td>
                                    <td><?php echo $row['NamaBarang']; ?></td>
                                    <td><?php echo $row['NamaBentuk']; ?></td>
                                    <td><?php echo $row['NamaWarna']; ?></td>
                                    <td><?php echo $row['JumlahMasuk']; ?></td>
                                    <td><?php echo $row['NamaSupplier']; ?></td>
                                    <td><?php echo $row['TanggalMasuk']; ?></td>
                                    <td>
                                    <a href="masukhapus.php?hapusdm=<?php echo $row["DetailMasukID"] ?>" class="btn btn-danger btn-sm" title="Delete">
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