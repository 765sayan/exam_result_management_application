<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role'] != "ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$class_section = $error = $message = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty(trim($_POST['class_section']))){
		$class_section = $_POST['class_section'];
	}
	else{
		$error = "Please Enter Class_Section";
	}

	if($error == ""){
		$sql = "INSERT INTO `class_section` (name) VALUES ('$class_section')";
		$query_state = mysqli_query($connection, $sql);
		if($query_state){
			$message = "Class_Section created";
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
		<h1>Create Class_Section</h1>
		<a href="../../admin/dashboard.php">Dashboard</a>
		<a href="view.php">View Class Sections</a>
		<hr>
	</header>
	
	<form action="" method="POST">
		<fieldset>
			<legend>Class_Section Details</legend>
			
			<label for="class_section">Class_Section:</label><br>
			<input type="text" name="class_section" id="class_section"><br>
			
			<output><?= $error; ?></output>
			<output><?= $message; ?></output><br>
			

			<input type="submit" value="submit">
		</fieldset>
	</form>
	
	
</body>
</html>