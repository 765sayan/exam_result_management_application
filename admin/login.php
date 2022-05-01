<?php
require_once("../config.php");
session_start();
if(isset($_SESSION['role']) and $_SESSION['role']=="ADMIN"){
	header("location: dashboard.php");
}

$username = $password = $error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty(trim($_POST['username']))){
		$username = $_POST['username'];
	}
	if(!empty(trim($_POST['password']))){
		$password = $_POST['password'];
	}

	$sql = "SELECT * FROM `admin` WHERE `username` = '$username'";
	$result = mysqli_query($connection, $sql);
	$assoc = mysqli_fetch_assoc($result);
	$num_rows = mysqli_num_rows($result);
	if($num_rows==1){
		if(password_verify($password, $assoc['password'])){
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['role'] = "ADMIN";
			header("location: dashboard.php");	
		}
		else{
			$error = "Username or Password not correct";
		}
	}
	else{
		$error = "User doesn't exist";
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
		<h1>Admin Login</h1>

		<a href="../">Home</a>
		&nbsp;
		<a href="register.php">Register</a>
		<hr>
		
	</header>
	<form action="" method="POST">
		<fieldset>
			<legend>Login Details</legend>
			<label for="username">Username:</label><br>
			<input type="text" name="username" id="username"><br>
			<label for="password">Password:</label><br>
			<input type="password" name="password" id="password"><br>
			<output><?= $error; ?></output><br><br>
			<input type="submit" value="submit">
		</fieldset>
	</form>
</body>
</html>