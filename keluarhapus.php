<?php
include "includes/config.php";

if (isset($_GET['hapusdk'])) {
    $kodedk = $_GET["hapusdk"];
    
    // Dapatkan BKID, SpesifikasiID, dan JumlahKeluar yang akan dihapus
    $queryGetKeluar = mysqli_query($connection, "SELECT BKID, SpesifikasiID, JumlahKeluar FROM detailbarangkeluar WHERE DetailKeluarID = '$kodedk'");
    $hasil = mysqli_fetch_assoc($queryGetKeluar);
    $BKID = $hasil['BKID'];
    $SpesifikasiID = $hasil['SpesifikasiID'];
    $JumlahKeluar = $hasil['JumlahKeluar'];

    // Tambahkan kembali jumlah stok pada tabel spesifikasibarang
    mysqli_query($connection, "UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang + $JumlahKeluar WHERE SpesifikasiID = '$SpesifikasiID'");

    // Hapus data dari detailbarangkeluar
    mysqli_query($connection, "DELETE FROM detailbarangkeluar WHERE DetailKeluarID = '$kodedk'");

    // Cek apakah BKID masih memiliki detail di detailbarangkeluar
    $cekKeluar = mysqli_query($connection, "SELECT * FROM detailbarangkeluar WHERE BKID = '$BKID'");
    if (mysqli_num_rows($cekKeluar) == 0) {
        // Hapus data dari barangkeluar jika tidak ada lagi detail terkait
        mysqli_query($connection, "DELETE FROM barangkeluar WHERE BKID = '$BKID'");
    }

    echo "<script>alert('Data Detail Keluar Berhasil Dihapus'); document.location='keluar.php'</script>";
}
?>
