<?php
session_start();
if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'owner') {
    header("Location: menuutama.php");
    exit();
}

include "includes/config.php";

if (isset($_POST['Edit'])) {
    $adminkode = $_GET['ubahadmin'];

    $depanadmin = $_POST['inputdepan'];
    $belakangadmin = $_POST['inputbelakang'];
    $hp = $_POST['inputhp'];
    $email = $_POST['inputemail'];
    $password = $_POST['inputpassword'];
    $role = $_POST['inputrole'];

    if (empty($depanadmin) || empty($belakangadmin) || empty($hp) || empty($email) || empty($role)) {
        echo '<h1>Anda harus mengisi semua data</h1>';
        die();
    }

    if (!empty($password)) {
        $hashed_password = md5($password);
        $password_query = ", Password='$hashed_password'";
    } else {
        $password_query = "";
    }

    $query = "UPDATE admin SET NamaDepan='$depanadmin', NamaBelakang='$belakangadmin', NoHP='$hp', Email='$email', Role='$role' $password_query WHERE AdminID = '$adminkode'";
    mysqli_query($connection, $query);

    header("Location: admin.php");
}

$kodeadmin = $_GET["ubahadmin"];
$editadmin = mysqli_query($connection, "SELECT * FROM admin WHERE AdminID = '$kodeadmin'");
$rowedit = mysqli_fetch_array($editadmin);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Edit Admin</title>
</head>
<body>
<?php include "header.php"; ?>

<main class="content">
<div class="container-fluid p-0">
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="jumbotron jumbotron-fluid"></div>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h1 class="h3 mb-3">Edit Admin</h1>
                </div>

                <form method="POST">
                    <div class="form-group row">
                        <label for="depanadmin" class="col-sm-2 col-form-label">Nama Depan Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputdepan" id="depanadmin" placeholder="Nama Depan Admin" value="<?php echo htmlspecialchars($rowedit["NamaDepan"]); ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="belakangadmin" class="col-sm-2 col-form-label">Nama Belakang Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputbelakang" id="belakangadmin" placeholder="Nama Belakang Admin" value="<?php echo htmlspecialchars($rowedit["NamaBelakang"]); ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="hp" class="col-sm-2 col-form-label">Nomor HP Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputhp" id="hp" placeholder="Nomor Handphone Admin" value="<?php echo htmlspecialchars($rowedit["NoHP"]); ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputemail" id="email" placeholder="Email Admin" value="<?php echo htmlspecialchars($rowedit["Email"]); ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password Admin</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="inputpassword" id="password" placeholder="Enter new password (leave blank to keep current)">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="inputrole" id="role" placeholder="Role Admin" value="<?php echo htmlspecialchars($rowedit["Role"]); ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" style="background-color: #222e3c" class="btn btn-primary" value="Edit" name="Edit">
                            <a href="admin.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-1"></div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<script src="js/app.js"></script>
</main>
</body>
</html>
