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
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Barang Tersedia</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include "header.php"; ?>
<?php include "includes/config.php"; ?>
<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Menu Utama</h1>

					<div class="row">
						<div class="col-12">
							<div class="card-body">								
							</div>
						</div>
					</div>

				</div>
			</main>
    
<?php include "footer.php";?>
<script src="js/app.js"></script>
</body>
<?php
mysqli_close($connection);
ob_end_flush();
?>
</html>