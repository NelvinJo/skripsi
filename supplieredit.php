<!DOCTYPE html>

<?php
include "includes/config.php";

if(isset($_POST['Edit'])) {

  if(isset($_REQUEST['inputkode'])) {
    $supplierkode = $_REQUEST['inputkode'];
  }

  if(!empty($supplierkode)) {
    $supplierkode = $_REQUEST['inputkode'];
  }

  else {
    ?> <h1>Anda harus mengisi data</h1> <?php
    die ("Anda harus memasukkan datanya");
  }

    $namasupplier = $_POST['inputnama'] ;
    $telp = $_POST['inputtelp'] ;
    $alamat = $_POST['inputalamat'] ;
    $kota = $_POST['inputkota'] ;
    $provinsi = $_POST['inputprovinsi'] ;

    mysqli_query($connection,"update supplier set NamaSupplier='$namasupplier',NoTelp='$telp',Alamat='$alamat',Kota='$kota',Provinsi='$provinsi' where SupplierID = '$supplierkode'");

    header("Location:supplier.php") ;

}
$kodesupplier = $_GET["ubahsupplier"] ;
$editsupplier = mysqli_query($connection,"select * from supplier where SupplierID = '$kodesupplier' ") ;
$rowedit = mysqli_fetch_array($editsupplier) ;

?>
<html>
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

	<title>Supplier</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4">Input Supplier</h1>
                    </div>
                </div>

                    <form method="POST">
                    <div class="form-group row">
                      <label for="kodesupplier" class="col-sm-2 col-form-label">Kode Supplier</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="kodesupplier" name="inputkode" placeholder="Kode Supplier" maxlength="4" value="<?php echo $rowedit["SupplierID"]?>" readonly>
                      </div>
                    </div>
        
                    <div class="form-group row">
                      <label for="namasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputnama" id="namasupplier" placeholder="Nama Supplier" value="<?php echo $rowedit["NamaSupplier"]?>">
                      </div>
                    </div>
        
                    <div class="form-group row">
                      <label for="telp" class="col-sm-2 col-form-label">No Telp Supplier</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputtelp" id="telp" placeholder="Nomor Telepon Supplier" value="<?php echo $rowedit["NoTelp"]?>">
                      </div>
                    </div>
        
                    <div class="form-group row">
                      <label for="alamat" class="col-sm-2 col-form-label">Alamat Supplier</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputalamat" id="alamat" placeholder="Alamat Supplier" value="<?php echo $rowedit["Alamat"]?>">
                      </div>
                    </div>
        
                    <div class="form-group row">
                      <label for="kota" class="col-sm-2 col-form-label">Kota Supplier</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputkota" id="kota" placeholder="Kota Supplier" value="<?php echo $rowedit["Kota"]?>">
                      </div>
                    </div>
        
                    <div class="form-group row">
                      <label for="provinsi" class="col-sm-2 col-form-label">Provinsi Supplier</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputprovinsi" id="provinsi" placeholder="Provinsi Supplier" value="<?php echo $rowedit["Provinsi"]?>">
                      </div>
                    </div>
        
        <div class="form-group row">
                <div class="col-sm-2">
                  </div>
                <div class="col-sm-10">
                  <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Edit" name="Edit">
                  <input type="reset" class="btn btn-secondary" value="Batal" name="Batal">
                </div>
              </div>
                  </form>
        
                </div>
        
                <div class="col-sm-1">
                </div>
              </div> <!-- penutup class row -->
        
                  </div>
                  <div class="col-sm-1"></div>
        
                </div>
        
                <tbody>
        
                      <a href="supplieredit.php?ubahsupplier=<?php echo $row["SupplierID"]?>"</a>
                    </td>
        
                    <td>
                      <a href="supplierhapus.php?hapussupplier=<?php echo $row["SupplierID"]?>"</a>
                    </td>
        
                          </tr>
        
                      </tbody>
        
              </body>
              <?php include "footer.php";?>
	            <script src="js/app.js"></script>
              <?php
              mysqli_close($connection);
              ob_end_flush();
              ?>
              </html>