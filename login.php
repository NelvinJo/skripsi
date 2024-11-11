<!DOCTYPE html>
<html lang="en">
<head>
<?php
include "includes/config.php";
ob_start();
session_start();

if (isset($_POST["submitlogin"])) {
    // Sanitize email and hash the password
    $emailuser = mysqli_real_escape_string($connection, $_POST["useremail"]);
    $passuser = md5($_POST["pass"]);

    // Query to check if email and password match
    $sql_login = mysqli_query($connection, "SELECT * FROM admin WHERE Email = '$emailuser' AND Password = '$passuser'");

    if (mysqli_num_rows($sql_login) > 0) {
        $row_admin = mysqli_fetch_array($sql_login);

        // Set session variables based on email and role
        $_SESSION['Email'] = $emailuser;
        $_SESSION['Role'] = $row_admin['Role'];

        // Redirect to the main menu (menuutama.php) or dashboard
        header("Location: menuutama.php");
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Toko Arloji Pasar Baru</title>
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                        <h1 class="h2">Welcome back!</h1>
                        <p class="lead">Sign in to your account to continue</p>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <?php
                                // Display error message if login failed
                                if (isset($error_message)) {
                                    echo "<p style='color:red;'>$error_message</p>";
                                }
                                ?>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg" type="email" name="useremail" placeholder="Enter your email" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="pass" placeholder="Enter your password" required />
                                    </div>
                                    <div class="form-check align-items-center">
                                        <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
                                        <label class="form-check-label text-small" for="customControlInline">Remember me</label>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" name="submitlogin" class="btn btn-lg btn-primary">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/app.js"></script>
</body>
</html>