<?php
    session_start(); 
    include 'conn.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = 'Active';

        $sql = "UPDATE patient_table SET patient_status = '$status' WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = 'Patient Active successfully!';
        } else {
            $_SESSION['error'] = 'Error: ' . $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Invalid request!';
    }

    // Redirect pabalik sa patient.php
    header('location: ../patient.php');
    exit();
?>
