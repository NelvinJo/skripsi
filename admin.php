<?php
session_start();
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'owner') {
    header("Location: menuutama.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
<?php include "header.php"; ?>
<?php include "includes/config.php"; ?>
    <main class="content">
    <div class="container-fluid p-0">
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
						<input type="text" name="search" class="form-control" id="search" value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" placeholder="Cari Nama Admin">
					</div>
					<input type="submit" style="background-color: #222e3c" name="kirim" class="col-sm-1 btn btn-primary" value="Search">
				</div>
			</form>

			<div class="col-sm-1"></div>
		</div>

		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<div class="card shadow mb-4">
					<div class="card-header py-3">
					<h1 class="h3 mb-3">Tabel Admin</h1>
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
									if (isset($_POST["kirim"])) {
										$search = $_POST['search'];
										$query = mysqli_query($connection, "SELECT * FROM admin
											WHERE NamaDepan LIKE '%" . $search . "%'
											OR NamaBelakang LIKE '%" . $search . "%'
											OR NoHP LIKE '%" . $search . "%'
											OR Email LIKE '%" . $search . "%'
											OR Password LIKE '%" . $search . "%'
											OR Role LIKE '%" . $search . "%'");
									} else {
										$query = mysqli_query($connection, "SELECT * FROM admin");
									}

									$nomor = 1;

									while ($row = mysqli_fetch_array($query)) { ?>
										<tr>
											<td><?php echo $nomor; ?></td>
											<td><?php echo $row['NamaDepan']; ?></td>
											<td><?php echo $row['NamaBelakang']; ?></td>
											<td><?php echo $row['NoHP']; ?></td>
											<td><?php echo $row['Email']; ?></td>
											<td><?php echo str_repeat('*', strlen($row['Password'])); ?></td>
											<td><?php echo $row['Role']; ?></td>
											<td>
												<a href="adminedit.php?ubahadmin=<?php echo $row["AdminID"] ?>" class="btn btn-success btn-sm" title="Edit">
													<i class="bi bi-pencil-square"><img src="icon/pencil-square.svg"></i>
												</a>
											</td>
											<td>
												<a href="adminhapus.php?hapusadmin=<?php echo $row["AdminID"] ?>" class="btn btn-danger btn-sm" title="Delete">
													<i class="bi bi-trash-fill"><img src="icon/trash-fill.svg"></i>
												</a>
											</td>
										</tr>
									<?php $nomor++;
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.php"; ?>
		<script src="js/app.js"></script>
								</main>
</body>

</html>
