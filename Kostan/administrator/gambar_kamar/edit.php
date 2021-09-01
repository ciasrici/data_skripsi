
		<?php 
			require_once '../functions/function.php';
			require_once 'function.php'; 
			$id_gambar_kamar = $_POST['id_gambar_kamar'];
			$datas = GetById($id_gambar_kamar);
		?>

		<!DOCTYPE html>
		<html>
		<head>
			<title>CRUD Generator</title>
			<meta charset="utf-8">
		    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		    <meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>
		</head>
		<body>
			<div class='container mt-3'>
				<div class='card'>
					<div class='card-header'>Create gambar_kamar</div>
					<div class='card-body'>
						<form action='function.php' method='post'>
						<input type='hidden' name='id_gambar_kamar' value="<?php echo $_POST['id_gambar_kamar']; ?>">
			            <?php
			            foreach($datas as $data){?>
			               
			                <div class="form-group">
			                  <label for="kamar_id"> kamar_id:</label>
			                  <input type="text" class="form-control" id="kamar_id" name='kamar_id' value="<?php echo $data['kamar_id']; ?>">
			                </div>
			            
			                <div class="form-group">
			                  <label for="url"> url:</label>
			                  <input type="text" class="form-control" id="url" name='url' value="<?php echo $data['url']; ?>">
			                </div>
			            
			            <?php } ?>
					</div>
					<div class='card-footer'>
						<button type='submit' name='update' class='btn btn-primary btn-sm'>Update</button>
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>