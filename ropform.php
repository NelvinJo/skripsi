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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $spekID = $_POST['spekID'];
    $leadTime = $_POST['leadTime'];
    $jumlahpermintaan = $_POST['jumlahPermintaan'];
    $safetyStock = $_POST['safetyStock'];

    $hasil = ($leadTime * $jumlahpermintaan) + $safetyStock;

    $sql = "INSERT INTO rop (SpesifikasiID, LeadTime, JumlahPermintaan, SafetyStock, Hasil) 
            VALUES ('$spekID', '$leadTime', '$jumlahpermintaan', '$safetyStock', '$hasil')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data ROP berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stock Opname</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
</head>
<body>
<?php include "header.php"; ?>
    <h2>Input Data ROP (Reorder Point)</h2>
    <form method="post" action="">
        <label for="spekID">Pilih Barang:</label><br>
        <select id="spekID" name="spekID" required class="select2">
            <option value="">--Pilih Barang--</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['SpesifikasiID']."'>".
                         $row['NamaSubKategori']." - ".$row['NamaBarang']." - ".$row['NamaBentuk']." - ".$row['NamaWarna'].
                         "</option>";
                }
            }
            ?>
        </select><br><br>
        
        <label for="jumlahPermintaan">Jumlah Permintaan :</label><br>
        <input type="number" id="jumlahPermintaan" name="jumlahPermintaan" required><br><br>

        <label for="leadTime">Lead Time :</label><br>
        <input type="number" id="leadTime" name="leadTime" required><br><br>

        <label for="safetyStock">Safety Stock :</label><br>
        <input type="number" id="safetyStock" name="safetyStock"><br><br>

        <input type="submit" value="Hitung dan Simpan ROP">
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>
</html>
