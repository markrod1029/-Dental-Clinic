<?php include('include/session.php');?>

<?php 
  include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
?>


                <?php include('include/header.php');?>
                <?php include('include/sidebar.php');?>
                <?php include('include/menubar.php');
                
                ?>

          
  <div class="content-wrapper">

  <section class="content-header">
  <h1 class="h3 mb-4 text-gray">Dentist Managment</h1>

        </section>
                        
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="h3 m-0 font-weight-bold text-success">Dentist Update</h6>
                            	</div>
                            	
                            </div>
                        </div>
                        <div class="card-body">

                        <?php
                            $ID = $_GET['id'];
                            $view = "SELECT * from doctor_table where id = '$ID'";
                            $result = $conn->query($view);
                            $row = $result->fetch_assoc();
                            
                            ?>
       
<form  class="form-horizontal box-show" method="POST" action="" enctype="multipart/form-data" id="doctor_form">
        
        <span id="form_message"></span>
            <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Dentist Email Address <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_email_address" id="doctor_email_address" value="<?php echo $row['doctor_email_address']?>" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Dentist Password <span class="text-danger">*</span></label>
                                <input type="password" name="doctor_password" id="doctor_password" value="<?php echo $row['doctor_password']?>" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Dentist Name <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_name" id="doctor_name" class="form-control" value="<?php echo $row['doctor_name']?>" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Dentist Phone No. <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_phone_no" id="doctor_phone_no" class="form-control" value="<?php echo $row['doctor_phone_no']?>" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Dentist Address </label>
                                <input type="text" name="doctor_address" id="doctor_address" value="<?php echo $row['doctor_address']?>" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Dentist Date of Birth </label>
                                <input type="date" name="doctor_date_of_birth" id="doctor_date_of_birth" value="<?php echo $row['doctor_date_of_birth']?>"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                           
                            <div class="col-md">
                                <label>Dentist   Speciality <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_expert_in" id="doctor_expert_in" class="form-control" value="<?php echo $row['doctor_expert_in']?>" required  data-parsley-trigger="keyup" />
                            </div>

                            
                        </div>
                    </div>
       
    </div>
    <div class="modal-footer">
        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Update" />
        <button type="reset" class="btn btn-default">Reset</button>
    </div>
</form>



                            </div>
                        </div>
                    </div>

                    
                        
                <?php
                include('include/footer.php');
                ?>


			<?php

    if(isset($_POST['submit'])){
     
        $doctor_email_address = $_POST['doctor_email_address'];
		$name = $_POST['doctor_name'];
		$doctor_name = $_POST['doctor_name'];
		$doctor_phone_no = $_POST['doctor_phone_no'];
		$doctor_address = $_POST['doctor_address'];
		$doctor_date_of_birth = $_POST['doctor_date_of_birth'];
		$doctor_password = password_hash($_POST['doctor_password'], PASSWORD_DEFAULT);
		$doctor_expert_in = $_POST['doctor_expert_in'];

       
    
  
         $sql = "UPDATE doctor_table SET doctor_email_address = '$doctor_email_address', doctor_password = '$doctor_password',
          doctor_name = '$doctor_name', doctor_phone_no = '$doctor_phone_no', doctor_address = '$doctor_address',
          doctor_date_of_birth = '$doctor_date_of_birth', doctor_expert_in = '$doctor_expert_in' WHERE id = '$ID'";
         if($conn->query($sql)){
           $_SESSION['success'] = 'Doctor updated successfully';
		   ?>

  <script type="text/javascript">
    window.location.href = "doctor.php";

  </script><?php

    
         }
         else{
           $_SESSION['error'] = $conn->error;


         }
      }
      

	   ?>