<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}

include "includes/config.php";

if (isset($_GET['ubahrop'])) {
    $ropID = $_GET['ubahrop'];

    $queryROP = mysqli_query($connection, "SELECT rop.ROPID, rop.JumlahPermintaan, rop.LeadTime, 
                                                   rop.SafetyStock, rop.Hasil, spesifikasibarang.SpesifikasiID 
                                            FROM rop
                                            JOIN spesifikasibarang ON rop.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                            WHERE ROPID = '$ropID'");
    $dataROP = mysqli_fetch_assoc($queryROP);

    if (!$dataROP) {
        echo "Data tidak ditemukan!";
        exit();
    }

    if (isset($_POST['updateROP'])) {
        $spesifikasiID = $_POST['spesifikasiID'];
        $jumlahPermintaan = $_POST['jumlahPermintaan'];
        $leadTime = $_POST['leadTime'];
        $safetyStock = $_POST['safetyStock'];

        $newROP = ($jumlahPermintaan * $leadTime) + $safetyStock;

        $updateQuery = "UPDATE rop SET 
                            SpesifikasiID = '$spesifikasiID', 
                            JumlahPermintaan = '$jumlahPermintaan', 
                            LeadTime = '$leadTime', 
                            SafetyStock = '$safetyStock',
                            Hasil = '$newROP'
                        WHERE ROPID = '$ropID'";

        if (mysqli_query($connection, $updateQuery)) {
            header("Location: rop.php");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($connection);
        }
    }
} else {
    header("Location: roptable.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit ROP</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit ROP</h1>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="spesifikasiID">Spesifikasi Barang</label>
                        <select name="spesifikasiID" id="spesifikasiID" class="form-control">
                            <?php
                            $querySpesifikasi = mysqli_query($connection, "SELECT spesifikasibarang.SpesifikasiID, 
                                                                                subkategori.NamaSubKategori, 
                                                                                barangtersedia.NamaBarang, 
                                                                                bentuk.NamaBentuk, 
                                                                                warna.NamaWarna 
                                                                            FROM spesifikasibarang
                                                                            JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                            JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                            JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                            JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID");

                            while ($row = mysqli_fetch_assoc($querySpesifikasi)) {
                                $selected = ($row['SpesifikasiID'] == $dataROP['SpesifikasiID']) ? "selected" : "";
                                echo "<option value='{$row['SpesifikasiID']}' $selected>
                                        {$row['NamaSubKategori']} - {$row['NamaBarang']} - {$row['NamaBentuk']} - {$row['NamaWarna']}
                                      </option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlahPermintaan">Jumlah Permintaan</label>
                        <input type="number" name="jumlahPermintaan" id="jumlahPermintaan" class="form-control" 
                               value="<?php echo htmlspecialchars($dataROP['JumlahPermintaan']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="leadTime">Lead Time</label>
                        <input type="number" name="leadTime" id="leadTime" class="form-control" 
                               value="<?php echo htmlspecialchars($dataROP['LeadTime']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="safetyStock">Safety Stock</label>
                        <input type="number" name="safetyStock" id="safetyStock" class="form-control" 
                               value="<?php echo htmlspecialchars($dataROP['SafetyStock']); ?>" required>
                    </div>

                    <button type="submit" style="background-color: #222e3c" name="updateROP" class="btn btn-primary">Edit</button>
                    <a href="rop.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</body>

</html>
