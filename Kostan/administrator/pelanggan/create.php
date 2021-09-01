<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Tambah Pelanggan</div>
			<div class='card-body'>
				<form action='function.php' method='post'>
					<div class='form-group'>

						<label for="nama">Nama</label>
						<input type='text' name='nama' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="username">Username</label>
						<input type='text' name='username' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="password">Password</label>
						<input type='text' name='password' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="alamat">Alamat</label>
						<input type='text' name='alamat' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="status">Status</label>
						<input type='text' name='status' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="hp">Hp</label>
						<input type='text' name='hp' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="email">Email</label>
						<input type='text' name='email' class='form-control'>
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