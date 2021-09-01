<?php
require 'templates/header.php';
require 'config/get_connection.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['failed'] = 'Anda harus login dulu!';
    header('Location: login.php');
}

$status = [
    0 => 'Menunggu Pembayaran',
    1 => 'Pembayaran sedang divalidasi',
    2 => 'Pemesanan berhasil',
    3 => 'Pemesanan gagal',
];

$id_user = $_SESSION['user']['id_user'];
$query = mysqli_query(connect(), "SELECT pemesanan.*, kamar.nama_kamar FROM pemesanan JOIN kamar ON pemesanan.kamar_id = kamar.id_kamar WHERE user_id = '$id_user'");

?>
<div class="container mt-4 mb-5">
    <div class="row mt-5">
        <div class="col-lg-12">
            <?php if (isset($_SESSION['success'])) : ?>
                <div class='alert alert-success'>
                    <?= $_SESSION['success']; ?>
                </div>
            <?php unset($_SESSION['success']);
            endif; ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>No. Booking</th>
                                <th>Kamar</th>
                                <th>Tanggal Pesan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <?php if (mysqli_num_rows($query) == 0) : ?>
                                <td class="text-center" colspan="6">Tidak ada data</td>
                            <?php endif; ?>

                            <?php $no = 1;
                            while ($row = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $row['id_pemesanan']; ?></td>
                                    <td><?= $row['nama_kamar']; ?></td>
                                    <td><?= $row['tanggal_pesan']; ?></td>
                                    <td><?= $status[$row['status']]; ?></td>
                                    <td>
                                        <a href="detail_pemesanan.php?id_pemesanan=<?= $row['id_pemesanan']; ?>" class="btn btn-success btn-sm">Detail pemesanan</a>
                                    </td>
                                </tr>
                            <?php $no++;
                            endwhile; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'templates/footer.html'; ?>