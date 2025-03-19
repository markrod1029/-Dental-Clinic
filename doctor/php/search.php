<?php
    session_start();
    include_once "config.php";

    $outgoing_id = $_SESSION['doctor_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $sql = "SELECT * FROM patient_table WHERE  (patient_first_name LIKE '%{$searchTerm}%' OR patient_last_name LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No Patient found related to your search term';
    }
    echo $output;
?>