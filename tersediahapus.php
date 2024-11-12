<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_GET['hapusspesifikasi'])) {
    $kodespek = $_GET["hapusspesifikasi"];
    
    $queryGetBarangID = mysqli_query($connection, "SELECT BarangID FROM spesifikasibarang WHERE SpesifikasiID = '$kodespek'");
    $hasil = mysqli_fetch_assoc($queryGetBarangID);
    $barangID = $hasil['BarangID'];
    
    mysqli_query($connection, "DELETE FROM spesifikasibarang WHERE SpesifikasiID = '$kodespek'");

    $cekBarang = mysqli_query($connection, "SELECT * FROM spesifikasibarang WHERE BarangID = '$barangID'");

    if (mysqli_num_rows($cekBarang) == 0) {
        mysqli_query($connection, "DELETE FROM barangtersedia WHERE BarangID = '$barangID'");
    }

    echo "<script>alert('Data Spesifikasi Berhasil Dihapus'); document.location='tersedia.php'</script>";
}
?>