<?php
include('include/session.php');
include '../timezone.php';
include('include/header.php');
include('include/sidebar.php');
include('include/menubar.php');

$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
	$year = $_GET['year'];
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['delete_doctor'])) {
		$id = $_POST['doctor_id'];
		$query = "DELETE FROM doctor_table WHERE id = '$id'";
		mysqli_query($conn, $query);
		$message = "Doctor deleted successfully!";
	} elseif (isset($_POST['change_status'])) {
		$id = $_POST['doctor_id'];
		$new_status = $_POST['current_status'] == 'Available' ? 'Unavailable' : 'Available';
		$query = "UPDATE doctor_table SET doctor_status = '$new_status' WHERE id = '$id'";
		mysqli_query($conn, $query);
		$message = "Doctor status updated!";
	}
}

// Fetch doctors
$query = "SELECT * FROM doctor_table ORDER BY doctor_id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="content-wrapper">
	<section class="content-header">
		<h1 class="h3 mb-4 text-gray">Dentist Management</h1>
	</section>

	<?php if (isset($message)): ?>
		<div class="alert alert-success"><?php echo $message; ?></div>
	<?php endif; ?>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<div class="row">
				<div class="col">
					<h3 class="m-0 font-weight-bold text-success">Dentist List</h3>
				</div>
				<div class="col" align="right">
					<a href="add_dentist.php" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered text-center" id="myTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Image</th>
							<th>Dentist ID</th>
							<th>Email Address</th>
							<th>Full Name</th>
							<th>Phone No.</th>
							<th>Address</th>
							<th>B-date</th>
							<th>Specialty</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_assoc($result)): ?>
							<tr>
								<td><img src="<?php echo $row['doctor_profile_image']; ?>" class="img-thumbnail" width="75" /></td>
								<td><?php echo $row['doctor_id']; ?></td>
								<td><?php echo $row['doctor_email_address']; ?></td>
								<td><?php echo $row['doctor_name']; ?></td>
								<td><?php echo $row['doctor_phone_no']; ?></td>
								<td><?php echo $row['doctor_address']; ?></td>
								<td><?php echo $row['doctor_date_of_birth']; ?></td>
								<td><?php echo $row['doctor_expert_in']; ?></td>
								<td>
									<form method="POST">
										<input type="hidden" name="doctor_id" value="<?php echo $row['id']; ?>">
										<input type="hidden" name="current_status" value="<?php echo $row['doctor_status']; ?>">
										<button type="submit" name="change_status" onclick="return confirm('Are you sure you want to change Status?');"
											class="btn btn-<?php echo $row['doctor_status'] == 'Available' ? 'primary' : 'danger'; ?> btn-sm">
											<?php echo $row['doctor_status']; ?>
										</button>
									</form>
								</td>

								<td align="center" style="white-space: nowrap;">
									<a href="update_dentist.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-circle btn-sm">
										<i class="fas fa-edit"></i>
									</a>
									<form method="POST" style="display:inline-block; margin-left: 5px;" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
										<input type="hidden" name="doctor_id" value="<?php echo $row['id']; ?>">
										<button type="submit" name="delete_doctor" class="btn btn-danger btn-circle btn-sm">
											<i class="fas fa-times"></i>
										</button>
									</form>
								</td>

							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php include('include/footer.php'); ?>