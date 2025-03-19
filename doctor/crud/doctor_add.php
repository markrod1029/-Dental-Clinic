<?php


	include 'conn.php';

	if(isset($_POST['submit'])){
		$doctor_email_address = $_POST['doctor_email_address'];
		$name = $_POST['doctor_name'];
		$doctor_name = $_POST['doctor_name'];
		$doctor_phone_no = $_POST['doctor_phone_no'];
		$doctor_address = $_POST['doctor_address'];
		$doctor_date_of_birth = $_POST['doctor_date_of_birth'];
		$doctor_status = 'Active';
		$doctor_password = password_hash($_POST['doctor_password'], PASSWORD_DEFAULT);
		$doctor_expert_in = $_POST['doctor_expert_in'];



			$fileinfo=PATHINFO($_FILES["doctor_profile_image"]["name"]);
			$newFilename=$fileinfo['filename']. "." . $fileinfo['extension'];
			move_uploaded_file($_FILES["doctor_profile_image"]["tmp_name"],'../../images/' .$newFilename);
			$location = '../images/'.$newFilename;
			
	
  
		

		$sql = "SELECT doctor_email_address FROM doctor_table  WHERE doctor_email_address = '".$doctor_email_address."' ";
		$query = $conn->query($sql);
		$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);

		$row = $query->fetch_assoc();
		
	
		if ($count == 1 ) {
		$_SESSION['error'] = 'Have already Email Address';

		}
		
		else{
		
		$insert = "INSERT INTO doctor_table(doctor_email_address, doctor_password, doctor_name, doctor_profile_image, doctor_phone_no, doctor_address, doctor_date_of_birth, doctor_expert_in, doctor_status, doctor_added_on) 
		VALUES ('$doctor_email_address', '$doctor_password', '$doctor_name', '$location', '$doctor_phone_no', '$doctor_address', '$doctor_date_of_birth', '$doctor_expert_in', '$doctor_status', NOW())";
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

	
    header('location: ../doctor.php');

    ?>