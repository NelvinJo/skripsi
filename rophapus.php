<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
	include "includes/config.php" ;
	if(isset($_GET['hapusrop']))
	{
		$koderop = $_GET["hapusrop"] ;
		mysqli_query($connection,"DELETE FROM rop WHERE ROPID = '$koderop'") ;

		echo "<script>alert('Data Berhasil Dihapus');
		document.location='rop.php'</script>" ;
	}
?>