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
    SpesifikasiBarang.SpesifikasiID,
    SpesifikasiBarang.JumlahStokBarang
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
            "display" => "{$row['NamaSubKategori']} - {$row['NamaBarang']} - {$row['NamaBentuk']} - {$row['NamaWarna']} - {$row['JumlahStokBarang']}"
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_data'])) {
    $spesifikasi_ids = $_POST['spesifikasi_id'];
    $stok_fisik = $_POST['stok_fisik'];
    $tanggal_opname = $_POST['tanggal_opname'];

    $stmt = $conn->prepare("SELECT OpnameID FROM stockopname WHERE TanggalOpname = ?");
    $stmt->bind_param("s", $tanggal_opname);
    $stmt->execute();
    $stmt->bind_result($existingOpnameID);
    $stmt->fetch();
    $stmt->close();

    if (!$existingOpnameID) {
        $stmt = $conn->prepare("INSERT INTO stockopname (TanggalOpname) VALUES (?)");
        $stmt->bind_param("s", $tanggal_opname);
        $stmt->execute();
        $existingOpnameID = $stmt->insert_id;
        $stmt->close();
    }

    foreach ($spesifikasi_ids as $index => $spesifikasi_id) {
        $stok_fisik_input = $stok_fisik[$index];

        $stmt = $conn->prepare("SELECT JumlahStokBarang FROM SpesifikasiBarang WHERE SpesifikasiID = ?");
        $stmt->bind_param("i", $spesifikasi_id);
        $stmt->execute();
        $stmt->bind_result($jumlahStokBarang);
        $stmt->fetch();
        $stmt->close();

        $stokTercatat = $jumlahStokBarang;

        $perbedaan = $stokTercatat - $stok_fisik_input;

        $stmt = $conn->prepare("INSERT INTO detailstockopname (OpnameID, SpesifikasiID, StokTercatat, StokFisik, Perbedaan) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiii", $existingOpnameID, $spesifikasi_id, $stokTercatat, $stok_fisik_input, $perbedaan);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>alert('Stock Opname berhasil disimpan!');</script>";
    header("Location: opname.php");
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

	<title>Stock Opname</title>

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
<h1 class="h3 mb-3">Form Stock Opname</h1>
    <form method="post" id="stockOpnameForm">
            <div>
                <label for="tanggal_opname">Tanggal Opname:</label>
                <input type="date" name="tanggal_opname" id="tanggal_opname" required>
            </div>
            <br>
        <table id="dynamic-table">
            <thead>
                <tr>
                    <th>Data Barang, Spesifikasi & Stok</th>
                    <th>Stok Fisik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button type="submit" style="background-color: #222e3c" class="btn btn-primary btn-spacing" onclick="addRow()">Tambah Data</button>
        <button  type="submit" style="background-color: #222e3c" class="btn btn-primary btn-spacing" name="save_data">Simpan Data</button>
    </form>
    <a href="opname.php" class="btn btn-secondary btn-spacing">Batal</a>
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

        const stokFisikCell = newRow.insertCell();
        const stokFisikInput = document.createElement("input");
        stokFisikInput.type = "number";
        stokFisikInput.name = "stok_fisik[]";
        stokFisikInput.min = "0";
        stokFisikInput.required = true;
        stokFisikCell.appendChild(stokFisikInput);

        const actionCell = newRow.insertCell();
        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Hapus";
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

    function validateForm() {
        const selectedOptions = [];
        const selectElements = document.querySelectorAll("select[name='spesifikasi_id[]']");
        
        for (let i = 0; i < selectElements.length; i++) {
            const value = selectElements[i].value;

            if (selectedOptions.includes(value)) {
                alert("Terdapat data barang dan spesifikasi yang sama. Mohon diperbaiki!");
                return false;
            }
            selectedOptions.push(value);
        }
        return true;
    }

    document.getElementById("stockOpnameForm").addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    $(document).ready(function() {
        $('.comboBoxClass').select2({
            placeholder: "Pilih Data"
        });
    });
</script>
</div>
</div>
<?php include "footer.php"; ?>
<script src="js/app.js"></script>

</body>
</html>
