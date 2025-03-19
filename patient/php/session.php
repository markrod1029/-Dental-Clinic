<?php
	session_start();
	include 'config.php';

	if(!isset($_SESSION['patient']) || trim($_SESSION['patient']) == ''){
		header('location: users.php');
	}

	$sql = "SELECT * FROM patient_table WHERE id = '".$_SESSION['patient']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>