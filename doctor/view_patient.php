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
                            		<h3 class="m-0 font-weight-bold text-success">Patient List</h3>
                            	</div>
                            	<div class="col" align="right">
                            		<a href="add_patient.php" type="button" name="add_doctor" id="add_doctor" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></a>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>date</th>
                                            <th>Apointment Time</th>
                                            <th>Apointment Reason</th>
                                            <th>Doctor Comment</th>
                                            <th>Disease</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $id = $_GET['id'];
                                        $sql = "SELECT * FROM appointment_table WHERE id = $id";
                                        $query = $conn->query($sql);
                                        while($row = $query->fetch_assoc()){

                                        ?>
                                    <tr>

                                        <td><?php echo $row['date'];?></td>
                                        <td><?php echo $row['appointment_time'];?></td>
                                        <td><?php echo $row['reason_for_appointment'];?></td>
                                        <td><?php echo $row['doctor_comment'];?></td>
                                        <td><?php echo $row['disease'];?></td>
                                        </tr>
                                        
                                        <?php
                                        }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('include/footer.php');
                ?>

