<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$comboBoxData = [];
$comboBoxQuery = "SELECT
    SubKategori.NamaSubKategori,
    BarangTersedia.BarangID,
    BarangTersedia.NamaBarang,
    Bentuk.BentukID,
    Bentuk.NamaBentuk,
    Warna.WarnaID,
    Warna.NamaWarna,
    SpesifikasiBarang.SpesifikasiID
FROM
    SpesifikasiBarang
JOIN
    BarangTersedia ON SpesifikasiBarang.BarangID = BarangTersedia.BarangID
JOIN
    SubKategori ON BarangTersedia.SubID = SubKategori.SubID
JOIN
    Bentuk ON SpesifikasiBarang.BentukID = Bentuk.BentukID
JOIN
    Warna ON SpesifikasiBarang.WarnaID = Warna.WarnaID";

$result = $conn->query($comboBoxQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comboBoxData[] = [
            "SpesifikasiID" => $row["SpesifikasiID"],
            "display" => "{$row['NamaSubKategori']} - {$row['NamaBarang']} - {$row['NamaBentuk']} - {$row['NamaWarna']}"
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_data'])) {
    $pelanggan = $_POST['pelanggan'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $spesifikasi_ids = $_POST['spesifikasi_id'];
    $jumlah_keluar = $_POST['jumlah_keluar'];

    $stmt = $conn->prepare("INSERT INTO barangkeluar (NamaPelanggan, TanggalKeluar) VALUES (?, ?)");
    $stmt->bind_param("ss", $pelanggan, $tanggal_keluar);
    $stmt->execute();
    $bkid = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO detailbarangkeluar (BKID, SpesifikasiID, JumlahKeluar) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $bkid, $spesifikasi_id, $jumlah);

    foreach ($spesifikasi_ids as $index => $spesifikasi_id) {
        $jumlah = $jumlah_keluar[$index];
        $stmt->execute();

        $updateStockStmt = $conn->prepare("UPDATE spesifikasibarang SET JumlahStokBarang = JumlahStokBarang - ? WHERE SpesifikasiID = ?");
        $updateStockStmt->bind_param("ii", $jumlah, $spesifikasi_id);
        $updateStockStmt->execute();
        $updateStockStmt->close();
    }

    echo "<script>alert('Data berhasil disimpan!');</script>";
    header("Location: keluar.php");
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
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Barang Keluar</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<?php include "header.php"; ?>
<style>
    body { 
        font-family: Arial, sans-serif; 
    }
    #table-container { 
        width: 80%; 
        margin: 20px auto; 
        text-align: center; 
    }
    table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    table, th, td { 
        border: 1px solid #ddd; 
        padding: 8px; 
    }
    th { 
        background-color: #f4f4f4; 
    }
    button { 
        padding: 8px 12px; 
        margin-top: 10px; 
        cursor: pointer; 
    }
    .btn-spacing {
        margin-bottom: 10px;
    }
</style>
</head>
<body>
            <div id="table-container">
            <h1 class="h3 mb-3">Form Barang Keluar</h1>
                <form method="post" id="barangKeluarForm">
            <div class="form-group row">
                <label for="pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pelanggan" name="pelanggan" placeholder="Nama Pelanggan" required>
                </div>
            </div>

            <div>
                <label for="tanggal_keluar">Tanggal Keluar:</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" required>
            </div>
            <br>
            <table id="dynamic-table">
                <thead>
                    <tr>
                        <th>Data Barang & Spesifikasi</th>
                        <th>Jumlah Keluar</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button type="submit" style="background-color: #222e3c" class="btn btn-primary btn-spacing" onclick="addRow()">Add Row</button>
            <button  type="submit" style="background-color: #222e3c" class="btn btn-primary btn-spacing" name="save_data">Save Data</button>
        </form>
        <a href="keluar.php" class="btn btn-secondary btn-spacing">Batal</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        const comboBoxOptions = <?php echo json_encode($comboBoxData); ?>;

        function addRow() {
            const tableBody = document.getElementById("dynamic-table").getElementsByTagName("tbody")[0];
            const newRow = tableBody.insertRow();

            const comboBoxCell = newRow.insertCell();
            const comboBoxSelect = document.createElement("select");
            comboBoxSelect.name = "spesifikasi_id[]";
            comboBoxSelect.required = true;
            comboBoxSelect.classList.add("comboBoxClass");

            const defaultOption = document.createElement("option");
            defaultOption.text = "Pilih Data";
            defaultOption.value = "";
            comboBoxSelect.appendChild(defaultOption);

            comboBoxOptions.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.SpesifikasiID;
                opt.text = option.display;
                comboBoxSelect.appendChild(opt);
            });
            comboBoxCell.appendChild(comboBoxSelect);

            const jumlahCell = newRow.insertCell();
            const jumlahInput = document.createElement("input");
            jumlahInput.type = "number";
            jumlahInput.name = "jumlah_keluar[]";
            jumlahInput.min = "1";
            jumlahInput.required = true;
            jumlahCell.appendChild(jumlahInput);

            const actionCell = newRow.insertCell();
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Delete";
            deleteButton.type = "button";
            deleteButton.classList.add("btn", "btn-primary");
            deleteButton.style.backgroundColor = "#222e3c";
            deleteButton.onclick = function () {
            tableBody.removeChild(newRow);
            };
            actionCell.appendChild(deleteButton);

            $(comboBoxSelect).select2({
                width: 'resolve',
                placeholder: "Pilih Data"
            });
        }

        $(document).ready(function() {
            $('.comboBoxClass').select2({
                placeholder: "Pilih Data"
            });
        });
    </script>
	<script src="js/app.js"></script>
</body>
</html>
