<?php include('include/session.php');?>
                <?php include('include/header.php');?>
                <?php include('include/sidebar.php');?>
                <?php include('include/menubar.php');
                
                ?>

<?php

//dashboard.php



include('../class/Appointment.php');

$object = new Appointment;


?>


<div class="container-fluid">
<div  style="margin-left:270px;">

<h1 class="h3 mb-4 text-gray">Appointment Management</h1>
</div>

<!-- DataTales Example -->
<div  style="margin-left:250px;">

<span id="message"></span>
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-sm-6">
				<h3 class="m-0 font-weight-bold text-success">Mu Appointment List</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
		      		<table class="table table-striped table-bordered" id="appointment_list_table">
		      			<thead>
			      			<tr>
			      				<th>Appointment No.</th>
			      				<th>Doctor Name</th>
			      				<th>Appointment Date</th>
			      				<th>Appointment Time</th>
			      				<th>Appointment Day</th>
			      				<th>Appointment Status</th>
			      				<th>Download</th>
			      				<th>Cancel</th>
			      			</tr>
			      		</thead>
			      		<tbody></tbody>
			      	</table>
			    </div>
			</div>
		</div>
	</div>

</div>

<?php

include('include/footer.php');

?>


<script>

$(document).ready(function(){

	var dataTable = $('#appointment_list_table').DataTable({
		"processing" : true,
		"lengthChange": false,

		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"action.php",
			type:"POST",
			data:{action:'fetch_appointment'}
		},
		"columnDefs":[
			{
                "targets":[6, 7],				
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.cancel_appointment', function(){
		var appointment_id = $(this).data('id');
		if(confirm("Are you sure you want to cancel this appointment?"))
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{appointment_id:appointment_id, action:'cancel_appointment'},
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