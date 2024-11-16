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
    <title>Supplier</title>

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
                    <a href="supplierform.php" style="background-color: #222e3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        Form Tambah
                    </a>
                </div>

                <form method="POST">
                    <div class="form-group row mb-2">
                        <label for="search" class="col-sm-3">Nama Supplier</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search" value="<?php if (isset($_POST['search'])) { echo htmlspecialchars($_POST['search']); } ?>" placeholder="Cari Nama Supplier">
                        </div>
                        <input type="submit" style="background-color: #222e3c" name="kirim" class="col-sm-1 btn btn-primary" value="Search">
                    </div>
                </form>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-3">Tabel Supplier</h1>
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
                            <table class="table table-bordered" id="supplierTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>No Telp Supplier</th>
                                    <th>Alamat Supplier</th>
                                    <th>Kota Supplier</th>
                                    <th>Provinsi Supplier</th>
                                    <th colspan="2" style="text-align: center;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $search = '';
                                if (isset($_POST["kirim"])) {
                                    $search = mysqli_real_escape_string($connection, $_POST['search']);
                                }

                                $query = mysqli_query($connection, "SELECT * FROM supplier
                                    WHERE NamaSupplier LIKE '%$search%' 
                                    OR NoTelp LIKE '%$search%' 
                                    OR Alamat LIKE '%$search%' 
                                    OR Kota LIKE '%$search%' 
                                    OR Provinsi LIKE '%$search%'");

                                $nomor = 1;
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo htmlspecialchars($row['NamaSupplier']); ?></td>
                                        <td><?php echo htmlspecialchars($row['NoTelp']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Alamat']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Kota']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Provinsi']); ?></td>
                                        <td>
                                            <a href="supplieredit.php?ubahsupplier=<?php echo urlencode($row["SupplierID"]); ?>" class="btn btn-success btn-sm" title="Edit">
                                                <img src="icon/pencil-square.svg" alt="Edit" width="16" height="16">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="supplierhapus.php?hapussupplier=<?php echo urlencode($row["SupplierID"]); ?>" class="btn btn-danger btn-sm" title="Delete">
                                                <img src="icon/trash-fill.svg" alt="Delete" width="16" height="16">
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $nomor++; ?>
                                <?php } ?>
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
            const table = document.getElementById('supplierTable');
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
