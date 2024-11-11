<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "username", "password", "skripsi");

// Daftar tabel yang akan di-reset auto increment-nya jika kosong
$tabels = [
    "admin", "barangkeluar", "barangmasuk", "barangtersedia", "detailbarangkeluar",
    "detailbarangmasuk", "detailstockopname", "kategori", "rop", "spesifikasibarang",
    "stockopname", "subkategori", "supplier", "bentuk", "warna"
];

// Loop untuk mengecek dan reset auto increment jika tabel kosong
foreach ($tabels as $tabel) {
    // Query untuk cek jumlah data di tabel
    $query = "SELECT COUNT(*) as jumlah FROM $tabel";
    $result = $koneksi->query($query);
    $row = $result->fetch_assoc();

    // Jika jumlah data 0, hapus data dan reset auto increment
    if ($row['jumlah'] == 0) {
        $koneksi->query("DELETE FROM $tabel"); // Hapus semua data
        $koneksi->query("ALTER TABLE $tabel AUTO_INCREMENT = 1"); // Reset auto increment
    }
}

// Tutup koneksi
$koneksi->close();
?>
