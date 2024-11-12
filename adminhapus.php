<?php
session_start();
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'owner') {
    header("Location: menuutama.php"); // Redirect staff to main menu
    exit();
}
?>

<?php
	include"includes/config.php" ;
	if(isset($_GET['hapusadmin']))
	{
		$kodeadmin = $_GET["hapusadmin"] ;
		mysqli_query($connection,"delete from admin where AdminID = '$kodeadmin'") ;

		echo "<script>alert('Data Berhasil Dihapus');
		document.location='admin.php'</script>" ;
	}


?>