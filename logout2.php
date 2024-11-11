<?php
session_start();

// Hapus semua sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan ke halaman login
header("Location: login.php");
exit;

?>
