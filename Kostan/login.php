<?php
require 'templates/header.php';
require 'config/get_connection.php';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(connect(), "SELECT id_user, username, `password` FROM user WHERE username = '$username'");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row;
            header('Location: index.php');
        } else {
            $_SESSION['failed'] = 'Password salah';
        }
    } else {
        $_SESSION['failed'] = 'User tidak ditemukan';
    }
}
?>

<!-- Page Content -->
<div class="container">
    <br>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-lg-8">

            <?php if (isset($_SESSION['success'])) : ?>
                <div class='alert alert-success'>
                    <?= $_SESSION['success']; ?>
                </div>
            <?php unset($_SESSION['success']);
            endif; ?>

            <?php if (isset($_SESSION['failed'])) : ?>
                <div class='alert alert-danger'>
                    <?= $_SESSION['failed']; ?>
                </div>
            <?php unset($_SESSION['failed']);
            endif; ?>

            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-sm">Login</button>
                        <span class="float-right">Belum punya akun? <a href="daftar.php">Daftar disini</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container -->
<br><br><br><br>
<?php require 'templates/footer.html'; ?>