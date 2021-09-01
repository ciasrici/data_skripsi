<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
$id_kamar = $_POST['id_kamar'];
$datas = GetById($id_kamar);
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Edit kamar</div>
			<div class='card-body'>
				<form action='function.php' method='post' enctype="multipart/form-data">
					<input type='hidden' name='id_kamar' value="<?php echo $_POST['id_kamar']; ?>">
					<?php
					foreach ($datas as $data) { ?>

						<div class="form-group">
							<label for="nama_kamar"> Nama Kamar</label>
							<input type="text" class="form-control" id="nama_kamar" name='nama_kamar' value="<?php echo $data['nama_kamar']; ?>">
						</div>

						<div class="form-group">
							<label for="fasilitas">Fasilitas</label>
							<input type="text" class="form-control" id="fasilitas" name='fasilitas' value="<?php echo $data['fasilitas']; ?>">
						</div>

						<div class="form-group">
							<label for="harga_perbulan"> Harga perbulan</label>
							<input type="text" class="form-control" id="harga_perbulan" name='harga_perbulan' value="<?php echo $data['harga_perbulan']; ?>">
						</div>

						<div class="form-group">
							<label for="gambar">Gambar</label>
							<input type="file" name="gambar" class="form-control">
							<input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">
							<?php if($data['gambar']) : ?>
								<img src="../assets/images/kamar/<?= $data['gambar']; ?>" class="img-thumbnail" width="250px">
							<?php endif; ?>
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