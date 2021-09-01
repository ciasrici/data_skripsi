<?php
require 'templates/header.php';
require 'config/get_connection.php';

$id_user = $_SESSION['user']['id_user'];
$user = mysqli_query(connect(), "SELECT * FROM user WHERE id_user = '$id_user'");
$row = mysqli_fetch_assoc($user);
$user_kamar = mysqli_query(connect(), "SELECT kamar.nama_kamar, kamar.harga_perbulan, user_kamar.tanggal_masuk FROM user_kamar JOIN kamar ON user_kamar.kamar_id = kamar.id_kamar WHERE user_id = '$id_user'");
$row_user_kamar = mysqli_fetch_assoc($user_kamar);
$pembayaran = mysqli_query(connect(), "SELECT * FROM pembayaran WHERE user_id = '$id_user' ORDER BY tanggal DESC");

?>

<!-- Page Content -->
<div class="container">
  <!-- Page Features -->
  <div class="row my-4">

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          Profile
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th>Nama</th>
              <td><?= $row['nama']; ?></td>
            </tr>
            <tr>
              <th>Username</th>
              <td><?= $row['username']; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?= $row['email']; ?></td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td><?= $row['alamat']; ?></td>
            </tr>
            <tr>
              <th>No. Hp</th>
              <td><?= $row['hp']; ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">Status</div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th>Kamar</th>
              <td><?= $row_user_kamar['nama_kamar']; ?></td>
            </tr>
            <tr>
              <th>Biaya Perbulan</th>
              <td>Rp <?= number_format($row_user_kamar['harga_perbulan']); ?></td>
            </tr>
            <tr>
              <th>Tanggal Masuk</th>
              <td><?= $row_user_kamar['tanggal_masuk']; ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-lg-12">
      <div id="printPembayaran">
        <div class="card">
          <div class="card-header">
            Riwayat Pembayaran
            <div align="right" class="float-right">
              <a href="https://api.whatsapp.com/send?phone=+6282121453747&text=Anda melakukan Pembayaran baru, Silahkan Upload bukti Pembayaran dan isi Informasi dibawah%0A%0APembayaran Bulan: %0AAtas Nama : %0AJumlah yang ditrasnfer: %0ATanggal Transfer: %0A
              " class="btn btn-primary btn-sm text-center" target="_blank">Lakukkan Pembayaran</a>
              <button onclick="printDiv('printPembayaran')" id="btnPrint" class="btn btn-success btn-sm">Cetak</button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Status</th>
              </tr>
              <?php while ($row_pembayaran = mysqli_fetch_assoc($pembayaran)) : ?>
                <tr>
                  <td><?= date('d F Y H:i:s', strtotime($row_pembayaran['tanggal'])); ?></td>
                  <td>Rp <?= number_format($row_pembayaran['nominal']); ?></td>
                  <td><?= ($row_pembayaran['status'] == 1) ? 'Lunas' : 'Belum Lunas'; ?></td>
                </tr>
              <?php endwhile; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

</div>
<!-- /.container -->


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