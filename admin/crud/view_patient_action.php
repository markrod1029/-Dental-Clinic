<?php

//doctor_action.php

include('../../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('date','reason_for_appointment', 
		'doctor_comment', 'disease');

		$output = array();

		$main_query = "SELECT * FROM appointment_table WHERE patient_id = '".$_POST["patient_id"]."' ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR reason_for_appointment LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_comment LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR disease LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY appointment_number DESC ';
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

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["date"];
			$sub_array[] = $row["reason_for_appointment"];
			$sub_array[] = $row["doctor_comment"];
			$sub_array[] = $row["disease"];


			$status = '';
			
			$sub_array[] = '
			<div align="center">
			<a " name="view"  href="view_patient.php?patient_id='.$row['patient_id'].'"  class="btn btn-info btn-circle btn-sm view_button" ><i class="fas fa-eye"></i></a>
			<a  name="edit" href="update_patient.php?patient_id='.$row['patient_id'].'" class="btn btn-warning btn-circle btn-sm" ><i class="fas fa-edit"></i></a>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["patient_id"].'"><i class="fas fa-times"></i></button>
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



}

?>