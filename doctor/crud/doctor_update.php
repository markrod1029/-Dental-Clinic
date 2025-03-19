<?php
	include 'conn.php';

    $id = $_GET['patient_id'];
    if(isset($_POST['submit'])){
     
        $patient_email_address = $_POST['patient_email_address'];
        $patient_password = password_hash($_POST['patient_password'], PASSWORD_DEFAULT);
        $patient_first_name = $_POST['patient_first_name'];
        $patient_last_name = $_POST['patient_last_name'];
        $patient_date_of_birth = $_POST['patient_date_of_birth'];
        $patient_gender = $_POST['patient_gender'];
        $patient_phone_no = $_POST['patient_phone_no'];
        $patient_maritial_status = $_POST['patient_maritial_status'];
        $patient_address = $_POST['patient_address'];


       
    
    
        
    
         $sql = "UPDATE patient_table SET patient_email_address = '$patient_email_address', patient_password = '$patient_password',
          patient_first_name = '$patient_first_name', patient_last_name = '$patient_last_name', patient_date_of_birth = '$patient_date_of_birth',
          patient_gender = '$patient_gender', patient_phone_no = '$patient_phone_no', patient_maritial_status = '$patient_maritial_status',
          patient_address = '$patient_address', WHERE id = '$id'";
         if($conn->query($sql)){
           $_SESSION['success'] = 'Schedules updated successfully';
    
         }
         else{
           $_SESSION['error'] = $conn->error;
         }
      }
       else{
         $_SESSION['error'] = 'Fill up edit form first';
       }

header('location: ../patient.php');