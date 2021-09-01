
		<?php
		session_start();
		require_once '../config/get_connection.php';
		function getAll()
		{
			$exe = pagination()["exe"];
			while ($row = mysqli_fetch_assoc($exe)) {
				$data[] = [
					'id_user' => $row['id_user'],
					'nama' => $row['nama'],
					'username' => $row['username'],
					'password' => $row['password'],
					'alamat' => $row['alamat'],
					'status' => $row['status'],
					'hp' => $row['hp'],
					'email' => $row['email'],
				];
			}

			return $data;
		}
		function pagination()
		{
			$min_data = 10;
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start = ($page > 1) ? ($page * $min_data) - $min_data : 0;
			$result_page = mysqli_query(connect(), "SELECT * FROM user");
			$total = mysqli_num_rows($result_page);
			$total_page = ceil($total / $min_data);

			$query = "SELECT * FROM user ORDER BY id_user ASC LIMIT $start, $min_data";
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
			$query = "SELECT * FROM  `user` WHERE  `id_user` =  '$id'";
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

		function GetBySearch($search)
		{
			$query = "SELECT * FROM  `user` WHERE nama LIKE '%$search%' OR username LIKE '%$search%' OR password LIKE '%$search%' OR alamat LIKE '%$search%' OR status LIKE '%$search%' OR hp LIKE '%$search%' OR email LIKE '%$search%' ";
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

		function insert()
		{
			$nama = $_POST['nama'];
			$username = $_POST['username'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$alamat = $_POST['alamat'];
			$status = $_POST['status'];
			$hp = $_POST['hp'];
			$email = $_POST['email'];

			$query = "INSERT INTO `user` (`id_user`,`nama`,`username`,`password`,`alamat`,`status`,`hp`,`email`)
			VALUES (NULL,'$nama','$username','$password','$alamat','$status','$hp','$email')";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				if (isset($_POST['daftar'])) {
					$_SESSION['success'] = " Daftar berhasil! ";
					header("Location: ../../login.php");
				} else {
					$_SESSION['success'] = " Data berhasil ditambahkan! ";
					header("Location: index.php");
				}
			} else {
				if (isset($_POST['daftar'])) {
					$_SESSION['failed'] = " Daftar Gagal! ";
					header("Location: ../../daftar.php");
				} else {
					$_SESSION['failed'] = " Data gagal ditambahkan! ";
					header("Location: index.php");
				}
			}
		}
		function Update($id)
		{
			$nama = $_POST['nama'];
			$username = $_POST['username'];
			$alamat = $_POST['alamat'];
			$status = $_POST['status'];
			$hp = $_POST['hp'];
			$email = $_POST['email'];

			$query = "UPDATE `user` SET `nama` = '$nama',`username` = '$username',`alamat` = '$alamat',`status` = '$status',`hp` = '$hp',`email` = '$email' WHERE  `id_user` =  '$id'";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				$_SESSION['success'] = " Data berhasil diubah! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data gagal diubah! ";
				header("Location: index.php");
			}
		}
		function Delete($id)
		{
			$query = "DELETE FROM `user` WHERE `id_user` = '$id'";
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
			update($_POST['id_user']);
		} else if (isset($_POST['delete'])) {
			delete($_POST['id_user']);
		} else if (isset($_POST['search'])) {
			GetBySearch($_POST['search']);
		}
		?>
		