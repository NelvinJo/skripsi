<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
	include "includes/config.php" ;
	if(isset($_GET['hapussupplier']))
	{
		$kodesupplier = $_GET["hapussupplier"] ;
		mysqli_query($connection,"delete from supplier where SupplierID = '$kodesupplier'") ;

		echo "<script>alert('Data Berhasil Dihapus');
		document.location='supplier.php'</script>" ;
	}


?>