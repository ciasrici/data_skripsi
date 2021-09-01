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
			<div class='card-header'>Create kamar</div>
			<div class='card-body'>
				<form action='function.php' method='post' enctype="multipart/form-data">
					<div class='form-group'>

						<label for="nama_kamar">Nama Kamar</label>
						<input type='text' name='nama_kamar' class='form-control'>
					</div>
					<div class='form-group'>

						<label for="fasilitas">Fasilitas <small>(pisahkan dengan koma per fasilitas)</small></label>
						<input type='text' name='fasilitas' class='form-control' placeholder="contoh: Tempat tidur, Kamar mandi, ...">
					</div>
					<div class='form-group'>

						<label for="harga_perbulan">Harga perbulan</label>
						<input type='text' name='harga_perbulan' class='form-control'>
					</div>
					<div class="form-group">
						<label for="gambar">Gambar</label>
						<input type="file" name="gambar" class="form-control">
					</div>

			</div>
			<div class='card-footer'>
				<button type='submit' name='insert' class='btn btn-primary btn-sm'>Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require "../templates/footer.html"; ?>