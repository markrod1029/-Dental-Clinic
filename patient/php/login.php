

<?php
    session_start();
    include 'config.php';

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];


        $sql = "SELECT * FROM admin_table WHERE email = '$email'";
        $query = $conn->query($sql);

        $sql1 = "SELECT * FROM doctor_table WHERE doctor_email_address = '$email' AND doctor_status = 'Available'";
        $query1 = $conn->query($sql1);

        $sql2 = "SELECT * FROM patient_table WHERE patient_email_address = '$email'";
        $query2 = $conn->query($sql2);
        
        if ($query->num_rows >= 1) {

            $row = $query->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['admin'] = $row['id'];
            }

            else{
                $_SESSION['error'] = 'Incorrect password';
            }

    
        } 



        else if ($query1->num_rows >= 1) {

            $row1 = $query1->fetch_assoc();
            if(password_verify($password, $row1['doctor_password'])){
                $_SESSION['doctor'] = $row1['id'];
                $_SESSION['admin_id'] = $row1['id'];
                $_SESSION['doctor_id'] = $row1['doctor_id'];
            }

            else{
                $_SESSION['error'] = 'Incorrect password';
            }

            
    
    }

    
            else if ($query2->num_rows >= 1) {

                $row2 = $query2->fetch_assoc();
                if(password_verify($password, $row2['patient_password'])){
                    $_SESSION['patient'] = $row2['id'];
                    $_SESSION['patient_id'] = $row2['patient_id'];
                }

                else{
                    $_SESSION['error'] = 'Incorrect password';
                }


            }

    else{
        $_SESSION['error'] = 'Cannot find account with the Email';


    }

    
}



else{
$_SESSION['error'] = 'Cannot find account with the Email';


}




    header('location: ../login.php');

?>



