
		<?php
		session_start();
		require_once '../config/get_connection.php';
		function getAll()
		{
			$exe = pagination()["exe"];
			while ($row = mysqli_fetch_assoc($exe)) {
				$data[] = [
					'id_pemesanan' => $row['id_pemesanan'],
					'nama' => $row['nama'],
					'nama_kamar' => $row['nama_kamar'],
					'tanggal_pesan' => $row['tanggal_pesan'],
					'tanggal_transaksi' => $row['tanggal_transaksi'],
					'status' => $row['status'],
				];
			}

			return $data;
		}
		function pagination()
		{
			$min_data = 10;
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start = ($page > 1) ? ($page * $min_data) - $min_data : 0;
			$result_page = mysqli_query(connect(), "SELECT pemesanan.*, user.nama, kamar.nama_kamar FROM pemesanan JOIN user ON pemesanan.user_id = user.id_user JOIN kamar ON pemesanan.kamar_id = kamar.id_kamar");
			$total = mysqli_num_rows($result_page);
			$total_page = ceil($total / $min_data);

			$query = "SELECT pemesanan.*, user.nama, kamar.nama_kamar FROM pemesanan JOIN user ON pemesanan.user_id = user.id_user JOIN kamar ON pemesanan.kamar_id = kamar.id_kamar ORDER BY id_pemesanan DESC LIMIT $start, $min_data";
			$exe = mysqli_query(connect(), $query);

			$output = [
				'exe' => $exe,
				'total_page' => $total_page,
				'page' => $page
			];
			return $output;
		}

		function GetById($id)
		{
			$query = "SELECT pemesanan.*, user.nama, kamar.nama_kamar, kamar.harga_perbulan FROM pemesanan JOIN user ON pemesanan.user_id = user.id_user JOIN kamar ON pemesanan.kamar_id = kamar.id_kamar WHERE `id_pemesanan` =  '$id'";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_pemesanan' => $data['id_pemesanan'],
					'user_id' => $data['user_id'],
					'kamar_id' => $data['kamar_id'],
					'nama' => $data['nama'],
					'nama_kamar' => $data['nama_kamar'],
					'tanggal_pesan' => $data['tanggal_pesan'],
					'tanggal_transaksi' => $data['tanggal_transaksi'],
					'status' => $data['status'],
					'harga_perbulan' => $data['harga_perbulan'],

				);
			}
			return $datas;
		}

		function GetBySearch($search)
		{
			$query = "SELECT pemesanan.*, user.nama, kamar.nama_kamar, kamar.harga_perbulan FROM pemesanan JOIN user ON pemesanan.user_id = user.id_user JOIN kamar ON pemesanan.kamar_id = kamar.id_kamar WHERE user.nama LIKE '%$search%' OR kamar.nama_kamar LIKE '%$search%' OR tanggal_pesan LIKE '%$search%' OR tanggal_transaksi LIKE '%$search%' ";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_pemesanan' => $data['id_pemesanan'],
					'nama' => $data['nama'],
					'nama_kamar' => $data['nama_kamar'],
					'tanggal_pesan' => $data['tanggal_pesan'],
					'tanggal_transaksi' => $data['tanggal_transaksi'],
					'status' => $data['status'],
					'harga_perbulan' => $data['harga_perbulan'],

				);
			}
			return $datas;
		}

		function insert()
		{
			$user_id = $_POST['user_id'];
			$kamar_id = $_POST['kamar_id'];
			$tanggal_pesan = $_POST['tanggal_pesan'];
			$tanggal_transaksi = $_POST['tanggal_transaksi'];
			$status = $_POST['status'];
			$harga_perbulan = $_POST['harga_perbulan'];
			$tanggal = date('Y-m-d H:i:s');

			$query = "INSERT INTO `pemesanan` (`id_pemesanan`,`user_id`,`kamar_id`,`tanggal_pesan`,`tanggal_transaksi`,`status`)
			VALUES (NULL,'$user_id','$kamar_id','$tanggal_pesan','$tanggal_transaksi','$status')";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				if ($status == 2) {
					$tanggal_masuk = date('Y-m-d H:i:s');
					$query_kamar = mysqli_query(connect(), "SELECT harga_perbulan FROM kamar WHERE id_kamar = '$kamar_id'");
					$row_kamar = mysqli_fetch_assoc($query_kamar);
					mysqli_query(connect(), "INSERT INTO user_kamar(user_id, kamar_id, tanggal_masuk) VALUES('$user_id', '$kamar_id', '$tanggal_masuk')");
					mysqli_query(connect(), "INSERT INTO `pembayaran` (`id_pembayaran`,`user_id`,`kamar_id`,`tanggal`,`nominal`,`status`)
					VALUES (NULL,'$user_id','$kamar_id','$tanggal','$row_kamar[harga_perbulan]','1')");
				}
				$_SESSION['success'] = " Data berhasil ditambahkan! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data gagal ditambahkan! ";
				header("Location: index.php");
			}
		}
		function Update($id)
		{
			$user_id = $_POST['user_id'];
			$kamar_id = $_POST['kamar_id'];
			$tanggal_pesan = $_POST['tanggal_pesan'];
			$status = $_POST['status'];
			$harga_perbulan = $_POST['harga_perbulan'];
			$tanggal = date('Y-m-d H:i:s');

			$query = "UPDATE `pemesanan` SET `user_id` = '$user_id',`kamar_id` = '$kamar_id',`tanggal_pesan` = '$tanggal_pesan',`status` = '$status' WHERE `id_pemesanan` =  '$id'";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				if ($status == 2) {
					$tanggal_masuk = date('Y-m-d H:i:s');
					$query_kamar = mysqli_query(connect(), "SELECT harga_perbulan FROM kamar WHERE id_kamar = '$kamar_id'");
					$row_kamar = mysqli_fetch_assoc($query_kamar);
					mysqli_query(connect(), "INSERT INTO user_kamar(user_id, kamar_id, tanggal_masuk) VALUES('$user_id', '$kamar_id', '$tanggal_masuk')");
					mysqli_query(connect(), "INSERT INTO `pembayaran` (`id_pembayaran`,`user_id`,`kamar_id`,`tanggal`,`nominal`,`status`) VALUES (NULL,'$user_id','$kamar_id','$tanggal','$row_kamar[harga_perbulan]','1')");
				} elseif ($status == 3) {
					mysqli_query(connect(), "UPDATE kamar SET status = 0 WHERE id_kamar = '$kamar_id'");
					mysqli_query(connect(), "DELETE FROM user_kamar WHERE user_id = '$user_id'");
				}
				$_SESSION['success'] = " Data berhasil diubah! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data gagal diubah! ";
				header("Location: index.php");
			}
		}
		function Delete($id)
		{
			$query = "DELETE FROM `pemesanan` WHERE `id_pemesanan` = '$id'";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				$_SESSION['success'] = " Data berhasil dihapus! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data gagal dihapus! ";
				header("Location: index.php");
			}
		}
		if (isset($_POST['insert'])) {
			insert();
		} else if (isset($_POST['update'])) {
			update($_POST['id_pemesanan']);
		} else if (isset($_POST['delete'])) {
			delete($_POST['id_pemesanan']);
		} else if (isset($_POST['search'])) {
			GetBySearch($_POST['search']);
		}
		?>
		