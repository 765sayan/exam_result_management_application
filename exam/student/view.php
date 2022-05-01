<?php
session_start();
if(!isset($_SESSION['role']) or $_SESSION['role']!="ADMIN"){
	header("location: ../../index.php");
}
require_once('../../config.php');

$name = $gender = $class_section = $roll_no = $sort_by = "";
$name_clause = $gender_clause = $class_section_clause = $roll_no_clause = $sort_by_clause = "";
$error = "";

$sql = "SELECT * FROM `class_section`";
$result = mysqli_query($connection, $sql);
$assoc = mysqli_fetch_all($result);


if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['roll_no'])){
		$roll_no = trim($_GET['roll_no']);
		if ($roll_no !== "")
			$roll_no_clause = "AND (`roll_no` = ".$roll_no.")";
	}

	if(isset($_GET['class_section'])){
		$class_section = trim($_GET['class_section']);
		if ($class_section !== "")
			$class_section_clause = "AND (`class_section_id` = ".$class_section.")";
	}

	if(isset($_GET['gender']) and trim($_GET['gender']) !== ""){
		$gender = trim($_GET['gender']);
		$gender_clause = "(`gender` = '".$gender."')";
	} else $gender_clause = "1";

	if(isset($_GET['name']) and trim($_GET['name']) !== ""){
		$name = trim($_GET['name']);
		$name_clause = "AND (`name` LIKE '%".$name."%')";
	} else $name_clause = "AND 1";

	if(isset($_GET['sort_by'])){
		$sort_by = $_GET['sort_by'];
		switch ($sort_by) {
			case '0':
				$sort_by_clause = "";
				break;
			
			case '1':
				$sort_by_clause = "ORDER BY `joined_table`.`name`";
				break;

			case '2':
				$sort_by_clause = "ORDER BY `joined_table`.`roll_no`";
				break;

			case '3':
				$sort_by_clause = "ORDER BY `joined_table`.`roll_no` DESC";
				break;

		}


	}

	




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
					) ".$roll_no_clause." ".$class_section_clause."
				)
			) AS `student_status`
		ON
		`student`.`id` = `student_status`.`student_id`
		WHERE
		".$gender_clause." ".$name_clause."
		) AS `joined_table`
	JOIN `class_section` ON `joined_table`.`class_section_id` = `class_section`.`id`

	".$sort_by_clause."
	";

	$_result = mysqli_query($connection, $sql_2);
	$_assoc = mysqli_fetch_all($_result);


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
		<h1>View Students</h1>
		<a href="../../admin/dashboard.php">Dashboard</a>
		<hr>
	</header>
	
	<form action="" method="GET">

		<fieldset>
			<legend>Search Information</legend>

			<label for="name">Name: </label>
			<input type="text" name="name" id="name" value="<?= $name ?>">
			&nbsp;

			<label for="gender">Gender: </label>
			<select name="gender" id="gender">

				<option value=""></option>
				<option value="m">Male</option>
				<option value="f">Female</option>
				<option value="o">Other</option>

			</select>
			&nbsp;

			<label for="class_section">Class and Section: </label>
			<select name='class_section' id='class_section'>
				<option></option>
				<?php

				for($i=0; $i<mysqli_num_rows($result); $i++){
					echo "<option value='".$assoc[$i][0]."'>".$assoc[$i][1]."</option>";
				}

				?>
			</select>
			&nbsp;

			<label for="roll_no">Roll No.: </label>
			<input type="text" name="roll_no" id="roll_no" value="<?= $roll_no ?>">
			&nbsp;

			<label for="sort_by"> Sort By: </label>
			<select name="sort_by" id="sort_by">
				<option value="0"></option>
				<option value="1">Name</option>
				<option value="2">Roll No Asc</option>
				<option value="3">Roll No Desc</option>
			</select>

			<input type="submit" value="Search">
			<input type="reset" value="Reset">

		</fieldset>
		<br>
	</form>

	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Date of Birth</th>
				<th>Class Section</th>
				<th>Roll No.</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $i<mysqli_num_rows($_result); $i++){

			$gender = "Other";
			if($_assoc[$i][2] == "m") $gender = "Male";
			if($_assoc[$i][2] == "f") $gender = "Female";

			echo "
			<tr>
			<td>{$_assoc[$i][0]}</td>
			<td>{$_assoc[$i][1]}</td>
			<td>{$gender}</td>
			<td>{$_assoc[$i][3]}</td>
			<td>{$_assoc[$i][4]}</td>
			<td>{$_assoc[$i][5]}</td>
			<td><a href='edit.php/?id={$assoc[$i][0]}'>Edit</a></td>		
			</tr>";
		}
		?>
		</tbody>
	</table>
</body>
</html>