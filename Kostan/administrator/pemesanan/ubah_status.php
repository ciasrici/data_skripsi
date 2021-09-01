<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
$id_pemesanan = $_POST['id_pemesanan'];
$datas = GetById($id_pemesanan);
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class='card'>
            <div class='card-header'>Detail pemesanan kamar</div>
            <div class='card-body'>
                <form action='function.php' method='post'>
                    <input type='hidden' name='id_pemesanan' value="<?php echo $_POST['id_pemesanan']; ?>">
                    <?php
                    foreach ($datas as $data) { ?>

                        <div class="form-group">
                            <label for="user"> Nama:</label>
                            <input type="text" class="form-control" id="user" name='user' value="<?php echo $data['nama']; ?>" readonly>
                        </div>

                        <input type="hidden" name="user_id" value="<?= $data['user_id']; ?>">
                        <input type="hidden" name="kamar_id" value="<?= $data['kamar_id']; ?>">
                        <input type="hidden" name="harga_perbulan" value="<?= $data['harga_perbulan']; ?>">

                        <div class="form-group">
                            <label for="kamar"> Kamar:</label>
                            <input type="text" class="form-control" id="kamar" name='kamar' value="<?php echo $data['nama_kamar']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_pesan"> tanggal_pesan:</label>
                            <input type="text" class="form-control" id="tanggal_pesan" name='tanggal_pesan' value="<?php echo $data['tanggal_pesan']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="status"> status:</label>
                            <select class="form-control" id="status" name='status'>
                                <option value="" selected disabled>- Pilih status pemesanan -</option>
                                <option value="0">Menunggu Pembayaran</option>
                                <option value="1">Sedang divalidasi</option>
                                <option value="2">Pemesanan Berhasil</option>
                                <option value="3">Pemesanan Gagal / Berhenti langganan</option>
                            </select>
                        </div>

                    <?php } ?>
            </div>
            <div class='card-footer'>
                <button type='submit' name='update' class='btn btn-primary btn-sm'>Update</button>
                </form>
            </div>
        </div>
    </div>

    <?php require "../templates/footer.html"; ?>