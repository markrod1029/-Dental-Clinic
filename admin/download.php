<?php

include('include/session.php');

// Check if ID is provided
if (!isset($_GET["id"])) {
    die("Invalid request. No appointment ID found.");
}

$appointment_id = $_GET["id"];

// Fetch appointment details
$sql = "SELECT * FROM appointment_table WHERE appointment_id = '$appointment_id'";
$result = mysqli_query($conn, $sql);
$appointment = mysqli_fetch_assoc($result);

if (!$appointment) {
    die("Appointment not found.");
}

// Fetch patient details
$patient_id = $appointment["patient_id"];
$sql = "SELECT * FROM patient_table WHERE id = '$patient_id'";
$result = mysqli_query($conn, $sql);
$patient = mysqli_fetch_assoc($result);

// Fetch doctor details
$doctor_schedule_id = $appointment["doctor_schedule_id"];
$sql = "SELECT * FROM doctor_schedule_table 
        LEFT JOIN doctor_table ON doctor_table.id = doctor_schedule_table.doctor_id 
        WHERE doctor_schedule_table.doctor_schedule_id = '$doctor_schedule_id'";
$result = mysqli_query($conn, $sql);
$doctor_schedule = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Appointment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print(); // Automatically trigger print
        }
    </script>
</head>
<body>

    <h2 align="center">Online Patient Management and Record Management System </h2>
    <p align="center"> Smile Care Dental Clinic</p>
    <hr>

    <h3 align="center">Patient Details</h3>
    <table>
        <tr><th width="50%">Patient Name</th><td><?= $patient["patient_first_name"] . ' ' . $patient["patient_last_name"] ?></td></tr>
        <tr><th>Contact No.</th><td><?= $patient["patient_phone_no"] ?></td></tr>
        <tr><th>Address</th><td><?= $patient["patient_address"] ?></td></tr>
    </table>

    <h3 align="center">Appointment Details</h3>
    <table>
        <tr><th width="50%">Appointment No.</th><td><?= $appointment["appointment_number"] ?></td></tr>
        <tr><th>Doctor Name</th><td><?= $doctor_schedule["doctor_name"] ?></td></tr>
        <tr><th>Appointment Date</th><td><?= $doctor_schedule["doctor_schedule_date"] ?></td></tr>
        <tr><th>Appointment Day</th><td><?= $doctor_schedule["doctor_schedule_day"] ?></td></tr>
        <tr><th>Appointment Time</th><td><?= $appointment["appointment_time"] ?></td></tr>
        <tr><th>Reason for Appointment</th><td><?= $appointment["reason_for_appointment"] ?></td></tr>
        <tr><th>Patient came into Hospital</th><td><?= $appointment["patient_come_into_hospital"] ?></td></tr>
        <tr><th>Doctor Comment</th><td><?= $appointment["doctor_comment"] ?></td></tr>
    </table>

</body>
</html>
