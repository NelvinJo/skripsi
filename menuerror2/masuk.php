<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Barang Masuk</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<?php include "header.php";?>
<div class="container-fluid">
<div class="card shadow mb-4">
<?php
  include "includes/config.php" ;
?>

<body>
		<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="jumbotron jumbotron-fluid"></div>

<div style="text-align: right; margin: 20px;">
    <a href="masukform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
        Form Tambah
    </a>
</div>

		<form method="POST">
			<div class="form-group row mb-2">
				<label for="searchMasuk" class="col-sm-3">Nama Barang Masuk</label>
				<div class="col-sm-6">
					<input type="text" name="searchMasuk" class="form-control" id="searchMasuk" value="<?php if(isset($_POST['searchMasuk'])) {echo $_POST['searchMasuk'];}?>"placeholder="Cari Nama Barang Masuk">
				</div>
				<input type="submit" style="background-color: #222e3c" name="kirimMasuk" class="col-sm-1 btn btn-primary" value="Search">
			</div>
		</form>

		<div class="col-sm-1">
    
  </div>
</div>

		<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
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
                            <th>Kode Barang Masuk</th>
							<th>Nama Supplier </th>
							<th>Tanggal Barang Masuk</th>
                          </tr>
                       	</thead>

						   <tbody>		

                           <?php
                            if(isset($_POST["kirimMasuk"])) {
                                $search = $_POST['searchMasuk'];
                                $query = mysqli_query($connection, "SELECT * FROM barangmasuk 
                                    WHERE NamaSupplier LIKE '%$search%'
                                    OR TanggalMasuk LIKE '%$search%'");
                            } else {
                                $query = mysqli_query($connection, "SELECT * FROM barangmasuk");
                            }

                            $nomor = 1;
                            while($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $row['BMID']; ?></td>
                                    <td><?php echo $row['NamaSupplier']; ?></td>
                                    <td><?php echo $row['TanggalMasuk']; ?></td>
                                </tr>
                            <?php $nomor++; } ?>
			
</tbody>	  
</table>
		</div>
	</div>

			
		</div>
		<form method="POST">
                <div class="form-group row mb-2">
                    <label for="searchDM" class="col-sm-3">Nama Detail Barang Masuk</label>
                    <div class="col-sm-6">
                        <input type="text" name="searchDM" class="form-control" id="searchDM" value="<?php if(isset($_POST['searchDM'])) {echo $_POST['searchDM'];} ?>" placeholder="Cari Nama Detail Barang Masuk">
                    </div>
                    <input type="submit" style="background-color: #222e3c" name="kirimDM" class="col-sm-1 btn btn-primary" value="Search">
                </div>
            </form>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Detail Barang Masuk</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Detail Barang Masuk</th>
									<th>Kode Barang Masuk</th>
                                    <th>Kode Spesifikasi</th>
                                    <th>Jumlah Barang Masuk</th>
                                    <th colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>		

                            <?php
                            if(isset($_POST["kirimDM"])) {
                                $search = $_POST['searchDM'];
                                $query = mysqli_query($connection, "SELECT * FROM detailbarangmasuk 
                                    WhERE BMID LIKE '%$search%'
                                    OR SpesifikasiID LIKE '%$search%'
                                    OR JumlahMasuk LIKE '%$search%'");
                            } else {
                                $query = mysqli_query($connection, "SELECT * FROM detailbarangmasuk");
                            }

                            $nomor = 1;
                            while($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $row['DetailMasukID']; ?></td>
                                    <td><?php echo $row['BMID']; ?></td>
                                    <td><?php echo $row['SpesifikasiID']; ?></td>
                                    <td><?php echo $row['JumlahMasuk']; ?></td>
									<td>
                                    <a href="masukedit.php?ubahdm=<?php echo $row["DetailMasukID"] ?>&ubahmasuk=<?php echo $row["BMID"] ?>" class="btn btn-success btn-sm" title="Edit">
                                        <i class="bi bi-pencil-square"><img src="icon/pencil-square.svg"></i>
                                            </a>

                                    </td>
                                    <td>
                                    <a href="masukhapus.php?hapusdm=<?php echo $row["DetailMasukID"] ?>&hapusmasuk=<?php echo $row["BMID"] ?>" class="btn btn-danger btn-sm" title="Delete">
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