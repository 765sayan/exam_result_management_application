<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role'] != "ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$name = $code = $error = $message = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty(trim($_POST['name']))){
		$name = $_POST['name'];
	}
	else{
		$error = "Please Enter subject name";
	}

	if(!empty(trim($_POST['code']))){
		$code = $_POST['code'];
	}
	else{
		$error = "Please Enter subject code";
	}

	if($error == ""){
		$sql = "INSERT INTO `subject` (name, code) VALUES ('$name', '$code')";
		$query_state = mysqli_query($connection, $sql);
		if($query_state){
			$message = "Subject created";
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
		<h1>Create Subject</h1>
		<a href="../../admin/dashboard.php">Dashboard</a>
		<a href="view.php">View Subjects</a>
		<hr>
	</header>
	
	<form action="" method="POST">
		<fieldset>
			<legend>Subject Details</legend>
			
			<label for="name">Subject Name:</label><br>
			<input type="text" name="name" id="name"><br>
			
			<label for="code">Subject Code:</label><br>
			<input type="text" name="code" id="code"><br>

			<output><?= $error; ?></output>
			<output><?= $message; ?></output><br>
			
			<input type="submit" value="submit">
		</fieldset>
	</form>
	
	
</body>
</html>