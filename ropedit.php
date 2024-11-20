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
$sql = "SELECT spesifikasibarang.SpesifikasiID,
        subkategori.NamaSubKategori,
        barangtersedia.NamaBarang,
        bentuk.NamaBentuk,
        warna.NamaWarna
    FROM spesifikasibarang
    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID";
$result = $conn->query($sql);

// Inisialisasi variabel
$isEdit = false;
$dataROP = null;

// Cek apakah sedang edit atau tambah
if (isset($_GET['ubahrop'])) {
    $isEdit = true;
    $ropID = $_GET['ubahrop'];

    $queryROP = $conn->query("SELECT rop.ROPID, rop.JumlahPermintaan, rop.LeadTime, 
                                      rop.SafetyStock, rop.Hasil, spesifikasibarang.SpesifikasiID 
                               FROM rop
                               JOIN spesifikasibarang ON rop.SpesifikasiID = spesifikasibarang.SpesifikasiID
                               WHERE ROPID = '$ropID'");
    $dataROP = $queryROP->fetch_assoc();

    if (!$dataROP) {
        echo "Data tidak ditemukan!";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $spesifikasiID = $_POST['spesifikasiID'];
    $jumlahPermintaan = $_POST['jumlahPermintaan'];
    $leadTime = $_POST['leadTime'];
    $safetyStock = $_POST['safetyStock'];

    // Hitung hasil ROP
    $hasil = ($leadTime * $jumlahPermintaan) + $safetyStock;

    // Pengecekan existing
    $existingQuery = $conn->query("SELECT * FROM rop WHERE SpesifikasiID = '$spesifikasiID'" . ($isEdit ? " AND ROPID != '$ropID'" : ""));

    if ($existingQuery->num_rows > 0) {
        echo "<script>alert('Data barang dan spesifikasinya sudah ada! Tidak dapat diinput ulang.');</script>";
    } else {
        if ($isEdit) {
            // Update data
            $updateQuery = "UPDATE rop SET 
                                SpesifikasiID = '$spesifikasiID', 
                                JumlahPermintaan = '$jumlahPermintaan', 
                                LeadTime = '$leadTime', 
                                SafetyStock = '$safetyStock',
                                Hasil = '$hasil'
                            WHERE ROPID = '$ropID'";

            if ($conn->query($updateQuery)) {
                header("Location: rop.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            // Insert data
            $insertQuery = "INSERT INTO rop (SpesifikasiID, LeadTime, JumlahPermintaan, SafetyStock, Hasil) 
                            VALUES ('$spesifikasiID', '$leadTime', '$jumlahPermintaan', '$safetyStock', '$hasil')";

            if ($conn->query($insertQuery)) {
                header("Location: rop.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
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
    <title><?php echo $isEdit ? "Edit ROP" : "Tambah ROP"; ?></title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><?php echo $isEdit ? "Edit ROP" : "Form ROP"; ?></h1>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="spesifikasiID">Spesifikasi Barang</label>
                        <select name="spesifikasiID" id="spesifikasiID" class="form-control" required>
                            <option value="">--Pilih Barang--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($isEdit && $row['SpesifikasiID'] == $dataROP['SpesifikasiID']) ? "selected" : "";
                                    echo "<option value='{$row['SpesifikasiID']}' $selected>
                                            {$row['NamaSubKategori']} - {$row['NamaBarang']} - {$row['NamaBentuk']} - {$row['NamaWarna']}
                                          </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlahPermintaan">Jumlah Permintaan</label>
                        <input type="number" name="jumlahPermintaan" id="jumlahPermintaan" class="form-control" min="0"
                               value="<?php echo $isEdit ? htmlspecialchars($dataROP['JumlahPermintaan']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="leadTime">Lead Time</label>
                        <input type="number" name="leadTime" id="leadTime" class="form-control" min="0"
                               value="<?php echo $isEdit ? htmlspecialchars($dataROP['LeadTime']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="safetyStock">Safety Stock</label>
                        <input type="number" name="safetyStock" id="safetyStock" class="form-control" min="0"
                               value="<?php echo $isEdit ? htmlspecialchars($dataROP['SafetyStock']) : ''; ?>" required>
                    </div>

                    <button type="submit" style="background-color: #222e3c" class="btn btn-primary">
                        <?php echo $isEdit ? "Edit" : "Simpan"; ?>
                    </button>
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
