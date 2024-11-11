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

	<title>Supplier</title>

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
    <a href="supplierform2.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
        Form Tambah
    </a>
</div>

		<form method="POST">
			<div class="form-group row mb-2">
				<label for="search" class="col-sm-3">Nama Supplier</label>
				<div class="col-sm-6">
					<input type="text" name="search" class="form-control" id="search" value="<?php if(isset($_POST['search'])) {echo $_POST['search'];}?>"placeholder="Cari Nama Supplier">
				</div>
				<input type="submit" style="background-color: #222e3c" name="kirim" class="col-sm-1 btn btn-primary" value="Search">
			</div>
		</form>

		<div class="col-sm-1">
    
  </div>
</div> <!-- penutup class row -->

<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		<div class="card shadow mb-4">
      	<div class="card-header py-3">
           <h6 class="m-0 font-weight-bold text-primary">Tabel Supplier</h6>
             </div>
                <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                          	<th>No</th>
							<th>Nama Supplier</th>
							<th>No Telp Supplier</th>
							<th>Alamat Supplier</th>
							<th>Kota Supplier</th>
							<th>Provinsi Supplier</th>
							<th colspan="2" style="text-align: center;">Action</th>
                          </tr>
                       	</thead>

						   <tbody>		

<?php
if(isset($_POST["kirim"])) {
					$search = $_POST['search'];
					$query = mysqli_query($connection, "select * from supplier 
						where NamaSupplier like '%".$search."%'
						or NoTelp like '%".$search."%'
						or Alamat like '%".$search."%'
						or Kota like '%".$search."%'
						or Provinsi like '%".$search."%'");
}

else{
	$query = mysqli_query($connection, "select * from supplier");
}

	$nomor = 1 ;

	while($row =mysqli_fetch_array($query))
	{ ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $row['NamaSupplier']; ?></td>
			<td><?php echo $row['NoTelp']; ?></td>
			<td><?php echo $row['Alamat']; ?></td>
			<td><?php echo $row['Kota']; ?></td>
			<td><?php echo $row['Provinsi']; ?></td>
			
			<!-- untuk icon edit dan delete -->
			<td>
				<a href="supplieredit2.php?ubahsupplier=<?php echo $row["SupplierID"]?>" class
					="btn btn-success btn-sm" title="Edit">

				<i class="bi bi-pencil-square"><img src="icon/pencil-square.svg"></i>
				</a>
			</td>

			<td>
				<a href="supplierhapus.php?hapussupplier=<?php echo $row["SupplierID"]?>" class
					="btn btn-danger btn-sm" title="Delete">
				<i class="bi bi-trash-fill.svg"><img src="icon/trash-fill.svg"></i>
				</a>
			</td>

			<!-- akhir icon edit dan delete -->
		</tr>

<?php $nomor = $nomor+1 ; ?>		
<?php	} ?>
			
</tbody>

</table>
		</table>
		</div>
	</div>

			
		</div>
	</div>
	<?php include "footer.php"; ?>
	<script src="js/app.js"></script>
	
</body>

</html>