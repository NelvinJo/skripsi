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

    <title>Barang Keluar</title>

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

        @media print {
            body * {
                visibility: hidden;
            }

            #printArea, #printArea * {
                visibility: visible;
            }

            #printArea {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            .hidden-print,
            .pagination,
            .entries-container,
            th:nth-child(9),
            td:nth-child(9) {
                display: none !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            table th, table td {
                border: 1px solid #000 !important;
                padding: 5px !important;
                font-size: 12px !important;
            }
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

                <div style="text-align: right; margin: 20px;">
                    <a href="keluarform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Form Tambah
                    </a>
                </div>

                <form method="POST">
                    <div class="form-group row mb-2">
                        <label for="searchKeluar" class="col-sm-3">Nama Barang Keluar</label>
                        <div class="col-sm-6">
                            <input type="text" name="searchKeluar" class="form-control" id="searchKeluar" value="<?php if (isset($_POST['searchKeluar'])) { echo htmlspecialchars($_POST['searchKeluar']); } ?>" placeholder="Cari Nama Barang Keluar">
                        </div>
                        <div class="col-sm-1">
                            <input type="submit" style="background-color: #222e3c" name="kirimKeluar" class="btn btn-primary" value="Cari">
                        </div>
                    </div>
                </form>

                <p>
                    <button class="btn btn-success hidden-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak Data Barang Keluar</button>
                </p>

                <div id="printArea">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-3">Tabel Barang Keluar</h1>
                    </div>
                    <div class="card-body">
                        <div class="entries-container">
                            <label for="entriesSelect">Jumlah Data :</label>
                            <select id="entriesSelect">
                                <option value="10" selected>10</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="barangKeluarTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Sub Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Bentuk</th>
                                        <th>Nama Warna</th>
                                        <th>Jumlah Barang Keluar</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal Barang Keluar</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $search = '';
                                if (isset($_POST["kirimKeluar"])) {
                                    $search = mysqli_real_escape_string($connection, $_POST['searchKeluar']);
                                }

                                $query = mysqli_query($connection, "SELECT detailbarangkeluar.DetailKeluarID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, bentuk.NamaBentuk, 
                                                                            warna.NamaWarna, detailbarangkeluar.JumlahKeluar, barangkeluar.NamaPelanggan,
                                                                            barangkeluar.TanggalKeluar
                                                                    FROM detailbarangkeluar
                                                                    JOIN barangkeluar ON detailbarangkeluar.BKID = barangkeluar.BKID
                                                                    JOIN spesifikasibarang ON detailbarangkeluar.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                                    WHERE subkategori.NamaSubKategori LIKE '%$search%' 
                                                                    OR barangtersedia.NamaBarang LIKE '%$search%'
                                                                    OR bentuk.NamaBentuk LIKE '%$search%'
                                                                    OR warna.NamaWarna LIKE '%$search%'
                                                                    OR detailbarangkeluar.JumlahKeluar LIKE '%$search%'
                                                                    OR barangkeluar.NamaPelanggan LIKE '%$search%'
                                                                    OR barangkeluar.TanggalKeluar LIKE '%$search%'");

                                $nomor = 1;
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaSubKategori']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBarang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBentuk']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaWarna']); ?></td>
                                        <td><?php echo htmlspecialchars($row['JumlahKeluar']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaPelanggan']); ?></td>
                                        <td><?php echo htmlspecialchars($row['TanggalKeluar']); ?></td>
                                        <td>
                                            <a href="keluarhapus.php?hapusdk=<?php echo urlencode($row["DetailKeluarID"]); ?>" class="btn btn-danger btn-sm" title="Delete"
                                            onclick="return confirm('Konfirmasi Penghapusan Data Barang Keluar?')">
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
    </div>
    <script src="js/app.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('barangKeluarTable');
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
                prevButton.textContent = 'Sebelumnya';
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
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.classList.toggle('active', i === currentPage);
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        displayTable();
                    });
                    paginationControls.appendChild(pageButton);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Selanjutnya';
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

            entriesSelect.addEventListener('change', () => {
                rowsPerPage = parseInt(entriesSelect.value);
                currentPage = 1;
                displayTable();
            });

            displayTable();
        });
    </script>
</main>
</body>

</html>
