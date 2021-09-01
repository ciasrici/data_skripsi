
		<?php
		session_start();
		require_once '../config/get_connection.php';
		function getAll()
		{
			$exe = pagination()["exe"];
			while ($row = mysqli_fetch_assoc($exe)) {
				$data[] = [
					'id_pembayaran' => $row['id_pembayaran'],
					'user_id' => $row['user_id'],
					'kamar_id' => $row['kamar_id'],
					'tanggal' => $row['tanggal'],
					'nominal' => $row['nominal'],
					'status' => $row['status'],
					'nama' => $row['nama'],
					'nama_kamar' => $row['nama_kamar'],
				];
			}

			return $data;
		}
		function pagination()
		{
			$min_data = 10;
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start = ($page > 1) ? ($page * $min_data) - $min_data : 0;
			$result_page = mysqli_query(connect(), "SELECT user.nama, kamar.nama_kamar, pembayaran.* FROM pembayaran JOIN user ON pembayaran.user_id = user.id_user JOIN kamar ON pembayaran.kamar_id = kamar.id_kamar");
			$total = mysqli_num_rows($result_page);
			$total_page = ceil($total / $min_data);

			$query = "SELECT user.nama, kamar.nama_kamar, pembayaran.* FROM pembayaran JOIN user ON pembayaran.user_id = user.id_user JOIN kamar ON pembayaran.kamar_id = kamar.id_kamar ORDER BY tanggal DESC LIMIT $start, $min_data";
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
			$query = "SELECT * FROM  `pembayaran` WHERE  `id_pembayaran` =  '$id'";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_pembayaran' => $data['id_pembayaran'],
					'user_id' => $data['user_id'],
					'kamar_id' => $data['kamar_id'],
					'tanggal' => $data['tanggal'],
					'nominal' => $data['nominal'],
					'status' => $data['status'],
				);
			}
			return $datas;
		}

		function GetBySearch($search)
		{
			$query = "SELECT user.nama, kamar.nama_kamar, pembayaran.* FROM pembayaran JOIN user ON pembayaran.user_id = user.id_user JOIN kamar ON pembayaran.kamar_id = kamar.id_kamar WHERE user.nama LIKE '%$search%' OR kamar.nama_kamar LIKE '%$search%' OR tanggal LIKE '%$search%'";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_pembayaran' => $data['id_pembayaran'],
					'user_id' => $data['user_id'],
					'kamar_id' => $data['kamar_id'],
					'tanggal' => $data['tanggal'],
					'nominal' => $data['nominal'],
					'status' => $data['status'],
					'nama' => $data['nama'],
					'nama_kamar' => $data['nama_kamar'],
				);
			}
			return $datas;
		}

		function GetByDate()
		{
			$dari = $_GET['dari'] . " 00:00:00";
			$sampai = $_GET['sampai'] . " 23:59:59";
			$query = "SELECT user.nama, kamar.nama_kamar, pembayaran.* FROM pembayaran JOIN user ON pembayaran.user_id = user.id_user JOIN kamar ON pembayaran.kamar_id = kamar.id_kamar WHERE tanggal BETWEEN '$dari' AND '$sampai'";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_pembayaran' => $data['id_pembayaran'],
					'user_id' => $data['user_id'],
					'kamar_id' => $data['kamar_id'],
					'tanggal' => $data['tanggal'],
					'nominal' => $data['nominal'],
					'status' => $data['status'],
					'nama' => $data['nama'],
					'nama_kamar' => $data['nama_kamar'],
				);
			}
			return $datas;
		}

		function insert()
		{
			$user_id = $_POST['user_id'];
			$kamar_id = $_POST['kamar_id'];
			$tanggal = $_POST['tanggal'] . ' ' . date('H:i:s');
			$nominal = $_POST['nominal'];
			$status = 1;

			$query = "INSERT INTO `pembayaran` (`id_pembayaran`,`user_id`,`kamar_id`,`tanggal`,`nominal`,`status`)
			VALUES (NULL,'$user_id','$kamar_id','$tanggal','$nominal','$status')";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				$_SESSION['success'] = " Data added! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data failed to add ";
				header("Location: index.php");
			}
		}
		function Update($id)
		{
			$user_id = $_POST['user_id'];
			$kamar_id = $_POST['kamar_id'];
			$tanggal = $_POST['tanggal'] . ' ' . date('H:i:s');
			$nominal = $_POST['nominal'];
			$status = $_POST['status'];

			$query = "UPDATE `pembayaran` SET `user_id` = '$user_id',`kamar_id` = '$kamar_id',`tanggal` = '$tanggal',`nominal` = '$nominal',`status` = '$status' WHERE  `id_pembayaran` =  '$id'";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				$_SESSION['success'] = " Data updated! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data failed to updated ";
				header("Location: index.php");
			}
		}
		function Delete($id)
		{
			$query = "DELETE FROM `pembayaran` WHERE `id_pembayaran` = '$id'";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				$_SESSION['success'] = " Data deleted! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data failed to delete ";
				header("Location: index.php");
			}
		}

		function getUsers()
		{
			$query = "SELECT * FROM  `user` ORDER BY nama ASC";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_user' => $data['id_user'],
					'nama' => $data['nama'],
					'username' => $data['username'],
					'password' => $data['password'],
					'alamat' => $data['alamat'],
					'status' => $data['status'],
					'hp' => $data['hp'],
					'email' => $data['email'],

				);
			}
			return $datas;
		}

		function getUserIdFromAjax($user_id)
		{
			$query = mysqli_query(connect(), "SELECT kamar.nama_kamar, user.nama, user_kamar.user_id, user_kamar.kamar_id FROM user_kamar JOIN user ON user_kamar.user_id = user.id_user JOIN kamar ON user_kamar.kamar_id = kamar.id_kamar WHERE user_id = '$user_id'");
			$row = mysqli_fetch_array($query);

			echo json_encode($row);
		}

		if (isset($_POST['insert'])) {
			insert();
		} else if (isset($_POST['update'])) {
			update($_POST['id_pembayaran']);
		} else if (isset($_POST['delete'])) {
			delete($_POST['id_pembayaran']);
		} else if (isset($_POST['search'])) {
			GetBySearch($_POST['search']);
		} else if (isset($_POST['date'])) {
			GetByDate();
		} else if (isset($_POST['getUserIdFromAjax'])) {
			getUserIdFromAjax($_POST['getUserIdFromAjax']);
		}
		?>
		