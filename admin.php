<?php
session_start();
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'owner') {
    header("Location: menuutama.php"); // Redirect staff to main menu
    exit();
}
?>

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

	<title>Admin</title>

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
    <a href="adminform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
        Form Tambah
    </a>
</div>

		<form method="POST">
			<div class="form-group row mb-2">
				<label for="search" class="col-sm-3">Nama Admin</label>
				<div class="col-sm-6">
					<input type="text" name="search" class="form-control" id="search" value="<?php if(isset($_POST['search'])) {echo $_POST['search'];}?>"placeholder="Cari Nama Admin">
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
           <h6 class="m-0 font-weight-bold text-primary">Tabel Admin</h6>
             </div>
                <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                          	<th>No</th>
							<th>Nama Depan Admin</th>
							<th>Nama Belakang Admin</th>
							<th>Nomor Handphone Admin</th>
							<th>Email Admin</th>
							<th>Password Admin</th>
							<th>Role Admin</th>
							<th colspan="2" style="text-align: center;">Action</th>
                          </tr>
                       	</thead>

						   <tbody>		

<?php
if(isset($_POST["kirim"])) {
					$search = $_POST['search'];
					$query = mysqli_query($connection, "select * from admin
						where NamaDepan like '%".$search."%'
						or NamaBelakang like '%".$search."%'
						or NoHP like '%".$search."%'
						or Email like '%".$search."%'
						or Password like '%".$search."%'
						or Role like '%".$search."%'");
}

else{
	$query = mysqli_query($connection, "select * from admin");
}

	$nomor = 1 ;

	while($row =mysqli_fetch_array($query))
	{ ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $row['NamaDepan']; ?></td>
			<td><?php echo $row['NamaBelakang']; ?></td>
			<td><?php echo $row['NoHP']; ?></td>
			<td><?php echo $row['Email']; ?></td>
			<td><?php echo $row['Password']; ?></td>
			<td><?php echo $row['Role']; ?></td>
			
			<!-- untuk icon edit dan delete -->
			<td>
				<a href="adminedit.php?ubahadmin=<?php echo $row["AdminID"]?>" class
					="btn btn-success btn-sm" title="Edit">

				<i class="bi bi-pencil-square"><img src="icon/pencil-square.svg"></i>
				</a>
			</td>

			<td>
				<a href="adminhapus.php?hapusadmin=<?php echo $row["AdminID"]?>" class
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
		</div>
	</div>

			
		</div>
	</div>
	<?php include "footer.php"; ?>
	<script src="js/app.js"></script>
	
</body>

</html>