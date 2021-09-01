<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";

$namaBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");

$user_id = $_GET['user_id'];
$user = mysqli_query(connect(), "SELECT * FROM user WHERE id_user = '$user_id'");
$row_user = mysqli_fetch_assoc($user);

$query_pembayaran = mysqli_query(connect(), "SELECT * FROM pembayaran WHERE user_id = '$user_id' ORDER BY tanggal ASC");
$query_user_kamar = mysqli_query(connect(), "SELECT kamar.nama_kamar, kamar.harga_perbulan, user_kamar.tanggal_masuk FROM user_kamar JOIN kamar ON user_kamar.kamar_id = kamar.id_kamar WHERE user_id = '$user_id'");
$row_user_kamar = mysqli_fetch_assoc($query_user_kamar);

$tanggal = [];
while ($row = mysqli_fetch_assoc($query_pembayaran)) {
	$tanggal[] = $row;
}

$tanggal_masuk = date('Y-m', strtotime($row_user_kamar['tanggal_masuk']));
$begin = new DateTime($tanggal_masuk);
$tanggal_sekarang = date('Y-m');
$end = new DateTime($tanggal_sekarang);

$j = 0;
for ($i = $begin; $i <= $end; $i->modify('+1 month')) {
	if ($i->format('Y-m') == date('Y-m', strtotime($tanggal[$j]['tanggal']))) {
		$data[] = [
			'tanggal' => date('m', strtotime($tanggal[$j]['tanggal'])),
			'nominal' => $tanggal[$j]['nominal'],
			'status' => 'Lunas'
		];
	} else {
		$data[] = [
			'tanggal' => $i->format('m'),
			'nominal' => 0,
			'status' => 'Tunggakan'
		];
	}
	$j++;
}
?>
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
	<div class="container-fluid  dashboard-content">
		<?php if (isset($_SESSION['success'])) : ?>
			<div class='alert alert-success'>
				<?= $_SESSION['success']; ?>
			</div>
		<?php unset($_SESSION['success']);
		endif; ?>

		<?php if (isset($_SESSION['failed'])) : ?>
			<div class='alert alert-danger'>
				<?= $_SESSION['failed']; ?>
			</div>
		<?php unset($_SESSION['failed']);
		endif; ?>

		<div class="row my-4">

			<div class="col-lg-7">
				<div class="card">
					<div class="card-header">
						Profile
					</div>
					<div class="card-body">
						<table class="table table-bordered">
							<tr>
								<th>Nama</th>
								<td><?= $row_user['nama']; ?></td>
							</tr>
							<tr>
								<th>Username</th>
								<td><?= $row_user['username']; ?></td>
							</tr>
							<tr>
								<th>Email</th>
								<td><?= $row_user['email']; ?></td>
							</tr>
							<tr>
								<th>Alamat</th>
								<td><?= $row_user['alamat']; ?></td>
							</tr>
							<tr>
								<th>No. Hp</th>
								<td><?= $row_user['hp']; ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="col-lg-5">
				<div class="card">
					<div class="card-header">Status</div>
					<div class="card-body">
						<table class="table table-bordered">
							<tr>
								<th>Kamar</th>
								<td><?= $row_user_kamar['nama_kamar']; ?></td>
							</tr>
							<tr>
								<th>Biaya Perbulan</th>
								<td>Rp <?= number_format($row_user_kamar['harga_perbulan']); ?></td>
							</tr>
							<tr>
								<th>Tanggal Masuk</th>
								<td><?= date('d F Y H:i:s', strtotime($row_user_kamar['tanggal_masuk'])); ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">Detail Pembayaran <?= date('Y'); ?></div>
					<div class="card-body">
						<table class="table table-bordered table-sm">
							<tr>
								<th>Bulan</th>
								<th>Nominal</th>
								<th>Status</th>
							</tr>
							<?php foreach ($data as $pembayaran) : ?>
								<tr>
									<td><?= $namaBulan[$pembayaran['tanggal']]; ?></td>
									<td>Rp <?= number_format($pembayaran['nominal'], 0, '.', '.'); ?></td>
									<td><?= $pembayaran['status']; ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ============================================================== -->
	<!-- end wrapper  -->
	<!-- ============================================================== -->
	<?php require "../templates/footer.html"; ?>