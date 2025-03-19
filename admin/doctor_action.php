<?php
include('../database_connection.php'); // Ensure DB connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_doctor"])) {
        $email = $_POST["doctor_email"];
        $name = $_POST["doctor_name"];
        $phone = $_POST["doctor_phone"];
        $address = $_POST["doctor_address"];
        $dob = $_POST["doctor_dob"];
        $specialty = $_POST["doctor_specialty"];
        $status = "Available"; // Default status

        $query = "INSERT INTO doctor_table (doctor_email_address, doctor_name, doctor_phone_no, doctor_address, doctor_date_of_birth, doctor_expert_in, doctor_status) 
                  VALUES ('$email', '$name', '$phone', '$address', '$dob', '$specialty', '$status')";
        
        if (mysqli_query($conn, $query)) {
            $message = "Doctor added successfully!";
        } else {
            $message = "Error adding doctor: " . mysqli_error($conn);
        }
    }

    if (isset($_POST["update_doctor"])) {
        $id = $_POST["doctor_id"];
        $email = $_POST["doctor_email"];
        $name = $_POST["doctor_name"];
        $phone = $_POST["doctor_phone"];
        $address = $_POST["doctor_address"];
        $dob = $_POST["doctor_dob"];
        $specialty = $_POST["doctor_specialty"];

        $query = "UPDATE doctor_table SET 
                  doctor_email_address = '$email', 
                  doctor_name = '$name', 
                  doctor_phone_no = '$phone', 
                  doctor_address = '$address', 
                  doctor_date_of_birth = '$dob', 
                  doctor_expert_in = '$specialty' 
                  WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) {
            $message = "Doctor updated successfully!";
        } else {
            $message = "Error updating doctor: " . mysqli_error($conn);
        }
    }
    
    if (isset($_POST["delete_doctor"])) {
        $id = $_POST["doctor_id"];
        $query = "DELETE FROM doctor_table WHERE id = '$id'";
        if (mysqli_query($conn, $query)) {
            $message = "Doctor deleted successfully!";
        } else {
            $message = "Error deleting doctor: " . mysqli_error($conn);
        }
    }

    if (isset($message)) {
        echo "<script>alert('$message'); window.location.href='doctor.php';</script>";
    }
}
?>
