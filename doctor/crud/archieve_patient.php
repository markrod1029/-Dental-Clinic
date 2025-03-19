<?php
	include 'conn.php';
	
	$id = $_GET['patient_id'];
	$status = 'Archive';
		$sql = "UPDATE patient_table set patient_status = 'Archive' WHERE patient_id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Schedule deleted successfully';

		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	header('location: ../patient.php');
	
?>