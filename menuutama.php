<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}

include "includes/config.php"; 

$dataOpname = mysqli_query($connection, "SELECT MAX(TanggalOpname) AS TanggalTerakhir FROM stockopname");
if (!$dataOpname) {
    die("Query Error: " . mysqli_error($connection));
}
$data = mysqli_fetch_assoc($dataOpname);
$TanggalTerakhir = $data['TanggalTerakhir'] ? date('d-m-Y', strtotime($data['TanggalTerakhir'])) : 'Belum ada opname';

$dataMasuk = mysqli_query($connection, "SELECT MAX(TanggalMasuk) AS TanggalMasukTerakhir FROM barangmasuk");
if (!$dataMasuk) {
    die("Query Error: " . mysqli_error($connection));
}
$dataMasuk = mysqli_fetch_assoc($dataMasuk);
$TanggalMasukTerakhir = $dataMasuk['TanggalMasukTerakhir'] ? date('d-m-Y', strtotime($dataMasuk['TanggalMasukTerakhir'])) : 'Belum ada barang masuk';

$dataKeluar = mysqli_query($connection, "SELECT MAX(TanggalKeluar) AS TanggalKeluarTerakhir FROM barangkeluar");
if (!$dataKeluar) {
    die("Query Error: " . mysqli_error($connection));
}
$dataKeluar = mysqli_fetch_assoc($dataKeluar);
$TanggalKeluarTerakhir = $dataKeluar['TanggalKeluarTerakhir'] ? date('d-m-Y', strtotime($dataKeluar['TanggalKeluarTerakhir'])) : 'Belum ada barang keluar';

$queryROP = "SELECT spesifikasibarang.JumlahStokBarang, rop.Hasil, 
        			barangtersedia.NamaBarang, subkategori.NamaSubKategori, 
        			bentuk.NamaBentuk, warna.NamaWarna
    		FROM spesifikasibarang
    		JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
    		JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
    		JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
    		JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
    		JOIN rop ON spesifikasibarang.SpesifikasiID = rop.SpesifikasiID
    		WHERE spesifikasibarang.JumlahStokBarang <= rop.Hasil";
$dataROP = mysqli_query($connection, $queryROP);

if (!$dataROP) {
    die("Query Error: " . mysqli_error($connection));
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

    <title>Barang Tersedia</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
        }

        .rop-scroll {
            height: calc(100vh - 180px);
            overflow-y: auto;
        }

        .rop-scroll ul {
            padding-left: 20px;
        }
    </style>
</head>

<body>
<?php include "header.php"; ?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Menu Utama</h1>

        <div class="row g-4">
            <div class="col-lg-6">
                <!-- Box Selamat Datang -->
                <div class="card shadow" style="border: 1px solid #90caf9;">
                    <div class="card-body">
                        <h5 class="card-title">Selamat Datang</h5>
                        <p class="card-text">Halo, <strong><?= $_SESSION['NamaDepan'] . ' ' . $_SESSION['NamaBelakang']; ?></strong>! Selamat datang di sistem.</p>
                    </div>
                </div>

                <!-- Box Peringatan ROP -->
                <div class="card shadow mt-3" style="border: 1px solid #ef9a9a; height: calc(100vh - 280px); overflow-y: auto;">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Peringatan ROP</h5>
                        <?php if (mysqli_num_rows($dataROP) > 0): ?>
                            <p>Barang berikut telah mencapai atau melewati batas ROP:</p>
                            <ul>
                                <?php while ($row = mysqli_fetch_assoc($dataROP)): ?>
                                    <li>
                                        <strong><?= $row['NamaSubKategori']; ?></strong>: <?= $row['NamaBarang']; ?> - <?= $row['NamaBentuk']; ?> - <?= $row['NamaWarna']; ?> 
                                        (Stok: <?= $row['JumlahStokBarang']; ?>, ROP: <?= $row['Hasil']; ?>)
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p>Tidak ada barang yang mencapai ROP.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Box Opname Terakhir -->
                <div class="card mb-3 clickable-card shadow" onclick="location.href='opname.php'" style="cursor: pointer; border: 1px solid #a5d6a7;">
                    <div class="card-body">
                        <h5 class="card-title">Opname Terakhir</h5>
                        <p class="card-text">Tanggal: <strong><?= $TanggalTerakhir; ?></strong></p>
                        <p class="card-text">Klik untuk melihat detail opname.</p>
                    </div>
                </div>

                <!-- Box Barang Masuk Terakhir -->
                <div class="card mb-3 clickable-card shadow" onclick="location.href='masuk.php'" style="cursor: pointer; border: 1px solid #ffcc80;">
                    <div class="card-body">
                        <h5 class="card-title">Barang Masuk Terakhir</h5>
                        <p class="card-text">Tanggal: <strong><?= $TanggalMasukTerakhir; ?></strong></p>
                        <p class="card-text">Klik untuk melihat detail barang masuk.</p>
                    </div>
                </div>

                <!-- Box Barang Keluar Terakhir -->
                <div class="card clickable-card shadow" onclick="location.href='keluar.php'" style="cursor: pointer; border: 1px solid #b39ddb;">
                    <div class="card-body">
                        <h5 class="card-title">Barang Keluar Terakhir</h5>
                        <p class="card-text">Tanggal: <strong><?= $TanggalKeluarTerakhir; ?></strong></p>
                        <p class="card-text">Klik untuk melihat detail barang keluar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/app.js"></script>
</body>
</html>