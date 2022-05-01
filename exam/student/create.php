<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role'] != "ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$name = $gender = $class_section = $error = $roll_no = $message = "";
$dob = "";

$class_section =array();
$class_section_nm=array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty(trim($_POST['name']))){
		$name = $_POST['name'];
	}

	else{
		$error= "Enter Name";
	}

	
	
	if($_POST['gender']){
		$gender = $_POST['gender'];
	}
	else{
		$error= "Please select a gender";
	}

	if(!empty(trim($_POST['dob']))){
		$dob = $_POST['dob'];
	}
	else{
		$error= "Please select a date of birth";
	}


	if($_POST['class_section']){
		$class_section = $_POST['class_section'];
	}
	else{
		$error = "Please select a class_section";
	}

	if($_POST['roll_no']){
		$roll_no = $_POST['roll_no'];
	}
	else{
		$error = "Please enter a roll no";
	}

	
	if($error==""){
		$sql="INSERT INTO `student` (name, gender, dob) VALUES('$name', '$gender', '$dob')";
		$query_state = mysqli_query($connection, $sql);
		if($query_state){
			$sql_2 = "SELECT * FROM `student` ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($connection, $sql_2);
			if(mysqli_num_rows($result)==1){
				$assoc = mysqli_fetch_assoc($result);
				$student_id = $assoc['id'];
				$sql = "SELECT * FROM `class_section` WHERE `id` = '$class_section'";
				$assoc = mysqli_fetch_assoc(mysqli_query($connection, $sql));
				$class_section_id = $assoc['id'];
				echo $class_section_name;
				$sql_2 = "INSERT INTO `student_status` (student_id, class_section_id, roll_no) VALUES('$student_id', '$class_section_id', '$roll_no')";
				$query_state = mysqli_query($connection, $sql_2);
				if($query_state){
					$message = "Student created";
					$name = "";
					$dob = "";
					$roll_no = "";

				}
			}
		}
	}

}

$sql_3 = "SELECT * FROM `class_section`";
$result = mysqli_query($connection, $sql_3);
$assoc = mysqli_fetch_all($result);
$num_rows = mysqli_num_rows($result);
for($i=0; $i<$num_rows; $i++){
	$class_section[$i] = $assoc[$i][0];
	$class_section_nm[$i] = $assoc[$i][1];
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
		<h1>Add Student</h1>
		<a href="../../admin/dashboard.php">Dashboard</a>
		<hr>
	</header>
	
	<form action="" method="POST">
		<fieldset>
			<legend>Personal Information</legend>
			<label for="name">Name:</label><br>
			<input type="text" name="name" id="name" value="<?= $name;?>"><br><br>

			<label for="gender">Gender:</label><br>
			<input type="radio" id="Male" name="gender" value="m" checked="checked">
			<label for="Male">Male</label><br>
			<input type="radio" id="Female" name="gender" value="f">
			<label for="Female">Female</label><br>
			<input type="radio" id="Other" name="gender" value="o">
			<label for="Other">Other</label><br><br>

			<label for="dob">Date of Birth:</label><br> 
			<input type="date" name="dob" id="dob" value="<?= $dob;?>"><br><br>
		</fieldset>

		<fieldset>
			<legend>Educational Information</legend>

			<label for="class_section">Class and Section: </label><br>
			<select name='class_section' id='class_section'>
				<?php

				for($i=0; $i<$num_rows; $i++){
					echo "<option value='$class_section[$i]'>$class_section_nm[$i]</option>";
				}

				?>
			</select><br><br>	
			<label for="roll_no">Roll No.:</label><br>

			<input type="number" name="roll_no" id="roll_no" value="<?= $roll_no?>">

			<br>

		</fieldset>

		<output><?= $error?></output>
		<output><?= $message?></output>
		<br>
		<input type="submit" value="Submit">
	</form>
</body>
</html>