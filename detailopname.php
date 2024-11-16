<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
include "includes/config.php";

$tanggalOpname = $_GET['tanggal'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Stock Opname</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
    <?php include "header.php"; ?>

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div class="jumbotron jumbotron-fluid"></div>

                    <form method="POST">
                        <div class="form-group row mb-2">
                            <label for="searchOpname" class="col-sm-3">Nama Stock Opname</label>
                            <div class="col-sm-6">
                                <input type="text" name="searchOpname" class="form-control" id="searchOpname" value="<?php if (isset($_POST['searchOpname'])) { echo $_POST['searchOpname']; } ?>" placeholder="Cari Data Stock Opname">
                            </div>
                            <input type="submit" style="background-color: #222e3c" name="kirimOpname" class="col-sm-1 btn btn-primary" value="Search">
                        </div>
                    </form>

                    <?php if (!empty($tanggalOpname)) { ?>
                        <div class="card shadow mb-4 mt-5">
                            <div class="card-header py-3">
                                <h1 class="h3 mb-3">Detail Stock Opname - <?php echo htmlspecialchars($tanggalOpname); ?></h1>
                            </div>
                            <div class="card-body">
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
                                            $queryDetail = mysqli_query($connection, "SELECT detailstockopname.DetailOpnameID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                                    bentuk.NamaBentuk, warna.NamaWarna, spesifikasibarang.JumlahStokBarang,
                                                    detailstockopname.StokFisik, detailstockopname.Perbedaan
                                                FROM detailstockopname
                                                JOIN stockopname ON detailstockopname.OpnameID = stockopname.OpnameID
                                                JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                WHERE stockopname.TanggalOpname = '$tanggalOpname'");

                                            $nomor = 1;
                                            while ($row = mysqli_fetch_assoc($queryDetail)) { ?>
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
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <?php include "footer.php"; ?>
    <script src="js/app.js"></script>
</body>

</html>
