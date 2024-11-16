<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
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

    <title>Barang Tersedia</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .pagination button {
            margin: 0 5px;
            padding: 5px 10px;
            cursor: pointer;
            border: 1px solid #dee2e6;
            background-color: #fff;
            color: #222e3c;
            border-radius: 3px;
        }

        .pagination button.active {
            background-color: #222e3c;
            color: #fff;
        }

        .pagination button.disabled {
            cursor: default;
            color: #ccc;
            border-color: #ccc;
        }

        #entriesSelect {
            margin-bottom: 10px;
        }

        .entries-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
        }

        .entries-container label {
            margin-right: 10px;
            font-weight: bold;
        }

        .alert-rop {
            background-color: #f8d7da;
            color: #842029;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #f5c2c7;
            border-radius: 5px;
        }
    </style>
</head>

<body>
<?php include "header.php"; ?>
<?php include "includes/config.php"; ?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid"></div>

                <?php
                $alertQuery = mysqli_query($connection, "SELECT 
                        spesifikasibarang.SpesifikasiID,
                        barangtersedia.NamaBarang,
                        barangtersedia.SatuanBarang,
                        subkategori.NamaSubKategori,
                        bentuk.NamaBentuk,
                        warna.NamaWarna,
                        spesifikasibarang.JumlahStokBarang,
                        rop.Hasil
                    FROM spesifikasibarang
                    JOIN rop ON spesifikasibarang.SpesifikasiID = rop.SpesifikasiID
                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                    WHERE spesifikasibarang.JumlahStokBarang <= rop.Hasil
                ");

                while ($alertRow = mysqli_fetch_assoc($alertQuery)) {
                    echo "<div class='alert-rop'>
                        <strong>Peringatan : </strong>". "</strong><strong>". htmlspecialchars($alertRow['NamaSubKategori']) . "</strong> <strong>". htmlspecialchars($alertRow['NamaBarang']) . "</strong> 
                        dengan bentuk <strong>" . htmlspecialchars($alertRow['NamaBentuk']) . "</strong> dan warna <strong>" . htmlspecialchars($alertRow['NamaWarna']) . "</strong> 
                        telah mencapai ROP! Stok saat ini adalah " . htmlspecialchars($alertRow['JumlahStokBarang']) . "  dengan ROP " . htmlspecialchars($alertRow['Hasil']) . ".
                    </div>";
                }
                ?>


                <div style="text-align: right; margin: 20px;">
                    <a href="tersediaform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Form Tambah
                    </a>
                </div>

                <form method="POST">
                    <div class="form-group row mb-2">
                        <label for="searchBarang" class="col-sm-3">Nama Barang Tersedia</label>
                        <div class="col-sm-6">
                            <input type="text" name="searchBarang" class="form-control" id="searchBarang" value="<?php if (isset($_POST['searchBarang'])) { echo htmlspecialchars($_POST['searchBarang']); } ?>" placeholder="Cari Nama Barang Tersedia">
                        </div>
                        <div class="col-sm-1">
                            <input type="submit" style="background-color: #222e3c" name="kirimBarang" class="btn btn-primary" value="Search">
                        </div>
                    </div>
                </form>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-3">Tabel Barang Tersedia</h1>
                    </div>
                    <div class="card-body">
                        <div class="entries-container">
                            <label for="entriesSelect">Show entries:</label>
                            <select id="entriesSelect">
                                <option value="10" selected>10</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="barangTersediaTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sub Kategori</th>
                                        <th>Nama Barang Tersedia</th>
                                        <th>Satuan Barang Tersedia</th>
                                        <th>Nama Bentuk</th>
                                        <th>Nama Warna</th>
                                        <th>Jumlah Stok Barang Tersedia</th>
                                        <th>Harga Barang Tersedia</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $search = '';
                                if (isset($_POST["kirimBarang"])) {
                                    $search = mysqli_real_escape_string($connection, $_POST['searchBarang']);
                                }

                                $query = mysqli_query($connection, "SELECT spesifikasibarang.SpesifikasiID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                                                     bentuk.NamaBentuk, warna.NamaWarna, spesifikasibarang.JumlahStokBarang,
                                                                     spesifikasibarang.HargaBarang
                                                             FROM spesifikasibarang
                                                             JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                             JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                             JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                             JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                             WHERE subkategori.NamaSubKategori LIKE '%$search%' 
                                                             OR barangtersedia.NamaBarang LIKE '%$search%' 
                                                             OR barangtersedia.SatuanBarang LIKE '%$search%' 
                                                             OR bentuk.NamaBentuk LIKE '%$search%' 
                                                             OR warna.NamaWarna LIKE '%$search%' 
                                                             OR spesifikasibarang.JumlahStokBarang LIKE '%$search%'
                                                             OR spesifikasibarang.HargaBarang LIKE '%$search%'");

                                $nomor = 1;
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaSubKategori']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBarang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['SatuanBarang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBentuk']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaWarna']); ?></td>
                                        <td><?php echo htmlspecialchars($row['JumlahStokBarang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['HargaBarang']); ?></td>
                                        <td>
                                            <a href="tersediaedit.php?ubahspesifikasi=<?php echo urlencode($row["SpesifikasiID"]); ?>" class="btn btn-success btn-sm" title="Edit">
                                                <img src="icon/pencil-square.svg" alt="Edit" width="16" height="16">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="tersediahapus.php?hapusspesifikasi=<?php echo urlencode($row["SpesifikasiID"]); ?>" class="btn btn-danger btn-sm" title="Delete">
                                                <img src="icon/trash-fill.svg" alt="Delete" width="16" height="16">
                                            </a>
                                        </td>
                                    </tr>
                                <?php $nomor++;
                                } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination" id="paginationControls"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <?php include "footer.php"; ?>
        <script src="js/app.js"></script>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('barangTersediaTable');
        const entriesSelect = document.getElementById('entriesSelect');
        const paginationControls = document.getElementById('paginationControls');
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        let currentPage = 1;
        let rowsPerPage = parseInt(entriesSelect.value);

        function displayTable() {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            renderPaginationControls();
        }

        function renderPaginationControls() {
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            paginationControls.innerHTML = '';

            const prevButton = document.createElement('button');
            prevButton.textContent = 'Prev';
            prevButton.disabled = currentPage === 1;
            prevButton.classList.toggle('disabled', currentPage === 1);
            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayTable();
                }
            });
            paginationControls.appendChild(prevButton);

            for (let i = 1; i <= pageCount; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                if (i === currentPage) {
                    button.classList.add('active');
                }
                button.addEventListener('click', () => {
                    currentPage = i;
                    displayTable();
                });
                paginationControls.appendChild(button);
            }

            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.disabled = currentPage === pageCount;
            nextButton.classList.toggle('disabled', currentPage === pageCount);
            nextButton.addEventListener('click', () => {
                if (currentPage < pageCount) {
                    currentPage++;
                    displayTable();
                }
            });
            paginationControls.appendChild(nextButton);
        }

        function updateTable() {
            rowsPerPage = parseInt(entriesSelect.value);
            currentPage = 1;
            displayTable();
        }

        entriesSelect.addEventListener('change', updateTable);

        displayTable();
    });
</script>

</body>
</html>
