<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
$id_user = $_POST['id_user'];
$datas = GetById($id_user);
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Edit Pelanggan</div>
			<div class='card-body'>
				<form action='function.php' method='post'>
					<input type='hidden' name='id_user' value="<?php echo $_POST['id_user']; ?>">
					<?php
					foreach ($datas as $data) { ?>

						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="text" class="form-control" id="nama" name='nama' value="<?php echo $data['nama']; ?>">
						</div>

						<div class="form-group">
							<label for="username">Username:</label>
							<input type="text" class="form-control" id="username" name='username' value="<?php echo $data['username']; ?>">
						</div>

						<div class="form-group">
							<label for="alamat">Alamat</label>
							<input type="text" class="form-control" id="alamat" name='alamat' value="<?php echo $data['alamat']; ?>">
						</div>

						<div class="form-group">
							<label for="status">Status</label>
							<input type="text" class="form-control" id="status" name='status' value="<?php echo $data['status']; ?>">
						</div>

						<div class="form-group">
							<label for="hp">Hp</label>
							<input type="text" class="form-control" id="hp" name='hp' value="<?php echo $data['hp']; ?>">
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" id="email" name='email' value="<?php echo $data['email']; ?>">
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