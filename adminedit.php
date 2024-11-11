<!DOCTYPE html>

<?php
include "includes/config.php";

if(isset($_POST['Edit'])) {

	if(isset($_REQUEST['inputkode'])) {
		$adminkode = $_REQUEST['inputkode'];
	}

	if(!empty($adminkode)) {
		$adminkode = $_REQUEST['inputkode'];
	}

	else {
		?> <h1>Anda harus mengisi data</h1> <?php
		die ("Anda harus memasukkan datanya");
	}

    $depanadmin = $_POST['inputdepan'];
	$belakangadmin = $_POST['inputbelakang'];
	$hp = $_POST['inputhp'];
    $email = $_POST['inputemail'];
    $password = $_POST['inputpassword'];
    $role = $_POST['inputrole'];

	mysqli_query($connection,"update admin set NamaDepan='$depanadmin', NamaBelakang='$belakangadmin', NoHP='$hp', Email='$email', Password='$password', Role='$role' where AdminID = '$adminkode'");

  	header("Location:admin.php") ;

}

$kodeadmin = $_GET["ubahadmin"] ;
$editadmin = mysqli_query($connection,"select * from admin where AdminID = '$kodeadmin' ") ;
$rowedit = mysqli_fetch_array($editadmin) ;

?>

<html>
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

<body>
<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4">Input Admin</h1>
                    </div>
                </div>

					<form method="POST">
						<div class="form-group row">
							<label for="kodeadmin" class="col-sm-2 col-form-label">Kode Admin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="kodeadmin" name="inputkode" placeholder="Kode Admin" maxlength="4" value="<?php echo $rowedit["AdminID"]?>" readonly>
							</div>
						</div>

						<div class="form-group row">
							<label for="depanadmin" class="col-sm-2 col-form-label">Nama Depan Admin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputdepan" id="depanadmin" placeholder="Nama Depan Admin" value="<?php echo $rowedit["NamaDepan"]?>">
							</div>
						</div>

						<div class="form-group row">
							<label for="belakangadmin" class="col-sm-2 col-form-label">Nama Belakang Admin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputbelakang" id="belakangadmin" placeholder="Nama Belakang Admin" value="<?php echo $rowedit["NamaBelakang"]?>">
							</div>
						</div>

						<div class="form-group row">
							<label for="hp" class="col-sm-2 col-form-label">Nomor HP Admin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputhp" id="hp" placeholder="Nomor Handphone Admin" value="<?php echo $rowedit["NoHP"]?>">
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-sm-2 col-form-label">Email Admin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputemail" id="email" placeholder="Email Admin" value="<?php echo $rowedit["Email"]?>">
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-sm-2 col-form-label">Password Admin</label>
							<div class="col-sm-10">
								<input type="MD5" class="form-control" name="inputpassword" id="password" placeholder="Password Admin" value="<?php echo $rowedit["Password"]?>">
							</div>
						</div>

						<div class="form-group row">
							<label for="role" class="col-sm-2 col-form-label">Role Admin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="inputrole" id="role" placeholder="Role Admin" value="<?php echo $rowedit["Role"]?>">
							</div>
						</div>

<div class="form-group row">
        <div class="col-sm-2">
          
        </div>
        <div class="col-sm-10">
          <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Edit" name="Edit">
          <input type="reset" class="btn btn-secondary" value="Batal" name="Batal">
        </div>
      </div>

					</form>
				</div>

				<div class="col-sm-1">
				</div>
			</div> <!-- penutup class row -->

						<tbody>

							<a href="adminedit.php?ubahadmin=<?php echo $row["AdminID"]?>"</a>
						</td>

						<td>
							<a href="adminhapus.php?hapusadmin=<?php echo $row["AdminID"]?>"</a>
						</td>

									</tr>

							</tbody>

					</div>
					<div class="col-sm-1"></div>

				</div>

				<script type="text/javascript src="js/bootstrap.min.js></script>
			</body>
			<?php include "footer.php";?>
			<script src="js/app.js"></script>
			<?php
			mysqli_close($connection);
			ob_end_flush();
			?>
			</html>