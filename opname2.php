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
    <!-- existing head content -->
    <title>Stock Opname</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<?php include "header.php";?>
<div class="container-fluid">
<div class="card shadow mb-4">
<?php include "includes/config.php"; ?>

<body>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="jumbotron jumbotron-fluid"></div>

            <div style="text-align: right; margin: 20px;">
                <a href="opnameform.php" class="btn btn-primary" style="background-color: #222e3c; color: white;">Form Tambah</a>
            </div>

            <form method="POST">
                <div class="form-group row mb-2">
                    <label for="searchOpname" class="col-sm-3">Nama Stock Opname</label>
                    <div class="col-sm-6">
                        <input type="text" name="searchOpname" class="form-control" id="searchOpname" placeholder="Cari Data Stock Opname" value="<?php echo $_POST['searchOpname'] ?? ''; ?>">
                    </div>
                    <button type="submit" name="kirimOpname" class="col-sm-1 btn btn-primary" style="background-color: #222e3c;">Search</button>
                </div>
            </form>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Stock Opname</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Stock Opname</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            // Query to fetch unique dates
                            $search = $_POST['searchOpname'] ?? '';
                            $query = mysqli_query($connection, "
                                SELECT DISTINCT stockopname.TanggalOpname
                                FROM stockopname
                                JOIN detailstockopname ON stockopname.OpnameID = detailstockopname.OpnameID
                                JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                WHERE barangtersedia.NamaBarang LIKE '%$search%'
                                   OR stockopname.TanggalOpname LIKE '%$search%'
                            ");

                            $nomor = 1;
                            while($row = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td><?php echo $row['TanggalOpname']; ?></td>
                                    <td>
                                        <a href="detailopname.php?tanggal=<?php echo urlencode($row['TanggalOpname']); ?>" class="btn btn-info btn-sm" title="View Details">View Details</a>
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <script src="js/app.js"></script>
</body>
</html>
