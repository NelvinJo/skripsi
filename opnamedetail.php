<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
include "includes/config.php";

$tanggalOpname = $_GET['tanggal'] ?? '';
$searchDetail = $_POST['searchDetail'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Stock Opname</title>
    <link href="css/app.css" rel="stylesheet">
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
            th:nth-child(10), td:nth-child(10) {
                display: none !important;
        }
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <div class="jumbotron jumbotron-fluid"></div>

                    <form method="POST">
                        <div class="form-group row mb-2">
                            <label for="searchDetail" class="col-sm-3">Nama Detail Stock Opname</label>
                            <div class="col-sm-6">
                                <input type="text" name="searchDetail" class="form-control" id="searchDetail" value="<?php echo htmlspecialchars($searchDetail); ?>" placeholder="Cari Data Detail Stock Opname">
                            </div>
                            <div class="col-sm-1">
                                <input type="submit" style="background-color: #222e3c" name="kirimDetail" class="btn btn-primary" value="Cari">
                            </div>
                        </div>
                    </form>

                    <p>
                    <button class="btn btn-success hidden-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak Data Detail Stock Opname</button>
                </p>

                <div id="printArea">
                    <?php if (!empty($tanggalOpname)) { ?>
                        <div class="card shadow mb-4 mt-5">
                            <div class="card-header py-3">
                                <h1 class="h3 mb-3">Detail Stock Opname - <?php echo htmlspecialchars($tanggalOpname); ?></h1>
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
                                    <table class="table table-bordered" id="detailTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Sub Kategori</th>
                                                <th>Nama Barang</th>
                                                <th>Satuan Barang</th>
                                                <th>Nama Bentuk</th>
                                                <th>Nama Warna</th>
                                                <th>Jumlah Stok Barang</th>
                                                <th>Stok Fisik</th>
                                                <th>Perbedaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryCondition = "WHERE stockopname.TanggalOpname = '$tanggalOpname'";

                                            if (!empty($searchDetail)) {
                                                $safeSearch = mysqli_real_escape_string($connection, $searchDetail);
                                                $queryCondition .= " AND ( subkategori.NamaSubKategori LIKE '%$safeSearch%' 
                                                                        OR barangtersedia.NamaBarang LIKE '%$safeSearch%'
                                                                        OR barangtersedia.SatuanBarang LIKE '%$safeSearch%'
                                                                        OR bentuk.NamaBentuk LIKE '%$safeSearch%' 
                                                                        OR warna.NamaWarna LIKE '%$safeSearch%'
                                                                        OR spesifikasibarang.JumlahStokBarang LIKE '%$safeSearch%'
                                                                        OR detailstockopname.StokFisik LIKE '%$safeSearch%'
                                                                        OR detailstockopname.Perbedaan LIKE '%$safeSearch%')";
                                            }

                                            $queryDetail = mysqli_query($connection, "SELECT detailstockopname.DetailOpnameID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                                                        bentuk.NamaBentuk, warna.NamaWarna, detailstockopname.StokTercatat,
                                                                        detailstockopname.StokFisik, detailstockopname.Perbedaan
                                                                        FROM detailstockopname
                                                                        JOIN stockopname ON detailstockopname.OpnameID = stockopname.OpnameID
                                                                        JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                        JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                        JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                        JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                        JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                                        WHERE stockopname.TanggalOpname = '$tanggalOpname'");

                                            $nomor = 1;
                                            while ($row = mysqli_fetch_assoc($queryDetail)) { ?>
                                                <tr>
                                                    <td><?php echo $nomor++; ?></td>
                                                    <td><?php echo $row['NamaSubKategori']; ?></td>
                                                    <td><?php echo $row['NamaBarang']; ?></td>
                                                    <td><?php echo $row['SatuanBarang']; ?></td>
                                                    <td><?php echo $row['NamaBentuk']; ?></td>
                                                    <td><?php echo $row['NamaWarna']; ?></td>
                                                    <td><?php echo $row['StokTercatat']; ?></td> <!-- Mengambil dari StokTercatat -->
                                                    <td><?php echo $row['StokFisik']; ?></td>
                                                    <td><?php echo $row['Perbedaan']; ?></td>
                                                    <td>
                                                        <a href="opnamehapus.php?hapusopname=<?php echo urlencode($row["DetailOpnameID"]); ?>" class="btn btn-danger btn-sm" title="Delete">
                                                            <img src="icon/trash-fill.svg" alt="Delete" width="16" height="16">
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="pagination" id="paginationControls"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <?php include "footer.php"; ?>
    <script src="js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('detailTable');
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
</body>

</html>
