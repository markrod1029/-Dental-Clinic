<?php
	session_start();
	include 'config.php';

	if(!isset($_SESSION['doctor']) || trim($_SESSION['doctor']) == ''){
		header('location: home.php');
	}

	$sql = "SELECT * FROM doctor_table WHERE id = '".$_SESSION['doctor']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>