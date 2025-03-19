<?php

	include 'conn.php';


	if(isset($_POST['submit'])){

		$id = $_POST['id'];
		$doctor_schedule_date = $_POST['doctor_schedule_date'];
		$doctor_schedule_day = date('l', strtotime($_POST["doctor_schedule_date"]));
		$doctor_schedule_start_time = $_POST['doctor_schedule_start_time'];
		$doctor_schedule_end_time = $_POST['doctor_schedule_end_time'];
		$average_consulting_time = $_POST['average_consulting_time'];
		

		$insert = "INSERT INTO doctor_schedule_table (doctor_id, doctor_schedule_date, doctor_schedule_day, doctor_schedule_start_time, doctor_schedule_end_time, average_consulting_time) 
		VALUES ('$id', '$doctor_schedule_date', '$doctor_schedule_day', '$doctor_schedule_start_time', '$doctor_schedule_end_time', '$average_consulting_time')";
		if($conn->query($insert)){
			$_SESSION['success'] = 'Teacher added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}


	}



	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: ../availavility.php');

	

    ?>