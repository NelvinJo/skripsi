<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'skripsi';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $spekID = $_POST['spekID'];
    $leadTime = $_POST['leadTime'];
    $jumlahpermintaan = $_POST['jumlahPermintaan'];
    $safetyStock = $_POST['safetyStock'];

    // Hitung ROP
    $hasil = ($leadTime * $jumlahpermintaan) + $safetyStock;

    // Simpan ROP ke database
    $sql = "INSERT INTO rop (SpesifikasiID, LeadTime, JumlahPermintaan, SafetyStock, Hasil) VALUES ('$spekID', '$leadTime', '$jumlahpermintaan', '$safetyStock', '$hasil')";
    
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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Stock Opname</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<?php include "header.php"; ?>
</head>
<body>
    <h2>Input Data ROP (Reorder Point)</h2>
    <form method="post" action="">
        <label for="spekID">Barang ID:</label><br>
        <input type="text" id="spekID" name="spekID" required><br><br>
        
        <label for="leadTime">Lead Time (Hari):</label><br>
        <input type="number" id="leadTime" name="leadTime" required><br><br>
        
        <label for="jumlahPermintaan">Usage Rate (Penggunaan Harian):</label><br>
        <input type="number" id="jumlahPermintaan" name="jumlahPermintaan" required><br><br>
        
        <label for="safetyStock">Safety Stock (Opsional):</label><br>
        <input type="number" id="safetyStock" name="safetyStock" value="0"><br><br>
        
        <input type="submit" value="Hitung dan Simpan ROP">
    </form>
</body>
</html>
