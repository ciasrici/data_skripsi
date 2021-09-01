<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";

$users = getUsers();
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Tambah pembayaran</div>
			<div class='card-body'>
				<form action='function.php' method='post'>
					<div class='form-group'>

						<label for="user_id">user_id</label>
						<!-- <input type='text' name='user_id' class='form-control'> -->
						<select name="user_id" class="form-control" id="user_id">
							<option value="0" selected disabled>- Pilih Pelangan -</option>
							<?php foreach ($users as $user) : ?>
								<option value="<?= $user['id_user']; ?>"><?= $user['nama']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class='form-group'>

						<label for="kamar_id">Kamar</label>
						<input type='text' name='nama_kamar' id="nama_kamar" class='form-control' readonly>
						<input type='hidden' name='kamar_id' id="kamar_id" class='form-control'>
					</div>
					<div class='form-group'>

						<label for="tanggal">Tanggal</label>
						<input type='date' name='tanggal' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="nominal">Nominal</label>
						<input type='text' name='nominal' class='form-control'>
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
<script>
	$(document).ready(function() {
		$('#user_id').change(function() {
			let user_id = $('#user_id').val();
			$.ajax({
				url: 'function.php',
				method: 'post',
				dataType: 'json',
				data: {
					getUserIdFromAjax: user_id
				},
				success: function(response) {
					$('#nama_kamar').val($.trim(response.nama_kamar));
					$('#kamar_id').val($.trim(response.kamar_id));
				}
			});
		});
	});
</script>