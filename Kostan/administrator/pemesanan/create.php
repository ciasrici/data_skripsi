<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";

$query_kamar = mysqli_query(connect(), "SELECT * FROM kamar ORDER BY nama_kamar ASC");
$query_user = mysqli_query(connect(), "SELECT * FROM user ORDER BY nama ASC");

?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Tambah pemesanan</div>
			<div class='card-body'>
				<form action='function.php' method='post'>
					<div class='form-group'>
						<label for="user_id">Pelanggan</label>
						<select name='user_id' class='form-control'>
							<?php if (mysqli_num_rows($query_user) > 0) : ?>
								<option value="0" selected disabled>- Pilih Pelanggan -</option>
								<?php while ($row = mysqli_fetch_assoc($query_user)) :
									$cek_user = mysqli_query(connect(), "SELECT * FROM user_kamar WHERE user_id = '$row[id_user]'");
								?>
									<?php if (mysqli_num_rows($cek_user) == 0) : ?>
										<option value="<?= $row['id_user']; ?>"><?= $row['nama']; ?></option>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php else : ?>
								<option value="0">Tidak ada kamar</option>
							<?php endif; ?>
						</select>
					</div>
					<div class='form-group'>
						<label for="kamar_id">Kamar</label>
						<select name='kamar_id' class='form-control'>
							<?php if (mysqli_num_rows($query_kamar) > 0) : ?>
								<option value="0" selected disabled>- Pilih Kamar -</option>
								<?php while ($row = mysqli_fetch_assoc($query_kamar)) :
									$cek_kamar = mysqli_query(connect(), "SELECT * FROM user_kamar WHERE kamar_id = '$row[id_kamar]'");
								?>
									<?php if (mysqli_num_rows($cek_kamar) == 0) : ?>
										<option value="<?= $row['id_kamar']; ?>"><?= $row['nama_kamar']; ?></option>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php else : ?>
								<option value="0">Tidak ada kamar</option>
							<?php endif; ?>
						</select>
					</div>
					<div class='form-group'>
						<label for="tanggal_pesan">Tanggal Pesan</label>
						<input type='date' name='tanggal_pesan' class='form-control'>
					</div>
					<div class='form-group'>
						<label for="tanggal_transaksi">Tanggal Transaksi</label>
						<input type='date' name='tanggal_transaksi' class='form-control'>
					</div>
					<div class="form-group">
						<label for="status"> Status</label>
						<select class="form-control" id="status" name='status'>
							<option value="" selected disabled>- Pilih status pemesanan -</option>
							<option value="2">Pemesanan Berhasil</option>
						</select>
					</div>
			</div>
			<div class='card-footer'>
				<button type='submit' name='insert' class='btn btn-primary btn-sm'>Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require "../templates/footer.html"; ?>