<?php

//action.php 

include('../class/Appointment.php');
include('include/session.php');

$object = new Appointment;

if(isset($_POST["action"]))
{


	if($_POST['action'] == 'fetch_schedule')
	{
		$output = array();

		$order_column = array('doctor_table.doctor_name', 'doctor_table.doctor_degree', 'doctor_table.doctor_expert_in', 'doctor_schedule_table.doctor_schedule_date', 'doctor_schedule_table.doctor_schedule_day', 'doctor_schedule_table.doctor_schedule_start_time');
		
		$main_query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.id = doctor_schedule_table.doctor_id 
		";


		
		$search_query = '
		WHERE doctor_schedule_table.doctor_schedule_date >= "'.date('Y-m-d').'" 
		AND doctor_schedule_table.doctor_schedule_status = "Available" 
		AND doctor_table.doctor_status = "Available" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_degree LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_expert_in LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_start_time LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY doctor_schedule_table.doctor_schedule_date ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

	

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;



		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

	

		foreach($result as $row )
		{
			$sub_array = array();

			$sub_array[] = $row["doctor_name"];

			$sub_array[] = $row["doctor_degree"];

			$sub_array[] = $row["doctor_expert_in"];

			$sub_array[] = $row["doctor_schedule_date"];

			$sub_array[] = $row["doctor_schedule_day"];

			$sub_array[] = $row["doctor_schedule_start_time"];

			
			
		
		
		

			$sub_array[] = '
			<div align="center">

			<button type="button" name="get_appointment" class="btn btn-primary btn-sm get_appointment" data-doctor_id="'.$row["id"].'" data-doctor_schedule_id="'.$row["doctor_schedule_id"].'">Appointment</button>
			</div>
			';

			

		

			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

	

	if($_POST['action'] == 'make_appointment')
	{
		$object->query = "
		SELECT * FROM patient_table 
		WHERE id = '".$_SESSION["id"]."'
		";

		$patient_data = $object->get_result();


		$object->query = "
		SELECT * FROM appointment_table WHERE patient_id =  '".$_SESSION["id"]."'";
		$appointment_data = $object->get_result();


		$object->query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.id = doctor_schedule_table.doctor_id 
		WHERE doctor_schedule_table.doctor_schedule_id = '".$_POST["doctor_schedule_id"]."'
		";

		$doctor_schedule_data = $object->get_result();

		$html = '
		<h4 class="text-center">Patient Details</h4>
		<table class="table">
		';

		foreach($patient_data as $patient_row)
		{
			$html .= '
			<tr>
				<th width="40%" class="text-right">Patient Name</th>
				<td>'.$patient_row["patient_first_name"].' '.$patient_row["patient_last_name"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Contact No.</th>
				<td>'.$patient_row["patient_phone_no"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Address</th>
				<td>'.$patient_row["patient_address"].'</td>
			</tr>
			';
		}

		$html .= '
		</table>
		<hr />
		<h4 class="text-center">Appointment Details</h4>
		<table class="table">
		';
		foreach($doctor_schedule_data as $doctor_schedule_row)
		{
			$html .= '
			<tr>
				<th width="40%" class="text-right">Doctor Name</th>
				<td>'.$doctor_schedule_row["doctor_name"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Appointment Date</th>
				<td>'.$doctor_schedule_row["doctor_schedule_date"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Appointment Day</th>
				<td>'.$doctor_schedule_row["doctor_schedule_day"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Available Time</th>
				<td>'.$doctor_schedule_row["doctor_schedule_start_time"].' - '.$doctor_schedule_row["doctor_schedule_end_time"].'</td>
			</tr>
			';
		}

		$html .= '
		</table>';
		echo $html;
	}

	if($_POST['action'] == 'book_appointment')
	{
		$error = '';
		$data = array(
			':doctor_schedule_id'	=>	$_POST['hidden_doctor_schedule_id']
			
		);

		$object->query = "
		SELECT * FROM appointment_table 
		WHERE doctor_schedule_id = :doctor_schedule_id
		";



		
		
		
		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">have already applied for appointment for this, try for other day.</div>';
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
			$date = date('Y-m-d H:i:s');
		

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
				':patient_id'				=>	$_SESSION['id'],
				':doctor_schedule_id'		=>	$_POST['hidden_doctor_schedule_id'],
				':appointment_number'		=>	$appointment_number,
				':reason_for_appointment'	=>	$_POST['reason_for_appointment'],
				':appointment_time'			=>	$appointment_time,
				':status'					=>	'Booked',
				':date'						=>	$date
			);

					$data1 = array(
				':doctor_schedule_status'			=>	'Unavailable',
				':doctor_schedule_id'	=>	$_POST['hidden_doctor_schedule_id']
			);
			if($data){

				$object->query = "
				INSERT INTO appointment_table 
				(doctor_id, patient_id, doctor_schedule_id, appointment_number, reason_for_appointment, appointment_time, status, date) 
				VALUES (:doctor_id, :patient_id, :doctor_schedule_id, :appointment_number, :reason_for_appointment, :appointment_time, :status, :date)
				";
	
				$object->execute($data);

			}

			if($data1){

	
			$object->query = " UPDATE doctor_schedule_table 
			SET doctor_schedule_status = :doctor_schedule_status
			WHERE doctor_schedule_id = :doctor_schedule_id
			";
	
	
			$object->execute($data1);
			
			}

			

			$_SESSION['appointment_message'] = '<div class="alert alert-success">Your Appointment has been <b>'.$status.'</b> with Appointment No. <b>'.$appointment_number.'</b></div>';
		}
		echo json_encode(['error' => $error]);


		
		
	}

	if($_POST['action'] == 'fetch_appointment')
	{
		$output = array();

		$order_column = array('appointment_table.appointment_number','doctor_table.doctor_name', 'doctor_schedule_table.doctor_schedule_date', 'appointment_table.appointment_time', 'doctor_schedule_table.doctor_schedule_day', 'appointment_table.status', 'date');
		
		$main_query = "
		SELECT * FROM appointment_table  
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = appointment_table.doctor_id 
		INNER JOIN doctor_schedule_table 
		ON doctor_schedule_table.doctor_schedule_id = appointment_table.doctor_schedule_id 
		
		";

		$search_query = '
		WHERE appointment_table.patient_id = "'.$_SESSION["id"].'" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY appointment_table.appointment_id ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["appointment_number"];

			$sub_array[] = $row["doctor_name"];

			$sub_array[] = $row["doctor_schedule_date"];			

			$sub_array[] = $row["appointment_time"];

			$sub_array[] = $row["doctor_schedule_day"];

			$status = '';

			if($row["status"] == 'Booked')
			{
				$status = '<span class="badge badge-warning"  style="font-size:15px;">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'In Process')
			{
				$status = '<span class="badge badge-primary " style="font-size:15px;">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Completed')
			{
				$status = '<span class="badge badge-success"  style="font-size:15px;">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Cancel')
			{
				$status = '<span class="badge badge-danger"  style="font-size:15px;">' . $row["status"] . '</span>';
			}


			$sub_array[] = $status;


			$sub_array[] = '<button type="button" name="cancel_appointment" class="btn btn-danger btn-sm cancel_appointment" data-id="'.$row["appointment_id"].'"><i class="fas fa-times"></i></button>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

	if($_POST['action'] == 'cancel_appointment')
	{
		$data = array(
			':status'			=>	'Cancel',
			':appointment_id'	=>	$_POST['appointment_id']
		);
		$object->query = "
		UPDATE appointment_table 
		SET status = :status 
		WHERE appointment_id = :appointment_id
		";
		$object->execute($data);
		echo '<div class="alert alert-success">Your Appointment has been Cancel</div>';
	}
}



?>