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
</head>
<?php include "header.php";?>
<div class="container-fluid">
<div class="card shadow mb-4">
<?php
  include "includes/config.php" ;
?>

<body>
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
                    <label for="searchOpname" class="col-sm-3">Nama Stock Opname</label>
                    <div class="col-sm-6">
                        <input type="text" name="searchOpname" class="form-control" id="searchOpname" value="<?php if(isset($_POST['searchOpname'])) {echo $_POST['searchOpname'];} ?>" placeholder="Cari Data Stock Opname">
                    </div>
                    <input type="submit" style="background-color: #222e3c" name="kirimOpname" class="col-sm-1 btn btn-primary" value="Search">
                </div>
            </form>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Stock Opname</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sub Kategori</th>
                                    <th>Nama Barang Tersedia</th>
                                    <th>Satuan Barang Tersedia</th>
                                    <th>Nama Bentuk</th>
                                    <th>Nama Warna</th>
                                    <th>Jumlah Stok Barang Tersedia</th>
                                    <th>Stok Fisik</th>
                                    <th>Perbedaan</th>
                                    <th>Tanggal Stock Opname</th>
                                    <th colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>	
                            <tbody>		

                            <?php
                            if(isset($_POST["kirimOpname"])) {
                                $search = $_POST['searchOpname'];
                                $query = mysqli_query($connection, "SELECT detailstockopname.DetailOpnameID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                                                            bentuk.NamaBentuk, warna.NamaWarna, spesifikasibarang.JumlahStokBarang,
                                                                            detailstockopname.StokFisik, detailstockopname.Perbedaan, stockopname.TanggalOpname
                                                                    FROM detailstockopname
                                                                    JOIN stockopname ON detailstockopname.OpnameID = stockopname.OpnameID
                                                                    JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID
                                                                    WHERE barangtersedia.NamaBarang LIKE '%$search%' 
                                                                    OR barangtersedia.SatuanBarang LIKE '%$search%' 
                                                                    OR bentuk.NamaBentuk LIKE '%$search%' 
                                                                    OR warna.NamaWarna LIKE '%$search%' 
                                                                    OR spesifikasibarang.JumlahStokBarang LIKE '%$search%'
                                                                    OR detailstockopname.StokFisik LIKE '%$search%'
                                                                    OR detailstockopname.Perbedaan LIKE '%$search%'
                                                                    OR stockopname.TanggalOpname LIKE '%$search%'");
                            } else {
                                $query = mysqli_query($connection, "SELECT detailstockopname.DetailOpnameID, subkategori.NamaSubKategori, barangtersedia.NamaBarang, barangtersedia.SatuanBarang,
                                                                            bentuk.NamaBentuk, warna.NamaWarna, spesifikasibarang.JumlahStokBarang,
                                                                            detailstockopname.StokFisik, detailstockopname.Perbedaan, stockopname.TanggalOpname
                                                                    FROM detailstockopname
                                                                    JOIN stockopname ON detailstockopname.OpnameID = stockopname.OpnameID
                                                                    JOIN spesifikasibarang ON detailstockopname.SpesifikasiID = spesifikasibarang.SpesifikasiID
                                                                    JOIN barangtersedia ON spesifikasibarang.BarangID = barangtersedia.BarangID
                                                                    JOIN subkategori ON barangtersedia.SubID = subkategori.SubID
                                                                    JOIN bentuk ON spesifikasibarang.BentukID = bentuk.BentukID
                                                                    JOIN warna ON spesifikasibarang.WarnaID = warna.WarnaID");
                            }

                            $nomor = 1;
                            while($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $row['NamaSubKategori']; ?></td>
                                    <td><?php echo $row['NamaBarang']; ?></td>
                                    <td><?php echo $row['SatuanBarang']; ?></td>
                                    <td><?php echo $row['NamaBentuk']; ?></td>
                                    <td><?php echo $row['NamaWarna']; ?></td>
                                    <td><?php echo $row['JumlahStokBarang']; ?></td>
                                    <td><?php echo $row['StokFisik']; ?></td>
                                    <td><?php echo $row['Perbedaan']; ?></td>
                                    <td><?php echo $row['TanggalOpname']; ?></td>
                                    <td>
                                    <a href="tersediaedit.php?ubahspesifikasi=<?php echo $row["DetailOpnameID"]?>" class="btn btn-success btn-sm" title="Edit">
                                        <i class="bi bi-pencil-square"><img src="icon/pencil-square.svg"></i>
                                            </a>

                                    </td>
                                    <td>
                                    <a href="tersediahapus.php?hapusspesifikasi=<?php echo $row["DetailOpnameID"]?>" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="bi bi-trash-fill.svg"><img src="icon/trash-fill.svg"></i>
                                            </a>
                                        
			</td>

		</tr>

        <?php $nomor++; } ?>
			
</tbody>	  
</table>

</div>
                </div>
            </div>
	</div>
	<?php include "footer.php"; ?>
	<script src="js/app.js"></script>
	
</body>
</html>