<?php
// Koneksi database
include "includes/config.php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data untuk dropdown Bentuk, Warna, Sub Kategori, dan Nama Barang
$bentukData = [];
$warnaData = [];
$subKategoriData = [];
$barangData = [];

// Query untuk mendapatkan data Bentuk
$bentukQuery = "SELECT BentukID, NamaBentuk FROM bentuk";
$result = $conn->query($bentukQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bentukData[] = $row;
    }
}

// Query untuk mendapatkan data Warna
$warnaQuery = "SELECT WarnaID, NamaWarna FROM warna";
$result = $conn->query($warnaQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $warnaData[] = $row;
    }
}

// Query untuk mendapatkan data Sub Kategori
$subKategoriQuery = "SELECT SubID, NamaSubKategori FROM subkategori";
$result = $conn->query($subKategoriQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subKategoriData[] = $row;
    }
}

// Query untuk mendapatkan data Nama Barang
$barangQuery = "SELECT BarangID, NamaBarang FROM barangtersedia";
$result = $conn->query($barangQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $barangData[] = $row;
    }
}

// Menyimpan data saat form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_data'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $nama_barang_ids = $_POST['nama_barang'];
    $sub_ids = $_POST['sub_kategori'];
    $bentuk_ids = $_POST['bentuk'];
    $warna_ids = $_POST['warna'];
    $jumlah_keluar = $_POST['jumlah_keluar'];

    // Insert ke tabel barangkeluar untuk mendapatkan BKID yang baru
    $stmt = $conn->prepare("INSERT INTO barangkeluar (NamaPelanggan, TanggalKeluar) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama_pelanggan, $tanggal_keluar);
    $stmt->execute();
    $bkid = $stmt->insert_id;
    $stmt->close();

    // Insert detail barang keluar
    $stmt = $conn->prepare("INSERT INTO detailbarangkeluar (BKID, SpesifikasiID, JumlahKeluar) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $bkid, $spesifikasi_id, $jumlah);

    foreach ($nama_barang_ids as $index => $barang_id) {
        $sub_id = $sub_ids[$index];
        $bentuk_id = $bentuk_ids[$index];
        $warna_id = $warna_ids[$index];
        $jumlah = $jumlah_keluar[$index];
        
        // Retrieve the correct SpesifikasiID from the database based on SubID, BentukID, and WarnaID
        $spesifikasiQuery = "SELECT SpesifikasiID FROM spesifikasibarang WHERE BarangID = ? AND SubID = ? AND BentukID = ? AND WarnaID = ?";
        $stmt_spec = $conn->prepare($spesifikasiQuery);
        $stmt_spec->bind_param("iiii", $barang_id, $sub_id, $bentuk_id, $warna_id);
        $stmt_spec->execute();
        $stmt_spec->bind_result($spesifikasi_id);
        $stmt_spec->fetch();
        $stmt_spec->close();

        // Ensure that $spesifikasi_id is set correctly before executing
        if ($spesifikasi_id) {
            $stmt->execute();
        } else {
            echo "<script>alert('SpesifikasiID tidak ditemukan untuk barang dengan ID: $barang_id');</script>";
        }
    }
    
    echo "<script>alert('Data berhasil disimpan!');</script>";
    header("Location: keluar2.php");
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Barang Keluar</title>
    <link href="css/app.css" rel="stylesheet">
    <?php include "header.php";?>
    <style>
        body { font-family: Arial, sans-serif; }
        #table-container { width: 80%; margin: 20px auto; text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        button { padding: 8px 12px; margin-top: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <div id="table-container">
        <form method="post" id="barangKeluarForm">
            <br>
            <table id="dynamic-table">
                <thead>
                    <tr>
                        <th>Sub Kategori</th>
                        <th>Nama Barang</th>
                        <th>Bentuk</th>
                        <th>Warna</th>
                        <th>Jumlah Keluar</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be added here -->
                </tbody>
            </table>
            <button type="button" onclick="addRow()">Add Row</button>
            <button type="submit" name="save_data">Save Data</button>
        </form>
    </div>

    <script>
        // Data options for dropdowns
        const subKategoriOptions = <?php echo json_encode($subKategoriData); ?>;
        const barangOptions = <?php echo json_encode($barangData); ?>;
        const bentukOptions = <?php echo json_encode($bentukData); ?>;
        const warnaOptions = <?php echo json_encode($warnaData); ?>;

        window.onload = function() {
            const form = document.getElementById("barangKeluarForm");

            const pelangganDiv = document.createElement("div");
            
            const namaLabel = document.createElement("label");
            namaLabel.textContent = "Nama Pelanggan:";
            pelangganDiv.appendChild(namaLabel);

            const namaInput = document.createElement("input");
            namaInput.type = "text";
            namaInput.name = "nama_pelanggan";
            namaInput.required = true;
            pelangganDiv.appendChild(namaInput);

            const tanggalLabel = document.createElement("label");
            tanggalLabel.textContent = "Tanggal Keluar:";
            pelangganDiv.appendChild(tanggalLabel);

            const tanggalInput = document.createElement("input");
            tanggalInput.type = "date";
            tanggalInput.name = "tanggal_keluar";
            tanggalInput.required = true;
            pelangganDiv.appendChild(tanggalInput);

            form.insertBefore(pelangganDiv, form.firstChild);
        };

        function addRow() {
            const tableBody = document.getElementById("dynamic-table").getElementsByTagName("tbody")[0];
            const newRow = tableBody.insertRow();

            // Kolom Sub Kategori
            const subCell = newRow.insertCell(0);
            const selectSub = document.createElement("select");
            selectSub.name = "sub_kategori[]";
            subKategoriOptions.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.SubID;
                opt.text = option.NamaSubKategori;
                selectSub.add(opt);
            });
            subCell.appendChild(selectSub);

            // Kolom Nama Barang
            const barangCell = newRow.insertCell(1);
            const selectBarang = document.createElement("select");
            selectBarang.name = "nama_barang[]";
            barangOptions.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.BarangID;
                opt.text = option.NamaBarang;
                selectBarang.add(opt);
            });
            barangCell.appendChild(selectBarang);

            // Kolom Bentuk
            const bentukCell = newRow.insertCell(2);
            const selectBentuk = document.createElement("select");
            selectBentuk.name = "bentuk[]";
            bentukOptions.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.BentukID;
                opt.text = option.NamaBentuk;
                selectBentuk.add(opt);
            });
            bentukCell.appendChild(selectBentuk);

            // Kolom Warna
            const warnaCell = newRow.insertCell(3);
            const selectWarna = document.createElement("select");
            selectWarna.name = "warna[]";
            warnaOptions.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.WarnaID;
                opt.text = option.NamaWarna;
                selectWarna.add(opt);
            });
            warnaCell.appendChild(selectWarna);

            // Kolom Jumlah Keluar
            const jumlahCell = newRow.insertCell(4);
            const jumlahInput = document.createElement("input");
            jumlahInput.type = "number";
            jumlahInput.name = "jumlah_keluar[]";
            jumlahInput.min = "1";
            jumlahCell.appendChild(jumlahInput);

            // Kolom Hapus
            const actionCell = newRow.insertCell(5);
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Delete";
            deleteButton.type = "button";
            deleteButton.onclick = function () {
                tableBody.removeChild(newRow);
            };
            actionCell.appendChild(deleteButton);
        }
    </script>
    <script src="js/app.js"></script>
</body>
</html>
