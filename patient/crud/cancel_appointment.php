<?php
	include 'conn.php';
	
	$id = $_GET['id'];
		$sql = "UPDATE appointment_table set status = 'Cancel' WHERE appointment_id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Appointment Cancel Successfully';

		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	header('location: ../appointment.php');
	
?>