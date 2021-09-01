<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
$query_kamar = mysqli_query(connect(), "SELECT * FROM kamar ORDER BY nama_kamar ASC");
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Tambah Gambar Kamar</div>
			<div class='card-body'>
				<form action='function.php' method='post' enctype="multipart/form-data">
					<div class='form-group'>
						<label for="kamar_id">kamar</label>
						<select name='kamar_id' class='form-control'>
							<?php if (mysqli_num_rows($query_kamar) > 0) : ?>
								<option value="0" selected disabled>- Pilih Kamar -</option>
								<?php while ($row = mysqli_fetch_assoc($query_kamar)) : ?>
									<option value="<?= $row['id_kamar']; ?>"><?= $row['nama_kamar']; ?></option>
								<?php endwhile; ?>
							<?php else : ?>
								<option value="0">Tidak ada kamar</option>
							<?php endif; ?>
						</select>
					</div>
					<div class='form-group'>
						<label for="url">url</label>
						<input type='file' name='url' class='form-control'>
					</div>

			</div>
			<div class='card-footer'>
				<button type='submit' name='insert' class='btn btn-primary btn-sm'>Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php require "../templates/footer.html"; ?>