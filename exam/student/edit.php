<?php
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role'] != "ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$id = $name = $gender = $dob = $class_section = $roll_no = "";
$error = $message = "";
$assoc = array();
if(!empty(trim($_GET['id']))){
	$id = $_GET['id'];

	if(!empty(trim($id))){
		$sql_2 = "
		SELECT
		`joined_table`.`id`,
		`joined_table`.`name`,
		`joined_table`.`gender`,
		`joined_table`.`dob`,
		`class_section`.`name`,
		`joined_table`.`roll_no`,
		`joined_table`.`class_section_id`
		FROM
		(
			SELECT
			`student`.`id`,
			`student`.`name`,
			`student`.`gender`,
			`student`.`dob`,
			`student_status`.`roll_no`,
			`student_status`.`class_section_id`
			FROM
			`student`
			JOIN(
				SELECT
            *
				FROM
				`student_status`
				WHERE
				(
					`id` IN(
						SELECT
						MAX(id)
						FROM
						`student_status`
						GROUP BY
						`student_id`
						)
					)
				) AS `student_status`
			ON
			`student`.`id` = `student_status`.`student_id`

			) AS `joined_table`
		JOIN `class_section` ON `joined_table`.`class_section_id` = `class_section`.`id`

		WHERE `joined_table`.`id` = '$id'

		";
		$result = mysqli_query($connection, $sql);
		$assoc = mysqli_fetch_assoc($result);
	}

}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty(trim($_POST['name']))){
		$name = $_POST['name'];
	}

	if(!empty(trim($_POST['gender']))){
		$gender = $_POST['gender'];
	}

	if(!empty(trim($_POST['dob']))){
		$dob = $_POST['dob'];
	}

	if(!empty(trim($_POST['class_section']))){
		$class_section_id = $_POST['class_section']; 
	}

	if(!empty(trim($_POST['roll_no']))){
		$roll_no = $_POST['roll_no'];
	}

	$sql_1 = "UPDATE `student` SET `name` = '$name', `gender` = '$gender', `dob` = '$dob' WHERE `id` = '$id'";

	$sql_2 = "SELECT * FROM `class_section`";
	$result = mysqli_query($connection, $sql_2);
	$assoc = mysqli_fetch_all($result);
	$class_section_nm = $assoc['name'];
	$sql_3 = "UPDATE `student_status` SET `class_section_id` = '$class_section_id', `roll_no` = '$roll_no' WHERE `id`='$id'";
	$query_state = mysqli_query($connection, $sql_2);
	if($query_state){
		$message = "student edited";
		$assoc['name'] = $name;
		$assoc['dob'] = $dob;
		$assoc['roll_no'] = $roll_no;
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
		<h1>Edit Student</h1>
		<a href="../../admin/dashboard.php">Dashboard</a>
		<hr>
	</header>
	
	<form action="" method="POST">
		<fieldset>
			<legend>personal Information</legend>
			<label for="name">Name:</label><br>
			<input type="text" name="name" id="name" value="<?= $assoc['name'];?>"><br><br>

			<label for="gender">Gender:</label><br>
			<input type="radio" id="Male" name="gender" value="m" checked="checked">
			<label for="Male">Male</label><br>
			<input type="radio" id="Female" name="gender" value="f">
			<label for="Female">Female</label><br>
			<input type="radio" id="Other" name="gender" value="o">
			<label for="Other">Other</label><br><br>

			<label for="dob">Date of Birth:</label><br> 
			<input type="date" name="dob" id="dob" value="<?= $assoc['dob'];?>"><br><br>
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

			<input type="number" name="roll_no" id="roll_no" value="<?= $assoc['roll_no']?>">

			<br>

		</fieldset>

		<output><?= $error?></output>
		<output><?= $message?></output>
		<br>
		<input type="submit" value="Submit">
	</form>
</body>
</html>