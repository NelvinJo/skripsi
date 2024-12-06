<?php
$user_role = $_SESSION['Role'] ?? ''; 
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

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Toko Arloji Pasar Baru</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
	<nav id="sidebar" class="sidebar js-sidebar" style="background-color: #222e3c;">
		<div class="sidebar-content js-simplebar">
			<a class="sidebar-brand d-flex align-items-center" style="padding: 10px;">
				<img src="img/logo.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 15px; border-radius: 50%; object-fit: cover;">
				<span class="align-middle text-white" style="font-size: 18px;">Toko Arloji Pasar Baru</span>
			</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">Menu</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="menuutama.php">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Menu Utama</span>
						</a>
					</li>

					<li class="sidebar-header">Menu Input</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="tersedia.php">
							<i class="align-middle" data-feather="box"></i> <span class="align-middle">Barang Tersedia</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="masuk.php">
							<i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Barang Masuk</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="keluar.php">
							<i class="align-middle" data-feather="package"></i> <span class="align-middle">Barang Keluar</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="supplier.php">
							<i class="align-middle" data-feather="truck"></i> <span class="align-middle">Supplier</span>
						</a>
					</li>

					<?php if ($user_role === 'owner'): ?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="admin.php">
							<i class="align-middle" data-feather="users"></i> <span class="align-middle">Admin</span>
						</a>
					</li>
					<?php endif; ?>

					<li class="sidebar-item">
						<a class="sidebar-link" href="kategori.php">
							<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Kategori</span>
						</a>
					</li>

					<li class="sidebar-header">Menu Perhitungan</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="opname.php">
							<i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle">Stock Opname</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="rop.php">
							<i class="align-middle" data-feather="activity"></i> <span class="align-middle">ROP</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
										</div>
									</a>
								</div>
						</li>
						
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
								<div class="dropdown-menu-header">
								</div>
								<div class="list-group">
								</div>
							</div>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                				<img src="img/profile.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark"><?php echo $_SESSION['NamaDepan'] . ' ' . $_SESSION['NamaBelakang']; ?></span>
              				</a>

						<div class="dropdown-menu dropdown-menu-end">
    						<a class="dropdown-item d-flex align-items-center" href="logout.php" 
       						onclick="return confirm('Apakah Anda yakin ingin keluar?');">
        					<img src="img/door.png" alt="Logout Icon" style="width: 20px; height: 20px; margin-right: 8px;">Keluar
    						</a>
						</div>

						</li>
					</ul>
				</div>
			</nav>
			