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
  <h1 class="h3 mb-4 text-gray">Patient Managment</h1>

        </section>
                        
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="h3 m-0 font-weight-bold text-success">Patient Uodate</h6>
                            	</div>
                            	
                            </div>
                        </div>
                        <div class="card-body">

						<form class="form-horizontal" method="POST" enctype="multipart/form-data" action = "">

                        <?php
                            $ID = $_GET['id'];
                            $view = "SELECT * from patient_table where id = '$ID'";
                            $result = $conn->query($view);
                            $row = $result->fetch_assoc();
                            
                            ?>
                        <div class="row">
							<div class="col-md-6">

								<div class="form-group">
									<label>Patient Email Address<span class="text-danger">*</span></label>
									<input type="text" name="patient_email_address" id="patient_email_address"  value="<?php echo $row['patient_email_address']?>" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Password<span class="text-danger">*</span></label>
									<input type="password" name="patient_password" id="patient_password"  value="<?php echo $row['patient_password']?>" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
						</div>

						

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient First Name<span class="text-danger">*</span></label>
									<input type="text" name="patient_first_name" id="patient_first_name" class="form-control" required  value="<?php echo $row['patient_first_name']?>" data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Last Name<span class="text-danger">*</span></label>
									<input type="text" name="patient_last_name" id="patient_last_name" class="form-control"  value="<?php echo $row['patient_last_name']?>" required  data-parsley-trigger="keyup" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Date of Birth<span class="text-danger">*</span></label>
									<input type="text" name="patient_date_of_birth" id="patient_date_of_birth"  value="<?php echo $row['patient_date_of_birth']?>" class="form-control" required  data-parsley-trigger="keyup"  />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Gender<span class="text-danger">*</span></label>
									<select name="patient_gender" id="patient_gender"  value="<?php echo $row['patient_gender']?>" class="form-control">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Contact No.<span class="text-danger">*</span></label>
									<input type="text" name="patient_phone_no" id="patient_phone_no"  value="<?php echo $row['patient_phone_no']?>" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Maritial Status<span class="text-danger">*</span></label>
									<select name="patient_maritial_status" id="patient_maritial_status"   value="<?php echo $row['patient_maritial_status']?>"class="form-control">
										<option value="Single">Single</option>
										<option value="Married">Married</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Patient Complete Address<span class="text-danger">*</span></label>
							<textarea name="patient_address" id="patient_address" class="form-control"  value="<?php echo $row['patient_address']?>" required data-parsley-trigger="keyup"></textarea>
						</div>

                       
                        <div class="modal-footer">
 
                            <button name="submit" id="submit_button" class="btn btn-success" >update</button>
                            <button type="reset" class="btn btn-default" data-dismiss="modal">Reset</button>
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
          patient_address = '$patient_address' WHERE id = '$ID'";
         if($conn->query($sql)){
           $_SESSION['success'] = 'Schedules updated successfully';
		   ?>

  <script type="text/javascript">
    window.location.href = "patient.php";

  </script><?php

    
         }
         else{
           $_SESSION['error'] = $conn->error;


         }
      }
       else{
         $_SESSION['error'] = 'Fill up edit form first';
       }

	   ?>