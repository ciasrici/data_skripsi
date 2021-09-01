<?php
require 'templates/header.php';
require 'config/get_connection.php';
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
                <div class="card-header">Daftar</div>
                <div class="card-body">
                    <form action="administrator/pelanggan/function.php" method="post">
                        <input type="hidden" name="daftar" value="daftar">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="hp">No. HP</label>
                            <textarea class="form-control" name="hp" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" name="status" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <button type="submit" name="insert" class="btn btn-primary btn-sm">Daftar</button>
                        <span class="float-right">Sudah punya akun? <a href="login.php">Login disini</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container -->
<br><br><br><br>
<?php require 'templates/footer.html'; ?>