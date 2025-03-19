
<?php

//action.php 

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))


if($_POST['action'] == 'book_appointment')
	{
		$error = '';
		$data = array(
			':patient_id'			=>	$_SESSION['patient_id'],
			':doctor_schedule_id'	=>	$_POST['hidden_doctor_schedule_id']
		);

		$object->query = "
		SELECT * FROM appointment_table 
		WHERE patient_id = :patient_id 
		AND doctor_schedule_id = :doctor_schedule_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">You have already applied for appointment for this day, try for other day.</div>';
		}
		else
		{
			$object->query = "
			SELECT * FROM doctor_schedule_table 
			WHERE doctor_schedule_id = '".$_POST['hidden_doctor_schedule_id']."'
			";

			$schedule_data = $object->get_result();

			$object->query = "
			SELECT COUNT(appointment_id) AS total FROM appointment_table 
			WHERE doctor_schedule_id = '".$_POST['hidden_doctor_schedule_id']."' 
			";

			$appointment_data = $object->get_result();

			$total_doctor_available_minute = 0;
			$average_consulting_time = 0;
			$total_appointment = 0;

			foreach($schedule_data as $schedule_row)
			{
				$end_time = strtotime($schedule_row["doctor_schedule_end_time"] . ':00');

				$start_time = strtotime($schedule_row["doctor_schedule_start_time"] . ':00');

				$total_doctor_available_minute = ($end_time - $start_time) / 60;

				$average_consulting_time = $schedule_row["average_consulting_time"];
			}

			foreach($appointment_data as $appointment_row)
			{
				$total_appointment = $appointment_row["total"];
			}

			$total_appointment_minute_use = $total_appointment * $average_consulting_time;

			$appointment_time = date("H:i", strtotime('+'.$total_appointment_minute_use.' minutes', $start_time));

			$status = '';

			$appointment_number = $object->Generate_appointment_no();

			if(strtotime($end_time) > strtotime($appointment_time . ':00'))
			{
				$status = 'Booked';
			}
			else
			{
				$status = 'Waiting';
			}
			
			$data = array(
				':doctor_id'				=>	$_POST['hidden_doctor_id'],
				':patient_id'				=>	$_SESSION['patient_id'],
				':doctor_schedule_id'		=>	$_POST['hidden_doctor_schedule_id'],
				':appointment_number'		=>	$appointment_number,
				':reason_for_appointment'	=>	$_POST['reason_for_appointment'],
				':appointment_time'			=>	$appointment_time,
				':status'					=>	'Booked'
			);

			$object->query = "
			INSERT INTO appointment_table 
			(doctor_id, patient_id, doctor_schedule_id, appointment_number, reason_for_appointment, appointment_time, status) 
			VALUES (:doctor_id, :patient_id, :doctor_schedule_id, :appointment_number, :reason_for_appointment, :appointment_time, :status)
			";

			$object->execute($data);

			$_SESSION['appointment_message'] = '<div class="alert alert-success">Your Appointment has been <b>'.$status.'</b> with Appointment No. <b>'.$appointment_number.'</b></div>';
		}
		echo json_encode(['error' => $error]);
		
	}