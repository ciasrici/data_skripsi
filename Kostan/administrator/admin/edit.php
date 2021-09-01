<?php
// session_start();
require_once 'function.php';
require "../templates/header.html";
require "../templates/navbar.html";
require "../templates/sidebar.html";
$id_admin = $_POST['id_admin'];
$datas = GetById($id_admin);
?>

<div class="dashboard-wrapper">
	<div class="container-fluid dashboard-content">
		<div class='card'>
			<div class='card-header'>Edit admin</div>
				<div class='card-body'>
					<form action='function.php' method='post'>
					<input type='hidden' name='id_admin' value="<?php echo $_POST['id_admin']; ?>">
		            <?php
		            foreach($datas as $data){?>
		               
		                <div class="form-group">
		                  <label for="username">Username</label>
		                  <input type="text" class="form-control" id="username" name='username' value="<?php echo $data['username']; ?>">
		                </div>
		            
		                <div class="form-group">
		                  <label for="password">Password</label>
		                  <input type="text" class="form-control" id="password" name='password' value="<?php echo $data['password']; ?>">
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