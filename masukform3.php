<?php
// Koneksi database
include "includes/config.php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for Supplier dropdown
$supplierData = [];
$supplierQuery = "SELECT SupplierID, NamaSupplier FROM supplier";
$result = $conn->query($supplierQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $supplierData[] = $row;
    }
}

// Fetch data for dropdowns
$bentukData = $warnaData = $barangData = [];
function fetchDropdownData($conn, $table, $idField, $nameField, &$dataArray) {
    $query = "SELECT $idField AS id, $nameField AS name FROM $table";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataArray[] = $row;
        }
    }
}

// Mengambil data untuk dropdown bentuk, warna, dan barang
fetchDropdownData($conn, "bentuk", "BentukID", "NamaBentuk", $bentukData);
fetchDropdownData($conn, "warna", "WarnaID", "NamaWarna", $warnaData);
fetchDropdownData($conn, "barangtersedia", "BarangID", "NamaBarang", $barangData);


// Fetch data for subkategori connected to barangtersedia through spesifikasibarang
// Fetch data for subkategori through barangtersedia using SubID
$subKategoriData = [];
$subKategoriQuery = "SELECT 
    SpesifikasiBarang.*,
    SubKategori.NamaSubKategori
FROM 
    SpesifikasiBarang
JOIN 
    BarangTersedia ON SpesifikasiBarang.BarangID = BarangTersedia.BarangID
JOIN 
    SubKategori ON BarangTersedia.SubID = SubKategori.SubID";

    
$result = $conn->query($subKategoriQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subKategoriData[] = $row;
    }
}


// Handle form submission to save data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_data'])) {
    $supplier_id = $_POST['supplier_id'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $nama_barang_ids = $_POST['nama_barang'];
    $sub_ids = $_POST['sub_kategori'];
    $bentuk_ids = $_POST['bentuk'];
    $warna_ids = $_POST['warna'];
    $jumlah_masuk = $_POST['jumlah_masuk'];

    // Insert into barangmasuk table to get BMID
    $stmt = $conn->prepare("INSERT INTO barangmasuk (SupplierID, TanggalMasuk) VALUES (?, ?)");
    $stmt->bind_param("is", $supplier_id, $tanggal_masuk);
    $stmt->execute();
    $bmid = $stmt->insert_id;
    $stmt->close();

    // Insert into detailbarangmasuk
    $stmt = $conn->prepare("INSERT INTO detailbarangmasuk (BMID, SpesifikasiID, JumlahMasuk) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $bmid, $spesifikasi_id, $jumlah);

    foreach ($nama_barang_ids as $index => $barang_id) {
        $bentuk_id = $bentuk_ids[$index];
        $warna_id = $warna_ids[$index];
        $jumlah = $jumlah_masuk[$index];

        // Get the correct SpesifikasiID
        $spesifikasiQuery = "SELECT SpesifikasiID FROM spesifikasibarang WHERE BarangID = ? AND BentukID = ? AND WarnaID = ? AND JumlahStokBarang = ?";
        $stmt_spec = $conn->prepare($spesifikasiQuery);
        $stmt_spec->bind_param("iiii", $barang_id, $bentuk_id, $warna_id);
        $stmt_spec->execute();
        $stmt_spec->bind_result($spesifikasi_id);
        $stmt_spec->fetch();
        $stmt_spec->close();

        if ($spesifikasi_id) {
            $stmt->execute();
        } else {
            echo "<script>alert('SpesifikasiID tidak ditemukan untuk barang dengan ID: $barang_id');</script>";
        }
    }
    
    echo "<script>alert('Data berhasil disimpan!');</script>";
    header("Location: masuk2.php");
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
	<meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Barang Masuk</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
        <form method="post" id="barangMasukForm">
            <div>
                <label for="supplier_id">Nama Supplier:</label>
                <select name="supplier_id" id="supplier_id" required>
                    <?php foreach ($supplierData as $supplier): ?>
                        <option value="<?php echo $supplier['SupplierID']; ?>">
                            <?php echo $supplier['NamaSupplier']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="tanggal_masuk">Tanggal Masuk:</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" required>
            </div>
            <br>
            <table id="dynamic-table">
                <thead>
                    <tr>
                        <th>Sub Kategori</th>
                        <th>Nama Barang</th>
                        <th>Bentuk</th>
                        <th>Warna</th>
                        <th>Jumlah Masuk</th>
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
       const subKategoriOptions = <?php echo json_encode($subKategoriData); ?>;
const barangOptions = <?php echo json_encode($barangData); ?>;
const bentukOptions = <?php echo json_encode($bentukData); ?>;
const warnaOptions = <?php echo json_encode($warnaData); ?>;

function addRow() {
    const tableBody = document.getElementById("dynamic-table").getElementsByTagName("tbody")[0];
    const newRow = tableBody.insertRow();

    function createDropdownCell(data, name) {
        const cell = newRow.insertCell();
        const select = document.createElement("select");
        select.name = name;
        select.required = true;
        data.forEach(option => {
            const opt = document.createElement("option");
            opt.value = option.SubID || option.id;
            opt.text = option.NamaSubKategori || option.name;
            select.appendChild(opt);
        });
        cell.appendChild(select);
    }

    createDropdownCell(subKategoriOptions, "sub_kategori[]");
    createDropdownCell(barangOptions, "nama_barang[]");
    createDropdownCell(bentukOptions, "bentuk[]");
    createDropdownCell(warnaOptions, "warna[]");

    const jumlahCell = newRow.insertCell();
    const jumlahInput = document.createElement("input");
    jumlahInput.type = "number";
    jumlahInput.name = "jumlah_masuk[]";
    jumlahInput.min = "1";
    jumlahInput.required = true;
    jumlahCell.appendChild(jumlahInput);

    const actionCell = newRow.insertCell();
    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.type = "button";
    deleteButton.onclick = function () {
        tableBody.removeChild(newRow);
    };
    actionCell.appendChild(deleteButton);
}

    </script>
</body>
</html>
