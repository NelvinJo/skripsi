<?php
session_start();
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'owner') {
    header("Location: menuutama.php");
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
    <title>Admin</title>

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
        td:nth-child(9),
        th:nth-child(10),
        td:nth-child(10) {
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
        
        th:nth-child(8), td:nth-child(8) {
        display: none !important;
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
                    <a href="adminform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Form Tambah
                    </a>
                </div>

                <form method="POST">
                    <div class="form-group row mb-2">
                        <label for="search" class="col-sm-3">Nama Admin</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search" value="<?php if (isset($_POST['search'])) { echo htmlspecialchars($_POST['search']); } ?>" placeholder="Cari Nama Admin">
                        </div>
                        <div class="col-sm-1">
                            <input type="submit" style="background-color: #222e3c" name="kirim" class="btn btn-primary" value="Cari">
                        </div>
                    </div>
                </form>

                <p>
                    <button class="btn btn-success hidden-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak Data Admin</button>
                </p>

                <div id="printArea">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-3">Tabel Admin</h1>
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
                            <table class="table table-bordered" id="adminTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Depan Admin</th>
                                        <th>Nama Belakang Admin</th>
                                        <th>Nomor Handphone Admin</th>
                                        <th>Email Admin</th>
                                        <th>Password Admin</th>
                                        <th>Role Admin</th>
                                        <th colspan="2" style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $search = '';
                                if (isset($_POST["kirim"])) {
                                    $search = mysqli_real_escape_string($connection, $_POST['search']);
                                }

                                $query = mysqli_query($connection, "SELECT * FROM admin WHERE 
                                    NamaDepan LIKE '%$search%' 
                                    OR NamaBelakang LIKE '%$search%' 
                                    OR NoHP LIKE '%$search%' 
                                    OR Email LIKE '%$search%' 
                                    OR Password LIKE '%$search%' 
                                    OR Role LIKE '%$search%'");

                                $nomor = 1;
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaDepan']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaBelakang']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NoHP']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                        <td><?php echo str_repeat('*', strlen($row['Password'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['Role']); ?></td>
                                        <td>
                                            <a href="adminedit.php?ubahadmin=<?php echo urlencode($row["AdminID"]); ?>" class="btn btn-success btn-sm" title="Edit">
                                                <img src="icon/pencil-square.svg" alt="Edit" width="16" height="16">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="adminhapus.php?hapusadmin=<?php echo urlencode($row["AdminID"]); ?>" class="btn btn-danger btn-sm" title="Delete"
                                            onclick="return confirm('Konfirmasi Penghapusan Data Admin?')">
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
        <script src="js/app.js"></script>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('adminTable');
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
