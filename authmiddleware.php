<?php
session_start();

function checkLogin() {
    // Cek apakah ada session 'Email' untuk memeriksa login
    if (!isset($_SESSION['Email'])) {
        // Jika tidak ada, arahkan pengguna ke halaman login
        header("Location: login.php");
        exit();
    }
    // Jika sudah login, lanjutkan akses ke halaman berikutnya
}
?>