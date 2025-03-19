<?php


	include 'conn.php';

	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$bdate = $_POST['bdate'];
		$gender = $_POST['gender'];
		$status = $_POST['patient_maritial_status'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


			$fileinfo=PATHINFO($_FILES["image"]["name"]);
			$newFilename=$fileinfo['filename']. "." . $fileinfo['extension'];
			move_uploaded_file($_FILES["image"]["tmp_name"],'../../images/' .$newFilename);
			$location = $newFilename;   
			
	
  
		

		$sql = "SELECT email FROM doctor_table  WHERE email = '".$email."' ";
		$query = $conn->query($sql);
		$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);

		$row = $query->fetch_assoc();
		
	
		if ($count == 1 ) {
		$_SESSION['error'] = 'Have already Email Address';

		}
		
		else{
		
		$insert = "INSERT INTO patient_table(images, email, password, fname, lname, bdate, gender,  address,  phone, patient_maritial_status,  added_on) 
		VALUES ('$location', '$email', '$password', '$fname', '$lname', '$bdate', '$gender', '$address', '$phone',  '$status', NOW())";
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