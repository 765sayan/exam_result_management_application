<?php
require_once "../config.php";

$name = $username = $password = $error = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(!empty(trim($_POST['name']))){
		$name = $_POST['name'];
	}
	else{
		$error = "Please enter name";
	}

	if(!empty(trim($_POST['username']))){
		$username = $_POST['username'];
	}
	else{
		$error = "Please enter username";
	}

	if(!empty(trim($_POST['password']))){
		$password = $_POST['password'];
		$password = password_hash($password, PASSWORD_DEFAULT);
	}
	else{
		$error = "Please enter password";
	}

	if($error == ""){
		$username = $_POST['username'];
		$sql = "SELECT * FROM `admin` WHERE `username` = '$username'";
		$result = mysqli_query($connection, $sql);
		$num_rows = mysqli_num_rows($result);
		if($num_rows==0){
			$sql = "INSERT INTO `admin` (name, username, password) VALUES ('$name', '$username', '$password')";
			$query_state = mysqli_query($connection, $sql);
			if($query_state){
				header("location: login.php");
			}
		}
		else{
			$error = "Username already Exists";

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
		<h1>Admin Register</h1>

		<a href="../">Home</a>
		&nbsp;
		<a href="login.php">Login</a>
		<hr>
		
	</header>
	<form action="" method="POST">
		<fieldset>
			<legend>Admin Details</legend>
			<label for="name">Name:</label><br>
			<input type="text" name="name" id="name" value="<?php echo $name;?>"><br>
			<label for="username">Username:</label><br>
			<input type="text" name="username" id="username" value="<?php echo $username;?>"><br>
			<label for="name">Password:</label><br>
			<input type="password" name="password" id="password"><br>
			<output><?= $error; ?></output><br><br>
			<input type="submit" value="Submit">
		</fieldset>
	</form>
</body>
</html>