<?php
require 'templates/header.php';
require 'config/get_connection.php';
$id_kamar = $_GET['kamar'];
$id_user = $_SESSION['user']['id_user'];
$kamar = mysqli_query(connect(), "SELECT * FROM kamar WHERE id_kamar = '$id_kamar'");
$row = mysqli_fetch_assoc($kamar);

$cek_kamar = mysqli_query(connect(), "SELECT * FROM user_kamar WHERE kamar_id = '$id_kamar'");
$cek_user = mysqli_query(connect(), "SELECT * FROM user_kamar WHERE user_id = '$id_user'");
?>

<!-- Page Content -->


<div class="container">
    <br>
    <h3><?= $row['nama_kamar']; ?></h3>
    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <?php if($row['gambar']) : ?>
                        <img class="img-thumbnail" src="administrator/assets/images/kamar/<?= $row['gambar']; ?>" alt="">
                    <?php else : ?>
                        <img class="img-thumbnail" src="administrator/assets/images/kamar/default.png" alt="">
                    <?php endif; ?>
                    <br><br>
                    <h5 class="text-center"><span>Rp. <?= number_format($row['harga_perbulan']); ?>/bulan</span></h5><br>
                    <?php if (mysqli_num_rows($cek_kamar) == 0) : ?>
                        <p class="text-center"><span class="badge badge-success">Tersedia</span></p>
                    <?php else : ?>
                        <p class="text-center"><span class="badge badge-danger">Tidak tersedia</span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5>Fasilitas :</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php $fasilitas = explode(',', $row['fasilitas']); ?>
                        <?php foreach ($fasilitas as $fas) : ?>
                            <li class="list-group-item"><?= $fas; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if (mysqli_num_rows($cek_kamar) == 0 && mysqli_num_rows($cek_user) == 0) : ?>
                    <div class="card-footer">
                        <a onclick="return confirm('Apa anda yakin ingin memesan kamar ini?')" href="proses_booking.php?kamar_id=<?= $_GET['kamar']; ?>" class="btn btn-primary btn-sm <?= ($row['status'] == 1) ? 'disabled' : ''; ?>">Pesan Sekarang</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->
<?php require 'templates/footer.html'; ?>