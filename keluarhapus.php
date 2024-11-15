<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_GET['hapusdk'])) {
    $kodedk = $_GET["hapusdk"];
    
    $queryGetKeluar = mysqli_query($connection, "SELECT BKID, SpesifikasiID, JumlahKeluar FROM detailbarangkeluar WHERE DetailKeluarID = '$kodedk'");
    $hasil = mysqli_fetch_assoc($queryGetKeluar);
    $BKID = $hasil['BKID'];
    $SpesifikasiID = $hasil['SpesifikasiID'];
    $JumlahKeluar = $hasil['JumlahKeluar'];

    mysqli_query($connection, "UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang + $JumlahKeluar WHERE SpesifikasiID = '$SpesifikasiID'");

    mysqli_query($connection, "DELETE FROM detailbarangkeluar WHERE DetailKeluarID = '$kodedk'");

    $cekKeluar = mysqli_query($connection, "SELECT * FROM detailbarangkeluar WHERE BKID = '$BKID'");
    if (mysqli_num_rows($cekKeluar) == 0) {
        mysqli_query($connection, "DELETE FROM barangkeluar WHERE BKID = '$BKID'");
    }

    echo "<script>alert('Data Detail Keluar Berhasil Dihapus'); document.location='keluar.php'</script>";
}
?>