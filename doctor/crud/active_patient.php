<?php
	include 'conn.php';
	
	$id = $_GET['id'];
		$sql = "UPDATE patient_table set patient_status = 'Active' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Schedule deleted successfully';

		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	header('location: ../patient.php');
	
?>