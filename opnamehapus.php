<?php
session_start();

if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include "includes/config.php";

if (isset($_GET['hapusopname'])) {
    $kodeopname = $_GET["hapusopname"];
    
    $queryGetOpnameID = mysqli_query($connection, "SELECT OpnameID FROM detailstockopname WHERE DetailOpnameID = '$kodeopname'");
    $hasil = mysqli_fetch_assoc($queryGetOpnameID);
    $opnameID = $hasil['OpnameID'];
    
    mysqli_query($connection, "DELETE FROM detailstockopname WHERE DetailOpnameID = '$kodeopname'");

    $cekOpname = mysqli_query($connection, "SELECT * FROM detailstockopname WHERE OpnameID = '$opnameID'");

    if (mysqli_num_rows($cekOpname) == 0) {
        mysqli_query($connection, "DELETE FROM stockopname WHERE OpnameID = '$opnameID'");
    }

    echo "<script>alert('Data Opname Berhasil Dihapus'); document.location='opname.php'</script>";
}
?>