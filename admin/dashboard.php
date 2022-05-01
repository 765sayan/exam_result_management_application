<?php
session_start();

if(!isset($_SESSION['username']) and $_SESSION['role'] != "ADMIN"){
	header("location: login.php");	
}
elseif(isset($_SESSION['username']) and $_SESSION['role'] != "ADMIN"){
	if($_SESSION['role'] == "Examiner"){
		header("location: ../examiner/login.php");
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
		<h1>Dashboard</h1>
		<a href="../logout.php">Logout</a>
		<hr>
	</header>
	<ul>
		<li><a href="../exam/student/index.php">Student</a></li>
		<li><a href="../exam/subject/index.php">Subject</a></li>
		<li><a href="../exam/class_section/index.php">Class_Section</a></li>
	</ul>
</body>
</html>