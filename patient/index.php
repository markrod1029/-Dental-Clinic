<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Online Doctor Appointment Management System in PHP</title>

	    <!-- Custom styles for this page -->
	    <link href="../vendor/bootstrap/bootstrap.min.css" rel="stylesheet">

	    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css"/>

	    <link rel="stylesheet" type="text/css" href="../vendor/datepicker/bootstrap-datepicker.css"/>

	    <!-- Custom styles for this page -->
    	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	    <style>
	    	.border-top { border-top: 1px solid #e5e5e5; }
			.border-bottom { border-bottom: 1px solid #e5e5e5; }

			.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
	    </style>
	</head>
	<body>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-primary border-bottom box-shadow">
			<div class="col">
		    	<h5 class="my-0 mr-md-auto font-weight-normal"><a href="#" class="text-white" style="text-decoration: none;">Online Doctor Appointment in PHP</a></h5>
		    </div>
		    <?php
		    if(!isset($_SESSION['patient_id']))
		    {
		    ?>
		    <div class="col text-right"><a href="login.php" class="text-white" style="text-decoration: none;">Login</a></div>
		   	<?php
		   	}
		   	?>
		    
	    </div>

	    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
	      	<h1 class="display-4">Online Doctor Appointment Management System</h1>
	    </div>
	    <br />
	    <br />
	    <div class="container-fluid">
            
            <?php

//login.php


include('../class/Appointment.php');

$object = new Appointment;

?>

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col col-md-4">
			<?php
			if(isset($_SESSION["success_message"]))
			{
				echo $_SESSION["success_message"];
				unset($_SESSION["success_message"]);
			}
			?>
			<span id="message"></span>
			<div class="card">
				<div class="card-header">Login</div>
				<div class="card-body">
					<form method="post" id="patient_login_form">
						<div class="form-group">
							<label>Patient Email Address</label>
							<input type="text" name="patient_email_address" id="patient_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" placeholder="Email Address" />
						</div>
						<div class="form-group">
							<label>Patient Password</label>
							<input type="password" name="patient_password" id="patient_password" class="form-control" required  data-parsley-trigger="keyup" placeholder="Password" />
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="patient_login" />
							<input type="submit" name="patient_login_button" id="patient_login_button" class="btn btn-primary" value="Login" />
						</div>

						<div class="form-group text-center">
							<p><a href="register.php">Register</a></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php



?>


<script>

$(document).ready(function(){

	$('#patient_login_form').parsley();

	$('#patient_login_form').on('submit', function(event){

		event.preventDefault();

		if($('#patient_login_form').parsley().isValid())
		{
			$.ajax({

				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function()
				{
					$('#patient_login_button').attr('disabled', 'disabled');
				},
				success:function(data)
				{
					$('#patient_login_button').attr('disabled', false);

					if(data.error != '')
					{
						$('#message').html(data.error);
					}
					else
					{
						window.location.href="home.php";
					}
				}
			});
		}

	});

});



</script>