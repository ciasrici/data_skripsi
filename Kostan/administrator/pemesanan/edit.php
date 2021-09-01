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
			<div class='card-header'>Create pemesanan</div>
			<div class='card-body'>
				<form action='function.php' method='post'>
					<input type='hidden' name='id_pemesanan' value="<?php echo $_POST['id_pemesanan']; ?>">
					<?php
					foreach ($datas as $data) { ?>

						<div class="form-group">
							<label for="user_id">Pelanggan</label>
							<input type="text" class="form-control" id="user_id" name='user_id' value="<?php echo $data['user_id']; ?>">
						</div>

						<div class="form-group">
							<label for="kamar_id">Kamar</label>
							<input type="text" class="form-control" id="kamar_id" name='kamar_id' value="<?php echo $data['kamar_id']; ?>">
						</div>

						<div class="form-group">
							<label for="tanggal_pesan">Tanggal pesan</label>
							<input type="text" class="form-control" id="tanggal_pesan" name='tanggal_pesan' value="<?php echo $data['tanggal_pesan']; ?>">
						</div>

						<div class="form-group">
							<label for="tanggal_transaksi">Tanggal transaksi</label>
							<input type="text" class="form-control" id="tanggal_transaksi" name='tanggal_transaksi' value="<?php echo $data['tanggal_transaksi']; ?>">
						</div>

						<div class="form-group">
							<label for="status">Status</label>
							<input type="text" class="form-control" id="status" name='status' value="<?php echo $data['status']; ?>">
						</div>

					<?php } ?>
			</div>
			<div class='card-footer'>
				<button type='submit' name='update' class='btn btn-primary btn-sm'>Update</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require "../templates/footer.html"; ?>