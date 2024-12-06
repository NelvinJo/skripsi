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
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<?php include "header.php"; ?>
<style>
    body { font-family: Arial, sans-serif; }
    #table-container { width: 80%; margin: 20px auto; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 10px; text-align: left; }
    th { background-color: #f4f4f4; }
    .btn-spacing { margin-bottom: 10px; }
    /* Menyelaraskan judul tabel dengan baris di bawahnya */
    thead th, tbody td {
        text-align: left;
    }
    /* Menyesuaikan lebar kolom untuk konsistensi */
    table th, table td {
        padding: 8px;
        text-align: left;
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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comboBoxData as $data) : ?>
                <tr>
                    <td>
                        <input type="hidden" name="spesifikasi_id[]" value="<?php echo $data['SpesifikasiID']; ?>">
                        <?php echo htmlspecialchars($data['display']); ?>
                    </td>
                    <td>
                        <input type="number" name="stok_fisik[]" min="0" required>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" style="background-color: #222e3c" class="btn btn-primary btn-spacing" name="save_data">Simpan Data</button>
    <a href="opname.php" class="btn btn-secondary btn-spacing">Batal</a>
</form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
   $(document).ready(function () {
    // Inisialisasi DataTable
    var table = $('#dynamic-table').DataTable({
        "pageLength": 10, // Default number of entries per page
        "lengthMenu": [10, 30, 50, 100], // Dropdown options for entries
        "ordering": false, // Disable sorting
        "language": {
            "lengthMenu": "Tampilkan _MENU_ entri per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty": "Tidak ada entri tersedia",
            "infoFiltered": "(disaring dari total _MAX_ entri)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // Fungsi untuk validasi form di seluruh halaman pagination
    function validateForm() {
        let isValid = true;

        // Mengambil seluruh input 'stok_fisik' di seluruh tabel (termasuk di halaman lain)
        $('#dynamic-table').DataTable().rows().every(function () {
            // Cek semua input stok_fisik pada setiap baris
            var stokFisik = this.node().querySelector('input[name="stok_fisik[]"]');
            if (stokFisik && (stokFisik.value === "" || stokFisik.value < 0)) {
                isValid = false;
            }
        });

        // Jika ada input yang kosong, tampilkan alert dan kembalikan false
        if (!isValid) {
            alert("Semua kolom stok fisik harus diisi dan tidak boleh kosong!");
        }

        return isValid;
    }

    // Cegah submit form jika ada input yang kosong
    $("#stockOpnameForm").on("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
});
</script>
<script src="js/app.js"></script>
</body>
</html>