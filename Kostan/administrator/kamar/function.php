
		<?php
		session_start();
		require_once '../config/get_connection.php';
		function getAll()
		{
			$exe = pagination()["exe"];
			while ($row = mysqli_fetch_assoc($exe)) {
				$data[] = [
					'id_kamar' => $row['id_kamar'],
					'nama_kamar' => $row['nama_kamar'],
					'fasilitas' => $row['fasilitas'],
					'harga_perbulan' => $row['harga_perbulan'],
				];
			}

			return $data;
		}
		function pagination()
		{
			$min_data = 10;
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start = ($page > 1) ? ($page * $min_data) - $min_data : 0;
			$result_page = mysqli_query(connect(), "SELECT * FROM kamar");
			$total = mysqli_num_rows($result_page);
			$total_page = ceil($total / $min_data);

			$query = "SELECT * FROM kamar ORDER BY id_kamar ASC LIMIT $start, $min_data";
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
			$query = "SELECT * FROM  `kamar` WHERE  `id_kamar` =  '$id'";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_kamar' => $data['id_kamar'],
					'nama_kamar' => $data['nama_kamar'],
					'fasilitas' => $data['fasilitas'],
					'harga_perbulan' => $data['harga_perbulan'],
					'gambar' => $data['gambar'],

				);
			}
			return $datas;
		}

		function GetBySearch($search)
		{
			$query = "SELECT * FROM  `kamar` WHERE nama_kamar LIKE '%$search%' OR fasilitas LIKE '%$search%' OR harga_perbulan LIKE '%$search%'";
			$exe = mysqli_query(connect(), $query);
			while ($data = mysqli_fetch_array($exe)) {
				$datas[] = array(
					'id_kamar' => $data['id_kamar'],
					'nama_kamar' => $data['nama_kamar'],
					'fasilitas' => $data['fasilitas'],
					'harga_perbulan' => $data['harga_perbulan'],

				);
			}
			return $datas;
		}

		function insert()
		{
			$nama_kamar = $_POST['nama_kamar'];
			$fasilitas = $_POST['fasilitas'];
			$harga_perbulan = $_POST['harga_perbulan'];
			$nama_file = null;
			if($_FILES['gambar']['name']){
				$nama_file = time()."_".$_FILES['gambar']['name'];
				$source = $_FILES['gambar']['tmp_name'];
				$folder = './../assets/images/kamar/';

				move_uploaded_file($source, $folder . $nama_file);
			}

			$query = "INSERT INTO `kamar` (`id_kamar`,`nama_kamar`,`fasilitas`,`harga_perbulan`, `gambar`)
			VALUES (NULL,'$nama_kamar','$fasilitas','$harga_perbulan', '$nama_file')";
			$exe = mysqli_query(connect(), $query);
			if ($exe) {
				// kalau berhasil
				$_SESSION['success'] = " Data berhasil ditambahkan! ";
				header("Location: index.php");
			} else {
				$_SESSION['failed'] = " Data gagal ditambahkan! ";
				header("Location: index.php");
			}
		}
		function Update($id)
		{
			$nama_kamar = $_POST['nama_kamar'];
			$fasilitas = $_POST['fasilitas'];
			$harga_perbulan = $_POST['harga_perbulan'];

			$nama_file = (($_POST['gambar_lama']) && ($_POST['gambar_lama'] != '' || $_POST['gambar_lama'] != null)) ? $_POST['gambar_lama'] : null;
			$gambar_lama = $_POST['gambar_lama'];

			if($_FILES['gambar']['name']){
				$folder = './../assets/images/kamar/';
				$nama_file = time()."_".$_FILES['gambar']['name'];
				$source = $_FILES['gambar']['tmp_name'];
				unlink($folder.$gambar_lama);
				move_uploaded_file($source, $folder . $nama_file);
			}

			$query = "UPDATE `kamar` SET `nama_kamar` = '$nama_kamar',`fasilitas` = '$fasilitas',`harga_perbulan` = '$harga_perbulan', `gambar` = '$nama_file' WHERE  `id_kamar` =  '$id'";
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
			$query = "DELETE FROM `kamar` WHERE `id_kamar` = '$id'";
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
			update($_POST['id_kamar']);
		} else if (isset($_POST['delete'])) {
			delete($_POST['id_kamar']);
		} else if (isset($_POST['search'])) {
			GetBySearch($_POST['search']);
		}
		?>
		