
<?php
if(isset($_SESSION['role'])) {
	if($_SESSION['role']=="ADMIN") {
		header("location: admin/dashboard.php");
	}
	elseif($_SESSION['role']=="ADMIN") {
		header("location: examiner/dashboard.php");
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
		<h1>Welcome</h1>

		<a href="admin/login.php">Admin</a>
		&nbsp;
		<a href="examiner/login.php">Examiner</a>
		<hr>
		
	</header>
</body>
</html>
