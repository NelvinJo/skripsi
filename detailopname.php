<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Stock Opname</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>
<div class="container-fluid">
<div class="card shadow mb-4">
<?php
    include "includes/config.php";

    if (isset($_GET['opnameID'])) {
        $opnameID = $_GET['opnameID'];
        
        // Ambil tanggal opname berdasarkan OpnameID
        $tanggalQuery = mysqli_query($connection, "SELECT TanggalOpname FROM stockopname WHERE OpnameID = '$opnameID' LIMIT 1");
        $tanggalRow = mysqli_fetch_array($tanggalQuery);
        $tanggalOpname = $tanggalRow['TanggalOpname'];
    }
?>

    <div class="row">
        <div class="col-sm-12">
            <h2>Detail Stock Opname Tanggal: <?php echo $tanggalOpname; ?></h2>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                    // Ambil detail berdasarkan OpnameID yang dipilih
                    $detailQuery = mysqli_query($connection, "SELECT subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                bentuk.NamaBentuk, warna.NamaWarna, spesifikasibarang.JumlahStokBarang, detailstockopname.StokFisik,
                                detailstockopname.Perbedaan
                            FROM detailstockopname
                            JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                            JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                            JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                            JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                            JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                            WHERE detailstockopname.OpnameID = '$opnameID'");

                    while ($detailRow = mysqli_fetch_array($detailQuery)) {
                        echo "<tr>
                                <td>{$detailRow['NamaSubKategori']}</td>
                                <td>{$detailRow['NamaBarang']}</td>
                                <td>{$detailRow['SatuanBarang']}</td>
                                <td>{$detailRow['NamaBentuk']}</td>
                                <td>{$detailRow['NamaWarna']}</td>
                                <td>{$detailRow['JumlahStokBarang']}</td>
                                <td>{$detailRow['StokFisik']}</td>
                                <td>{$detailRow['Perbedaan']}</td>
                              </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <a href="stockopname.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</body>
</html>
