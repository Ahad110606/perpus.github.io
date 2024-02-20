<?php
require_once("koneksi.php");

if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
    $password = strip_tags($_POST["password"]);

    $sql = "SELECT * FROM user WHERE Username=:Username OR Email=:Email";
    $stmt = $db->prepare($sql);

    $params = array(
        "Username" => $username,
        "Email" => $username
    );

    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $hashedPassword = $user["Password"];
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION["user"] = $user;

            if ($user['level'] == 'administrator') {
                header("location:admin_home.php");
            } elseif ($user['level'] == 'petugas') {
                header("location:petugas_home.php");
            } elseif ($user['level'] == 'peminjam') {
                header("location:peminjam_home.php");
            }

            exit();
        } else {
            $error_message = "Password salah. Silakan coba lagi.";
        }
    } else {
        $error_message = "Email atau username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-primary navbar-center">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Perpustakaan</a>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center">L O G I N</h1>
                        <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="inputUsernameEmail" class="form-label">Email address or Username</label>
                                <input type="text" class="form-control" id="inputUsernameEmail" name="Username"
                                    placeholder="Enter email or username" aria-describedby="emailHelp" />
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    id="inputPassword" />
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="register.php" class="link-primary">Don't have an account? Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->

    
</body>

</html>
