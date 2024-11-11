<?php
include "includes/config.php";

if (isset($_GET['hapusdm'])) {
    $kodedm = $_GET["hapusdm"];
    
    // Dapatkan BMID dan jumlah barang yang akan dihapus
    $queryGetMasuk = mysqli_query($connection, "SELECT BMID, SpesifikasiID, JumlahMasuk FROM detailbarangmasuk WHERE DetailMasukID = '$kodedm'");
    $hasil = mysqli_fetch_assoc($queryGetMasuk);
    $BMID = $hasil['BMID'];
    $SpesifikasiID = $hasil['SpesifikasiID'];
    $JumlahMasuk = $hasil['JumlahMasuk'];

    // Kurangi jumlah stok pada tabel spesifikasibarang
    mysqli_query($connection, "UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang - $JumlahMasuk WHERE SpesifikasiID = '$SpesifikasiID'");

    // Hapus data dari detailbarangmasuk
    mysqli_query($connection, "DELETE FROM detailbarangmasuk WHERE DetailMasukID = '$kodedm'");

    // Cek apakah BMID masih memiliki detail di detailbarangmasuk
    $cekMasuk = mysqli_query($connection, "SELECT * FROM detailbarangmasuk WHERE BMID = '$BMID'");
    if (mysqli_num_rows($cekMasuk) == 0) {
        // Hapus data dari barangmasuk jika tidak ada lagi detail terkait
        mysqli_query($connection, "DELETE FROM barangmasuk WHERE BMID = '$BMID'");
    }

    echo "<script>alert('Data Detail Masuk Berhasil Dihapus'); document.location='masuk.php'</script>";
}
?>
