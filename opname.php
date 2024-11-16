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
    <title>Stock Opname</title>
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
                    <a href="opnameform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Form Tambah
                    </a>
                </div>

                <form method="POST">
                    <div class="form-group row mb-2">
                        <label for="search" class="col-sm-3">Nama Stock Opname</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search" value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>" placeholder="Cari Data Stock Opname">
                        </div>
                        <div class="col-sm-1">
                            <input type="submit" style="background-color: #222e3c" name="kirim" class="btn btn-primary" value="Search">
                        </div>
                    </div>
                </form>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-3">Tabel Stock Opname</h1>
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
                            <table class="table table-bordered" id="opnameTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Stock Opname</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $search = mysqli_real_escape_string($connection, $_POST['search'] ?? '');
                                    $query = mysqli_query($connection, "SELECT DISTINCT stockopname.TanggalOpname
                                        FROM stockopname
                                        JOIN detailstockopname ON stockopname.OpnameID = detailstockopname.OpnameID
                                        JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                        JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                        WHERE barangtersedia.NamaBarang LIKE '%$search%'
                                        OR stockopname.TanggalOpname LIKE '%$search%'");

                                    $nomor = 1;
                                    while ($row = mysqli_fetch_assoc($query)) { ?>
                                        <tr>
                                            <td><?php echo $nomor++; ?></td>
                                            <td><?php echo $row['TanggalOpname']; ?></td>
                                            <td>
                                                <a href="opnamedetail.php?tanggal=<?php echo urlencode($row['TanggalOpname']); ?>" class="btn btn-info btn-sm" title="View Details">View Details</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination" id="paginationControls"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <script src="js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('opnameTable');
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
