<?php


	include 'conn.php';

	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$name = $_POST['doctor_name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$bdate = $_POST['bdate'];
		$doctor_expert = $_POST['doctor_expert'];
		$status = 'Active';
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
		
		$insert = "INSERT INTO doctor_table(email, password, doctor_name, images, phone, address, bdate, doctor_expert, doctor_status, doctor_added_on) 
		VALUES ('$email', '$password', '$name', '$location', '$phone', '$address', '$bdate', '$doctor_expert', '$status', NOW())";
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