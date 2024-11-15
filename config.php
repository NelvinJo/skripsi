<?php
$koneksi = new mysqli("localhost", "username", "password", "skripsi");

$tabels = ["admin", "barangkeluar", "barangmasuk", "barangtersedia", "detailbarangkeluar",
    "detailbarangmasuk", "detailstockopname", "kategori", "rop", "spesifikasibarang",
    "stockopname", "subkategori", "supplier", "bentuk", "warna"];

foreach ($tabels as $tabel) {
    $query = "SELECT COUNT(*) as jumlah FROM $tabel";
    $result = $koneksi->query($query);
    $row = $result->fetch_assoc();

    if ($row['jumlah'] == 0) {
        $koneksi->query("DELETE FROM $tabel");
        $koneksi->query("ALTER TABLE $tabel AUTO_INCREMENT = 1");
    }
}

$koneksi->close();
?>
