<?php
session_start();
if(isset($_SESSION['role']) and $_SESSION['role']=='ADMIN'){
	header("location: dashboard.php");
}
else{
	header("location: ../index.php");
}

?>