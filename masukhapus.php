<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_GET['hapusdm'])) {
    $kodedm = $_GET["hapusdm"];
    
    $queryGetMasuk = mysqli_query($connection, "SELECT BMID, SpesifikasiID, JumlahMasuk FROM detailbarangmasuk WHERE DetailMasukID = '$kodedm'");
    $hasil = mysqli_fetch_assoc($queryGetMasuk);
    $BMID = $hasil['BMID'];
    $SpesifikasiID = $hasil['SpesifikasiID'];
    $JumlahMasuk = $hasil['JumlahMasuk'];

    mysqli_query($connection, "UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang - $JumlahMasuk WHERE SpesifikasiID = '$SpesifikasiID'");

    mysqli_query($connection, "DELETE FROM detailbarangmasuk WHERE DetailMasukID = '$kodedm'");

    $cekMasuk = mysqli_query($connection, "SELECT * FROM detailbarangmasuk WHERE BMID = '$BMID'");
    if (mysqli_num_rows($cekMasuk) == 0) {
        mysqli_query($connection, "DELETE FROM barangmasuk WHERE BMID = '$BMID'");
    }

    echo "<script>alert('Data Detail Masuk Berhasil Dihapus'); document.location='masuk.php'</script>";
}
?>
