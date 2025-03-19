<?php


	include 'conn.php';

	if(isset($_POST['submit'])){
		$patient_email_address = $_POST['patient_email_address'];
		$patient_first_name = $_POST['patient_first_name'];
		$patient_last_name = $_POST['patient_last_name'];
		$patient_phone_no = $_POST['patient_phone_no'];
		$patient_address = $_POST['patient_address'];
		$patient_date_of_birth = $_POST['patient_date_of_birth'];
		$patient_gender = $_POST['patient_gender'];
		$patient_maritial_status = $_POST['patient_maritial_status'];
		$patient_password = password_hash($_POST['patient_password'], PASSWORD_DEFAULT);


			$fileinfo=PATHINFO($_FILES["patient_photo"]["name"]);
			$newFilename=$fileinfo['filename']. "." . $fileinfo['extension'];
			move_uploaded_file($_FILES["patient_photo"]["tmp_name"],'../../images/' .$newFilename);
			$location = '../images/'.$newFilename;   
			
	
  	//creating patient_id
	  $numbers = '';
	
	  for($i = 0; $i < 10; $i++){
		  $numbers .= $i;
	  }
	  $patient_id = substr(str_shuffle($numbers), 0, 9);
	  //
		

		$sql = "SELECT patient_email_address FROM patient_table  WHERE patient_email_address = '".$patient_email_address."' ";
		$query = $conn->query($sql);
		$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);

		$row = $query->fetch_assoc();
		
	
		if ($count == 1 ) {
		$_SESSION['error'] = 'Have already Email Address';

		}
		
		else{
		
		$insert = "INSERT INTO patient_table(patient_id, patient_email_address, patient_photo, patient_password, patient_first_name, patient_last_name, patient_date_of_birth, patient_gender,  patient_address,  patient_phone_no, patient_maritial_status, patient_status,  added_on) 
		VALUES ('$patient_id', '$patient_email_address', '$location', '$patient_password', '$patient_first_name', '$patient_last_name', '$patient_date_of_birth', '$patient_gender', '$patient_address', '$patient_phone_no',  '$patient_maritial_status', 'Active',  NOW())";
		if($conn->query($insert)){
			$_SESSION['success'] = 'Teacher added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}


	}


}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	
    header('location: ../patient.php');

    ?>