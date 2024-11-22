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
    <title>Barang Masuk</title>
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

            .hidden-print {
                display: none;
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
                    <a href="masukform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Form Tambah
                    </a>
                </div>

                <form method="POST">
                    <div class="form-group row mb-2">
                        <label for="searchMasuk" class="col-sm-3">Nama Barang Masuk</label>
                        <div class="col-sm-6">
                            <input type="text" name="searchMasuk" class="form-control" id="searchMasuk" value="<?php if (isset($_POST['searchMasuk'])) { echo htmlspecialchars($_POST['searchMasuk']); } ?>" placeholder="Cari Nama Barang Masuk">
                        </div>
                        <div class="col-sm-1">
                            <input type="submit" style="background-color: #222e3c" name="kirimMasuk" class="btn btn-primary" value="Search">
                        </div>
                    </div>
                </form>

                <p>
                    <button class="btn btn-success hidden-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak Data Barang</button>
                </p>

                <div id="printArea">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-3">Tabel Barang Masuk</h1>
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
                            <table class="table table-bordered" id="barangMasukTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sub Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Bentuk</th>
                                        <th>Nama Warna</th>
                                        <th>Jumlah Barang Masuk</th>
                                        <th>Nama Supplier</th>
                                        <th>Tanggal Barang Masuk</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $search = '';
                                if (isset($_POST["kirimMasuk"])) {
                                    $search = mysqli_real_escape_string($connection, $_POST['searchMasuk']);
                                }

                                $query = mysqli_query($connection, "SELECT detailbarangmasuk.DetailMasukID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, bentuk.NamaBentuk, 
                                                                            warna.NamaWarna, detailbarangmasuk.JumlahMasuk, supplier.NamaSupplier,
                                                                            barangmasuk.TanggalMasuk
                                                                    FROM detailbarangmasuk
                                                                    JOIN barangmasuk ON detailbarangmasuk.BMID = barangmasuk.BMID
                                                                    JOIN supplier ON barangmasuk.SupplierID = supplier.SupplierID
                                                                    JOIN spesifikasibarang ON detailbarangmasuk.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                                    WHERE subkategori.NamaSubKategori LIKE '%$search%' 
                                                                    OR barangtersedia.NamaBarang LIKE '%$search%'
                                                                    OR bentuk.NamaBentuk LIKE '%$search%'
                                                                    OR warna.NamaWarna LIKE '%$search%'
                                                                    OR detailbarangmasuk.JumlahMasuk LIKE '%$search%'
                                                                    OR supplier.NamaSupplier LIKE '%$search%'
                                                                    OR barangmasuk.TanggalMasuk LIKE '%$search%'");

                                $nomor = 1;
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaSubKategori']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBarang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBentuk']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaWarna']); ?></td>
                                        <td><?php echo htmlspecialchars($row['JumlahMasuk']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaSupplier']); ?></td>
                                        <td><?php echo htmlspecialchars($row['TanggalMasuk']); ?></td>
                                        <td>
                                            <a href="masukhapus.php?hapusdm=<?php echo urlencode($row["DetailMasukID"]); ?>" class="btn btn-danger btn-sm" title="Delete">
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
    <?php include "footer.php"; ?>
    <script src="js/app.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('barangMasukTable');
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
