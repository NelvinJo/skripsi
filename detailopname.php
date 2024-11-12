<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

// Ambil parameter tanggal dari URL
$tanggalOpname = $_GET['tanggal'] ?? '';

// Query untuk mengambil detail berdasarkan TanggalOpname
$query = mysqli_query($connection, "SELECT detailstockopname.DetailOpnameID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                                                            bentuk.NamaBentuk, warna.NamaWarna, spesifikasibarang.JumlahStokBarang,
                                                                            detailstockopname.StokFisik, detailstockopname.Perbedaan, stockopname.TanggalOpname
                                                                    FROM detailstockopname
                                                                    JOIN stockopname ON detailstockopname.OpnameID = stockopname.OpnameID
                                                                    JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                                    WHERE stockopname.TanggalOpname = '$tanggalOpname'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Stock Opname</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container-fluid">
        <h2>Detail Stock Opname - <?php echo htmlspecialchars($tanggalOpname); ?></h2>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sub Kategori</th>
                        <th>Nama Barang</th>
                        <th>Satuan Barang</th>
                        <th>Nama Bentuk</th>
                        <th>Nama Warna</th>
                        <th>Jumlah Stok Barang</th>
                        <th>Stok Fisik</th>
                        <th>Perbedaan</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $nomor = 1;
                while ($row = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $nomor++; ?></td>
                        <td><?php echo $row['NamaSubKategori']; ?></td>
                        <td><?php echo $row['NamaBarang']; ?></td>
                        <td><?php echo $row['SatuanBarang']; ?></td>
                        <td><?php echo $row['NamaBentuk']; ?></td>
                        <td><?php echo $row['NamaWarna']; ?></td>
                        <td><?php echo $row['JumlahStokBarang']; ?></td>
                        <td><?php echo $row['StokFisik']; ?></td>
                        <td><?php echo $row['Perbedaan']; ?></td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <script src="js/app.js"></script>
</body>
</html>
