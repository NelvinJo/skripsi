<?php
	session_start();
	$_SESSION['emailuser'];
	unset($_SESSION['emailuser']);

	session_unset();
	session_destroy();
	header("location:login.php");

?>