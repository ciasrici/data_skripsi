<?php

	require_once 'config/get_connection.php';

	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		mysqli_query(connect(), "INSERT INTO admins(username, password) VALUES('$username', '$password')");
		mysqli_query(connect(), "INSERT INTO gambar_kamar(kamar_id, url) VALUES(1, 'sdsd')");
		if(mysqli_error(connect())){
			echo 'gagal';
			mysqli_rollback(connect());
		}else{
			echo 'berhasil';
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>sas</title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="username" placeholder="username"><br>
		<input type="text" name="password" placeholder="password"><br>
		<button type="submit" name="submit">submit</button>
	</form>
</body>
</html>