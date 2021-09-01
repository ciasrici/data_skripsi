
		<?php
			session_start();
			require_once '../config/get_connection.php';
			function getAll()
			{
				$exe = pagination()["exe"];
				while($row = mysqli_fetch_assoc($exe)){
					$data[] = ['id_gambar_kamar' => $row['id_gambar_kamar'],
'kamar_id' => $row['kamar_id'],
'url' => $row['url'],
];
				}

				return $data;
			}	
			function pagination()
			{
				$min_data = 10;
			    $page = isset($_GET['page']) ? $_GET['page'] : 1;
			    $start = ($page>1) ? ($page * $min_data) - $min_data : 0;
			    $result_page = mysqli_query(connect() ,"SELECT * FROM gambar_kamar");
			    $total = mysqli_num_rows($result_page);
			    $total_page = ceil($total/$min_data);            

			    $query = "SELECT * FROM gambar_kamar ORDER BY id_gambar_kamar ASC LIMIT $start, $min_data";
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
		  $query = "SELECT * FROM  `gambar_kamar` WHERE  `id_gambar_kamar` =  '$id'";
		  $exe = mysqli_query(connect(),$query);
		  while($data = mysqli_fetch_array($exe)){
		    $datas[] = array('id_gambar_kamar' => $data['id_gambar_kamar'], 
		'kamar_id' => $data['kamar_id'], 
		'url' => $data['url'], 
		
		    );
		  }
		return $datas;
		}
		
		function GetBySearch($search)
		{
		  $query = "SELECT * FROM  `gambar_kamar` WHERE kamar_id LIKE '%$search%' OR url LIKE '%$search%' ";
		  $exe = mysqli_query(connect(),$query);
		  while($data = mysqli_fetch_array($exe)){
		    $datas[] = array('id_gambar_kamar' => $data['id_gambar_kamar'], 
		'kamar_id' => $data['kamar_id'], 
		'url' => $data['url'], 
		
		    );
		  }
		return $datas;
		}
		
		function insert()
		{
		  $kamar_id=$_POST['kamar_id']; 
		$url=$_POST['url']; 
		
			  $query = "INSERT INTO `gambar_kamar` (`id_gambar_kamar`,`kamar_id`,`url`)
			VALUES (NULL,'$kamar_id','$url')";
			$exe = mysqli_query(connect(),$query);
			  if($exe){
			    // kalau berhasil
			    $_SESSION['success'] = " Data added! ";
			    header("Location: index.php");
			  }
			  else{
			    $_SESSION['failed'] = " Data failed to add ";
			    header("Location: index.php");
			  }
		}
			function Update($id){
			  $kamar_id=$_POST['kamar_id']; 
		$url=$_POST['url']; 
		
			  $query = "UPDATE `gambar_kamar` SET `kamar_id` = '$kamar_id',`url` = '$url' WHERE  `id_gambar_kamar` =  '$id'";
			$exe = mysqli_query(connect(),$query);
			  if($exe){
			    // kalau berhasil
			    $_SESSION['success'] = " Data updated! ";
			    header("Location: index.php");
			  }
			  else{
			    $_SESSION['failed'] = " Data failed to updated ";
			    header("Location: index.php");
			  }
			}
			function Delete($id){
			  $query = "DELETE FROM `gambar_kamar` WHERE `id_gambar_kamar` = '$id'";
			  $exe = mysqli_query(connect(),$query);
			    if($exe){
			    // kalau berhasil
			    	$_SESSION['success'] = " Data deleted! ";
			    	header("Location: index.php");
			  	}
			  else{
			    	$_SESSION['failed'] = " Data failed to delete ";
			    	header("Location: index.php");
			  }
			}
		if(isset($_POST['insert'])){
		  insert();
		}
		else if(isset($_POST['update'])){
		  update($_POST['id_gambar_kamar']);
		}
		else if(isset($_POST['delete'])){
		  delete($_POST['id_gambar_kamar']);
		}else if(isset($_POST['search'])){
			GetBySearch($_POST['search']);
		}
		?>
		