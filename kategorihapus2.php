<?php
	include"includes/config.php" ;
	if(isset($_GET['hapussub']))
	{
		$kodesub = $_GET["hapussub"] ;
		mysqli_query($connection,"delete from subkategori where SubID = '$kodesub'") ;

		echo "<script>alert('Data Berhasil Dihapus');
		document.location='kategori2.php'</script>" ;
	}
?>