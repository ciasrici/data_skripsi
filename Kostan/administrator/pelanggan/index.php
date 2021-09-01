<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
?>
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="page-header">
					<h2 class="pageheader-title">Pelanggan</h2>
				</div>
			</div>
		</div>
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
		<div class='card'>
			<div class='card-header'>
				<div class='row'>
					<div class='col-8'><a href='create.php' class='btn btn-primary btn-sm'>Tambah</a></div>
					<div class='col-4' align='right'>
						<form action='' method='get'>
							<input type='text' name='search' class='form-control' placeholder='Search...'>
						</form>
					</div>
				</div>
			</div>
			<div class='card-body'>
				<div class='table-responsive'>
					<table class='table table-bordered'>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Status</th>
							<th>Hp</th>
							<th>Kamar</th>
							<th class='text-center'>Aksi</th>
						</tr>

						<?php
						if (isset($_GET['search'])) {
							$data = GetBySearch($_GET['search']);
						} else {
							$data = getAll();
						}
						$no = ($_GET['page'] > 1) ? ($_GET['page'] * 10) - 9 : 1;
						?>

						<?php if ($data) : ?>

							<tbody class='fbody'>
								<?php foreach ($data as $td) : ?>
									<?php
									$query_user_kamar = mysqli_query(connect(), "SELECT kamar.nama_kamar FROM user_kamar JOIN kamar ON user_kamar.kamar_id = kamar.id_kamar WHERE user_id = '$td[id_user]'");
									$kamar = "";
									if ($query_user_kamar) {
										$row_user_kamar = mysqli_fetch_assoc($query_user_kamar);
										$kamar = $row_user_kamar['nama_kamar'];
									}
									?>
									<tr>
										<td><?= $no; ?></td>
										<td><?= $td['nama']; ?></td>
										<td><?= $td['status']; ?></td>
										<td><?= $td['hp']; ?></td>
										<td><?= $kamar; ?></td>

										<td class='text-center'>
											<?php if (isset($kamar)) : ?>
												<a href="detail.php?user_id=<?= $td['id_user']; ?>" class="btn btn-success btn-sm">Detail</a>
											<?php endif; ?>
											<form method='POST' action='edit.php' class='d-inline'>
												<input type='hidden' name='id_user' value='<?= $td['id_user']; ?>'>
												<input type='submit' name='edit' Value='Edit' class='btn btn-warning btn-sm text-white'>
											</form>

											<form method='POST' action='function.php' class='d-inline' onclick="return confirm('Are you sure?')">
												<input type='hidden' name='id_user' value='<?= $td['id_user']; ?>'>
												<input type='submit' name='delete' Value='Delete' class='btn btn-danger btn-sm'>
											</form>
										</td>

									</tr>
								<?php $no++;
								endforeach; ?>
							</tbody>
						<?php else : ?>
							<td colspan='10' class='text-center'>Tidak ada data</td>
						<?php endif; ?>
					</table>
				</div>
			</div>
			<div class='card-footer'>
				<nav aria-label='Page navigation example'>
					<ul class='pagination'>
						<?php for ($i = 1; $i <= pagination()['total_page']; $i++) : ?>
							<?php if ($i == pagination()['page']) : ?>
								<li class='page-item active'><a class='page-link' href='?page=<?= $i; ?>'><?= $i; ?></a></li>
							<?php else : ?>
								<li class='page-item'><a class='page-link' href='?page=<?= $i; ?>'><?= $i; ?></a></li>
							<?php endif; ?>
						<?php endfor; ?>
					</ul>
				</nav>
			</div>
		</div>
	</div>

	<!-- ============================================================== -->
	<!-- end wrapper  -->
	<!-- ============================================================== -->
	<?php require "../templates/footer.html"; ?>