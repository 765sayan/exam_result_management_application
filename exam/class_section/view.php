<?php 
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role']!="ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$name = $error = "";
$page = 0;

if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['name'])){
		$name = trim($_GET['name']);
	}

	if(isset($_GET['page'])){
		$page = (int)$_GET['page'];
		if ($page < 0) {
			$page = 0;
		}
	}

	$offset = 10*$page;


	if($error == "") {
		// $sql = "SELECT * FROM `subject` WHERE `name` LIKE %$name% AND `code` LIKE %$code% LIMIT $page, 10";
		$sql = "SELECT * FROM `class_section` WHERE `name` LIKE '%$name%' LIMIT $offset, 10";
		$result = mysqli_query($connection, $sql);
		$assoc = mysqli_fetch_all($result);
		
		if(mysqli_num_rows($result) == 0) {
			$error = "No data";
		}
	}
}
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<header>
		<h1>View Class Section</h1>
		<a href="../../admin/dashboard.php">Dashboard</a>
		<a href="create.php">Create Class Section</a>
		<hr>
	</header>
	
	<form action="" method="GET">
		<fieldset>
			<legend>Search information</legend>
			
			<label for="name">Class Section Name:</label>
			<input type="text" name="name" id="name" value="<?=$name?>">
			
			&nbsp;

			<input type="submit" value="submit"><br>

			<output><?= $error;?></output>
			
		</fieldset>
	</form><br>
	
	
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th></th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			


			for($i=0; $i<mysqli_num_rows($result); $i++){
				

				echo "<tr>
				<td>{$assoc[$i][0]}</td>
				<td>{$assoc[$i][1]}</td>
				<td><a href='edit.php/?id={$assoc[$i][0]}'>Edit</a></td>
				</tr>";
			}
			
			?>
		</tbody>
	</table>
	<a href="?name=<?= $name?>&page=<?= $page-1?>&">prev</a>
	&nbsp;
	<a href="?name=<?= $name?>&page=<?= $page+1?>&">next</a>
	
</body>
</html>