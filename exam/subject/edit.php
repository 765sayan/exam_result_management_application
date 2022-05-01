<?php
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role'] != "ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$id = $name = $code = "";
$error = $message = "";
$assoc = array();
if(!empty(trim($_GET['id']))){
	$id = $_GET['id'];

	$sql = "SELECT * FROM `subject` WHERE `id` = '$id'";
	$result = mysqli_query($connection, $sql);
	$assoc = mysqli_fetch_assoc($result);

}else header("location: view.php");

	
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty(trim($_POST['name']))){
		$name = $_POST['name'];
	}
	if(!empty(trim($_POST['code']))){
		$code = $_POST['code'];
	}

	$sql_2 = "UPDATE `subject` SET `name` = '$name', `code` = '$code' WHERE `id` = '$id'";
	$query_state = mysqli_query($connection, $sql_2);
	if($query_state){
		$message = "Subject edited";
		$assoc['name'] = $name;
		$assoc['code'] = $code;
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
		<h1>Edit Subject</h1>
		<a href="../../../admin/dashboard.php">Dashboard</a>
		<a href="../view.php">View Subjects</a>
		<hr>
	</header>
	
	<form action="" method="POST">
		<fieldset>
			<legend>Subject Details</legend>
			
			<label for="name">Subject Name:</label><br>
			<input type="text" name="name" id="name" value="<?=$assoc['name']?>"><br>
			
			<label for="code">Subject Code:</label><br>
			<input type="text" name="code" id="code" value="<?=$assoc['code']?>"><br>

			<output><?= $error; ?></output>
			<output><?= $message; ?></output><br>
			
			<input type="submit" value="Edit">
		</fieldset>
	</form>
	
	
</body>
</html>