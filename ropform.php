<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'skripsi';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fetch data for dropdown options using JOIN
$sql = "SELECT 
        spesifikasibarang.SpesifikasiID,
        subkategori.NamaSubKategori,
        barangtersedia.NamaBarang,
        bentuk.NamaBentuk,
        warna.NamaWarna
    FROM spesifikasibarang
    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $spekID = $_POST['spekID'];
    $leadTime = $_POST['leadTime'];
    $jumlahpermintaan = $_POST['jumlahPermintaan'];
    $safetyStock = $_POST['safetyStock'];

    // Pengecekan hanya untuk SpesifikasiID
    $existingQuery = $conn->query("SELECT * FROM rop WHERE SpesifikasiID = '$spekID'");

    if ($existingQuery->num_rows > 0) {
        echo "<script>alert('Data barang dan spesifikasinya sudah ada! Tidak dapat diinput ulang.');</script>";
    } else {
        // Hitung hasil ROP
        $hasil = ($leadTime * $jumlahpermintaan) + $safetyStock;

        // Insert data ke dalam tabel ROP
        $sqlInsert = "INSERT INTO rop (SpesifikasiID, LeadTime, JumlahPermintaan, SafetyStock, Hasil) 
                      VALUES ('$spekID', '$leadTime', '$jumlahpermintaan', '$safetyStock', '$hasil')";
        
        if ($conn->query($sqlInsert) === TRUE) {
            header("Location: rop.php");
            exit();
        } else {
            echo "Error: " . $sqlInsert . "<br>" . $conn->error;
        }
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Form ROP</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>

<main class="content">
<div class="container-fluid p-0">
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid"></div>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h1 class="h3 mb-3">Form ROP</h1>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label for="spekID">Spesifikasi Barang</label>
                        <select name="spekID" id="spekID" class="form-control" required>
                            <option value="">--Pilih Barang--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['SpesifikasiID']}'>
                                            {$row['NamaSubKategori']} - {$row['NamaBarang']} - {$row['NamaBentuk']} - {$row['NamaWarna']}
                                          </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlahPermintaan">Jumlah Permintaan</label>
                        <input type="number" name="jumlahPermintaan" id="jumlahPermintaan" class="form-control" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="leadTime">Lead Time</label>
                        <input type="number" name="leadTime" id="leadTime" class="form-control" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="safetyStock">Safety Stock</label>
                        <input type="number" name="safetyStock" id="safetyStock" class="form-control" min="0" required>
                    </div>

                    <button type="submit" style="background-color: #222e3c" class="btn btn-primary">Simpan</button>
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
