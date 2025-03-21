<?php include('include/session.php'); ?>

<?php
include '../timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
?>


<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>
<?php include('include/menubar.php');

?>


<div class="content-wrapper">

    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Dentist Schudule Managment</h1>

    </section>

    <span id="message"></span>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="h3 m-0 font-weight-bold text-success">Dentist Schudule Add</h6>
                </div>

            </div>
        </div>
        <div class="card-body">


            <form class="form-horizontal box-show" method="POST" action="crud/schedule_add.php" enctype="multipart/form-data" id="doctor_form">

                <span id="form_message"></span>

                <?php

                $id = $user['id'];
                $sql = " SELECT * FROM doctor_table 
                            WHERE id = '$id' ";
                $query = $conn->query($sql);
                $row = $query->fetch_assoc(); ?>



                <input type="hidden" name="id" id="doctor_schedule_date" class="form-control" value='<?php echo $row["id"]; ?>' required />


                <div class="form-group">
                    <label>Schedule Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input type="date" name="doctor_schedule_date" id="doctor_schedule_date" class="form-control" required />
                    </div>
                </div>
                <div class="form-group">
                    <label>Start Time</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                        </div>
                        <input type="time" name="doctor_schedule_start_time" id="doctor_schedule_start_time" class="form-control " />
                    </div>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                        </div>
                        <input type="time" name="doctor_schedule_end_time" id="doctor_schedule_end_time" class="form-control" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Average Consulting Time</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                        </div>
                        <select name="average_consulting_time" id="average_consulting_time" class="form-control" required>
                            <option value="">Select Consulting Duration</option>
                            <?php
                            $count = 0;
                            for ($i = 1; $i <= 15; $i++) {
                                $count += 5;
                                echo '<option value="' . $count . '">' . $count . ' Minute</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
            <button type="reset" class="btn btn-default">Reset</button>
        </div>
        </form>



    </div>
</div>
</div>



<?php
include('include/footer.php');
?>

<!--                 
<script>
$(document).ready(function(){

	var dataTable = $('#doctor_schedule_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"doctor_schedule_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
                <?php
                if ($_SESSION['type'] == 'Admin') {
                ?>
                "targets":[6, 7],
                <?php
                } else {
                ?>
                "targets":[5, 6],
                <?php
                }
                ?>
				
				"orderable":false,
			},
		],
	});

    var date = new Date();
    date.setDate(date.getDate());

    $('#doctor_schedule_date').datepicker({
        startDate: date,
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $('#doctor_schedule_start_time').datetimepicker({
        format: 'HH:mm'
    });

    $('#doctor_schedule_end_time').datetimepicker({
        useCurrent: false,
        format: 'HH:mm'
    });

    $("#doctor_schedule_start_time").on("change.datetimepicker", function (e) {
        console.log('test');
        $('#doctor_schedule_end_time').datetimepicker('minDate', e.date);
    });

    $("#doctor_schedule_end_time").on("change.datetimepicker", function (e) {
        $('#doctor_schedule_start_time').datetimepicker('maxDate', e.date);
    });

});
</script> -->