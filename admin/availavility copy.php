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
  <h1 class="h3 mb-4 text-gray">Doctor Schedule Managment</h1>

        </section>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h3 class="m-0 font-weight-bold text-success">Doctor Schedule List</h3>
                            	</div>
                            	<div class="col" align="right">
                            		<a href="add_availavility.php" type="button" name="add_exam" id="add_doctor_schedule" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></a>
                            	</div>
                            </div>

                          
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="doctor_schedule_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <?php
                                            if($_SESSION['type'] == 'Admin')
                                            {
                                            ?>
                                            <th>Doctor Name</th>
                                            <?php
                                            }
                                            ?>
                                            <th>Schedule Date</th>
                                            <th>Schedule Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Consulting Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('include/footer.php');
                ?>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />

<script>
$(document).ready(function(){

	var dataTable = $('#doctor_schedule_table').DataTable({
		"lengthChange": false,
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
                if($_SESSION['type'] == 'Admin')
                {
                ?>
                "targets":[6, 7],
                <?php
                }
                else
                {
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

	$('#add_doctor_schedule').click(function(){
		
		$('#doctor_schedule_form')[0].reset();

		$('#doctor_schedule_form').parsley().reset();

    	$('#modal_title').text('Add Doctor Schedule Data');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#doctor_scheduleModal').modal('show');

    	$('#form_message').html('');

	});

	$('#doctor_schedule_form').parsley();

	$('#doctor_schedule_form').on('submit', function(event){
		event.preventDefault();
		if($('#doctor_schedule_form').parsley().isValid())
		{		
			$.ajax({
				url:"doctor_schedule_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:'json',
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Add');
					}
					else
					{
						$('#doctor_scheduleModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var doctor_schedule_id = $(this).data('id');

		$('#doctor_schedule_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"doctor_schedule_action.php",

	      	method:"POST",

	      	data:{doctor_schedule_id:doctor_schedule_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{
                <?php
                if($_SESSION['type'] == 'Admin')
                {
                ?>
                $('#doctor_id').val(data.doctor_id);
                <?php
                }
                ?>
	        	$('#doctor_schedule_date').val(data.doctor_schedule_date);

                $('#doctor_schedule_start_time').val(data.doctor_schedule_start_time);

                $('#doctor_schedule_end_time').val(data.doctor_schedule_end_time);

	        	$('#modal_title').text('Edit Doctor Schedule Data');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#doctor_scheduleModal').modal('show');

	        	$('#hidden_id').val(doctor_schedule_id);

	      	}

	    })

	});

	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
    	
		var status = $(this).data('status');
		var next_status = 'Available';
		if(status == 'Available')
		{
			next_status = 'Unavailable';
		}
		if(confirm("Are you sure you want to "+next_status+" it?"))
    	{

      		$.ajax({

        		url:"doctor_schedule_action.php",

        		method:"POST",

        		data:{id:id, action:'change_status', status:status, next_status:next_status},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}
	});

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"doctor_schedule_action.php",

        		method:"POST",

        		data:{id:id, action:'delete'},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}

  	});

});
</script>