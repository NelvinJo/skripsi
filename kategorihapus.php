<?php
include "includes/config.php";

if (isset($_GET['hapussub'])) {
    $kodesub = $_GET["hapussub"];
    
    $queryGetKategoriID = mysqli_query($connection, "SELECT KategoriID FROM subkategori WHERE SubID = '$kodesub'");
    $result = mysqli_fetch_assoc($queryGetKategoriID);
    $kategoriID = $result['KategoriID'];
    
    mysqli_query($connection, "DELETE FROM subkategori WHERE SubID = '$kodesub'");

    $cekKategori = mysqli_query($connection, "SELECT * FROM subkategori WHERE KategoriID = '$kategoriID'");

    if (mysqli_num_rows($cekKategori) == 0) {
        mysqli_query($connection, "DELETE FROM kategori WHERE KategoriID = '$kategoriID'");
    }

    echo "<script>alert('Data Sub Kategori Berhasil Dihapus'); document.location='kategori.php'</script>";
}

?>
