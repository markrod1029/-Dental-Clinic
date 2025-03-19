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
  <h1 class="h3 mb-4 text-gray">Doctor Managment</h1>

        </section>
                        
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="h3 m-0 font-weight-bold text-success">Doctor Schedule Update</h6>
                            	</div>
                            	
                            </div>
                        </div>
                        <div class="card-body">


                               <?php
                            $ID = $_GET['doctor_schedule_id'];
                            $view = "SELECT * from doctor_schedule_table where doctor_schedule_id = '$ID'";
                            $result = $conn->query($view);
                            $view = $result->fetch_assoc();
                            
                            ?>
       
                        
<form  class="form-horizontal box-show" method="POST" action="" enctype="multipart/form-data" id="doctor_form">
        
        <span id="form_message"></span>
        <div class="form-group">
                        <label>Select Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-control" required>
                            <option value="">Select Doctor</option>
                            <?php
                          

                            $sql = " SELECT * FROM doctor_table 
                            WHERE doctor_status = 'Active' 
                            ORDER BY doctor_name ASC";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                echo '
                                <option value="'.$row["doctor_id"].'">'.$row["doctor_name"].'</option>
                                ';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Schedule Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="date" name="doctor_schedule_date"  id="doctor_schedule_date" class="form-control" value="<?php echo $view['doctor_schedule_date']?>" required  />
                        </div>
                    </div>
		          	<div class="form-group">
		          		<label>Start Time</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
		          		    <input type="time" name="doctor_schedule_start_time"  value="<?php echo $view['doctor_schedule_start_time']?>" id="doctor_schedule_start_time" class="form-control "  />
                        </div>
		          	</div>
                    <div class="form-group">
                        <label>End Time</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
                            <input type="time" name="doctor_schedule_end_time" value="<?php echo $view['doctor_schedule_end_time']?>" id="doctor_schedule_end_time" class="form-control"  autocomplete="off" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Average Consulting Time</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
                            <select name="average_consulting_time" id="average_consulting_time" class="form-control" required>
                                <option value="<?php echo $view['average_consulting_time']?>" >Select Consulting Duration</option>
                                <?php
                                $count = 0;
                                for($i = 1; $i <= 15; $i++)
                                {
                                    $count += 5;
                                    echo '<option value="'.$count.'">'.$count.' Minute</option>';
                                }
                                ?>
                            </select>
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

if(isset($_POST['submit'])){
 
    $doctor_id = $_POST['doctor_id'];
    $doctor_schedule_date = $_POST['doctor_schedule_date'];
    $doctor_schedule_start_time = $_POST['doctor_schedule_start_time'];
    $doctor_schedule_end_time = $_POST['doctor_schedule_end_time'];
    $average_consulting_time = $_POST['average_consulting_time'];

   


     $sql = "UPDATE doctor_schedule_table SET doctor_id = '$doctor_id', doctor_schedule_date = '$doctor_schedule_date',
      doctor_schedule_start_time = '$doctor_schedule_start_time', doctor_schedule_end_time = '$doctor_schedule_end_time',
      average_consulting_time = '$average_consulting_time'
       WHERE doctor_schedule_id = '$ID'";
     if($conn->query($sql)){
       $_SESSION['success'] = 'Schedules updated successfully';
       ?>

<script type="text/javascript">
window.location.href = "availavility.php";

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
                        
                <?php
                include('include/footer.php');
                ?>
