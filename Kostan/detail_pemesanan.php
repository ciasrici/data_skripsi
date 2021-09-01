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

$id_pemesanan = $_GET['id_pemesanan'];
$query = mysqli_query(connect(), "SELECT pemesanan.*, kamar.nama_kamar, kamar.harga_perbulan, user.nama, user.alamat, user.hp FROM pemesanan JOIN kamar ON pemesanan.kamar_id = kamar.id_kamar JOIN user ON pemesanan.user_id = user.id_user WHERE id_pemesanan = '$id_pemesanan'");
$row = mysqli_fetch_assoc($query);
?>
<div class="container mt-4 mb-5">
    <div class="row mt-5">
        <div class="col-lg-7">
            <?php if (isset($_SESSION['success'])) : ?>
                <div class='alert alert-success'>
                    <?= $_SESSION['success']; ?>
                </div>
            <?php unset($_SESSION['success']);
            endif; ?>
            <div id="printThis">
                <div class="card">
                    <div class="card-header">Detail pemesanan kamar</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No. Booking</th>
                                    <td>#BOOK<?= $row['id_pemesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nama pemesan</th>
                                    <td><?= $row['nama']; ?></td>
                                </tr>
                                <tr>
                                    <th>Kamar</th>
                                    <td><?= $row['nama_kamar']; ?></td>
                                </tr>
                                <tr>
                                    <th>Biaya kamar perbulan</th>
                                    <td>Rp <?= number_format($row['harga_perbulan']); ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pesan</th>
                                    <td><?= $row['tanggal_pesan']; ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?= $status[$row['status']]; ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($row['status'] == 0) : ?>
                            <a href="https://api.whatsapp.com/send?phone=+6282121453747&text=Detail pemesanan %0ANo Booking: BOOK<?php echo $row['id_pemesanan']; ?>%0ANama pemesan: <?php echo $row['nama']; ?>%0ANomor HP: <?php echo $row['hp']; ?>%0AAlamat: <?php echo $row['alamat']; ?>%0AKamar: <?php echo $row['nama_kamar']; ?>%0AHarga Kamar perbulan: Rp <?php echo number_format($row['harga_perbulan']); ?>%0ATanggal Pesan: <?php echo $row['tanggal_pesan']; ?>%0A%0AUpload bukti Pembayaran dan isi Informasi dibawah%0A%0AKonfirmasi Pembayaran%0ANo Rekening: %0AAtas Nama : %0AJumlah yang ditrasnfer: %0ATanggal Transfer: %0A
			  			" class="btn btn-primary text-center" target="_blank">Konfirmasi Pembayaran</a>
                        <?php endif; ?>

                        <?php if ($row['status'] == 2) : ?>
                            <button onclick="printDiv('printThis')" id="btnPrint" class="btn btn-success btn-sm">Cetak</button>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <br>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Silahkan transfer dengan nominal Rp <?= number_format($row['harga_perbulan']); ?> ke salah satu rekening</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                        <tr>
                            <th colspan="2">Bank Mandiri</th>
                        </tr>
                        <tr>
                            <td>No Rekening</td>
                            <td>0000-0000-0000</td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td>
                            <td>Kosan ...</td>
                        </tr>
                        </tr>

                        <tr>
                        <tr>
                            <th colspan="2">Bank BRI</th>
                        </tr>
                        <tr>
                            <td>No Rekening</td>
                            <td>0000-0000-0000</td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td>
                            <td>Kosan ...</td>
                        </tr>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    Informasi lebih lanjut silahkan hubungi WhatsApp kami 087788778877
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'templates/footer.html'; ?>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        style.media = 'print';

        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);
        window.print();

        document.body.innerHTML = originalContents;
    }
</script>