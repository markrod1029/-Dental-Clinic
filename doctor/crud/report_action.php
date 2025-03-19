<?php

//appointment_action.php

include('../../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$output = array();

		if($_SESSION['type'] == 'Admin')
		{
			$order_column = array('appointment_table.appointment_number', 'patient_table.patient_id',  'patient_table.patient_first_name', 'doctor_table.doctor_name', 'doctor_schedule_table.doctor_schedule_date',  'doctor_schedule_table.doctor_schedule_day', 'appointment_table.status');
			$main_query = "
			SELECT * FROM appointment_table  
			INNER JOIN doctor_table 
			ON doctor_table.doctor_id = appointment_table.doctor_id 
			INNER JOIN doctor_schedule_table 
			ON doctor_schedule_table.doctor_schedule_id = appointment_table.doctor_schedule_id 
			INNER JOIN patient_table 
			ON patient_table.patient_id = appointment_table.patient_id 
			";

			$search_query = '';

			if($_POST["is_date_search"] == "yes")
			{
			 	$search_query .= 'WHERE doctor_schedule_table.doctor_schedule_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND (';
			}
			else
			{
				$search_query .= 'WHERE ';
			}

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if($_POST["is_date_search"] == "yes")
			{
				$search_query .= ') ';
			}
			else
			{
				$search_query .= '';
			}
		}
		else
		{
			$order_column = array('appointment_table.appointment_number', 'patient_table.patient_first_name', 'doctor_schedule_table.doctor_schedule_date', 'appointment_table.appointment_time', 'doctor_schedule_table.doctor_schedule_day');

			$main_query = "
			SELECT * FROM appointment_table 
			INNER JOIN doctor_schedule_table 
			ON doctor_schedule_table.doctor_schedule_id = appointment_table.doctor_schedule_id 
			INNER JOIN patient_table 
			ON patient_table.id = appointment_table.patient_id 
			";

			$search_query = '
			WHERE appointment_table.doctor_id = "'.$_SESSION["admin_id"].'" AND appointment_table.status = "Completed" ';

			if($_POST["is_date_search"] == "yes")
			{
			 	$search_query .= 'AND doctor_schedule_table.doctor_schedule_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" ';
			}
			else
			{
				$search_query .= '';
			}

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'AND (appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%") ';
			}
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY appointment_table.appointment_id DESC ';
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
			$sub_array[] = $row["patient_id"];

			$sub_array[] = $row["patient_first_name"] . ' ' . $row["patient_last_name"];

			
			$sub_array[] = $row["doctor_schedule_date"];


			$sub_array[] = $row["doctor_schedule_day"];

			

		
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


}

?>