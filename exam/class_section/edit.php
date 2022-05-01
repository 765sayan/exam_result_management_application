<?php
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role'] != "ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$id = $name = "";
$error = $message = "";
$assoc = array();
if(!empty(trim($_GET['id']))){
	$id = $_GET['id'];

	$sql = "SELECT * FROM `class_section` WHERE `id` = '$id'";
	$result = mysqli_query($connection, $sql);
	$assoc = mysqli_fetch_assoc($result);

}else header("location: view.php");
	
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty(trim($_POST['name']))){
		$name = $_POST['name'];
	}

	$sql_2 = "UPDATE `class_section` SET `name` = '$name' WHERE `id` = '$id'";
	$query_state = mysqli_query($connection, $sql_2);
	if($query_state){
		$message = "Class_Section edited";
		$assoc['name'] = $name;
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
		<h1>Edit Class Section</h1>
		<a href="../../../admin/dashboard.php">Dashboard</a>
		<a href="../view.php">View Class Sections</a>
		<hr>
	</header>
	
	<form action="" method="POST">
		<fieldset>
			<legend>Class_Section Details</legend>
			
			<label for="name">Class Section Name:</label><br>
			<input type="text" name="name" id="name" value="<?=$assoc['name']?>"><br>
			

			<output><?= $error; ?></output>
			<output><?= $message; ?></output><br>
			
			<input type="submit" value="Edit">
		</fieldset>
	</form>
	
	
</body>
</html>