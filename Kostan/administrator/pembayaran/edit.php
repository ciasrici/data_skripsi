<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
$id_pembayaran = $_POST['id_pembayaran'];
$datas = GetById($id_pembayaran);
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Edit pembayaran</div>
			<div class='card-body'>
				<form action='function.php' method='post'>
					<input type='hidden' name='id_pembayaran' value="<?php echo $_POST['id_pembayaran']; ?>">
					<?php
					foreach ($datas as $data) { ?>

						<div class="form-group">
							<label for="user_id"> user_id:</label>
							<input type="text" class="form-control" id="user_id" name='user_id' value="<?php echo $data['user_id']; ?>">
						</div>

						<div class="form-group">
							<label for="kamar_id"> kamar_id:</label>
							<input type="text" class="form-control" id="kamar_id" name='kamar_id' value="<?php echo $data['kamar_id']; ?>">
						</div>

						<div class="form-group">
							<label for="tanggal"> tanggal:</label>
							<input type="date" class="form-control" id="tanggal" name='tanggal' value="<?php echo date('Y-m-d', strtotime($data['tanggal'])); ?>">
						</div>

						<div class="form-group">
							<label for="nominal"> nominal:</label>
							<input type="text" class="form-control" id="nominal" name='nominal' value="<?php echo $data['nominal']; ?>">
						</div>

						<div class="form-group">
							<label for="status"> status:</label>
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