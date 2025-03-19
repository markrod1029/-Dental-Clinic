<?php
ob_start(); // Start output buffering
include('include/session.php');
include('../timezone.php');
include('include/header.php');
include('include/sidebar.php');
include('include/menubar.php');

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete only booked appointments related to the schedule
    $delete_appointments_query = "DELETE FROM appointment_table WHERE doctor_schedule_id = $delete_id AND status = 'Booked'";
    mysqli_query($conn, $delete_appointments_query);

    // Delete the doctor schedule itself
    $query = "DELETE FROM doctor_schedule_table WHERE doctor_schedule_id = $delete_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Doctor schedule and booked appointments deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting record: " . mysqli_error($conn);
    }
    
    header("Location: availavility.php");
    exit();
}


// Handle Status Toggle Request
if (isset($_GET['toggle_id']) && isset($_GET['status'])) {
    $toggle_id = $_GET['toggle_id'];
    $new_status = ($_GET['status'] == 'Available') ? 'Unavailable' : 'Available';
    $query = "UPDATE doctor_schedule_table SET doctor_schedule_status = '$new_status' WHERE doctor_schedule_id = $toggle_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Doctor schedule status updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating record: " . mysqli_error($conn);
    }
    header("Location: availavility.php");
    exit();
}

// Fetch Schedule Data
$id = $_SESSION['doctor'];
$query = "SELECT ds.*, d.doctor_name FROM doctor_schedule_table ds
          INNER JOIN doctor_table d ON d.id = ds.doctor_id
          Where d.id = '$id'
          ORDER BY ds.doctor_schedule_id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Dentist Schedule Management</h1>
    </section>
    <?php 
    if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php } ?>

    <?php 
    if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php } ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-success">Dentist Schedule List</h3>
            <div align="right">
                <a href="add_availavility.php" class="btn btn-success btn-circle btn-sm">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
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
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['doctor_schedule_date']; ?></td>
                                <td><?= $row['doctor_schedule_day']; ?></td>
                                <td><?= $row['doctor_schedule_start_time']; ?></td>
                                <td><?= $row['doctor_schedule_end_time']; ?></td>
                                <td><?= $row['average_consulting_time']; ?> Min</td>
                                <td>
                                    <a href="?toggle_id=<?= $row['doctor_schedule_id']; ?>&status=<?= $row['doctor_schedule_status']; ?>" 
                                       class="btn btn-sm <?= ($row['doctor_schedule_status'] == 'Available') ? 'btn-primary' : 'btn-danger'; ?>"
									   onclick="return confirm('Are you sure you want to change Status?');">
                                        <?= $row['doctor_schedule_status']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="update_availavility.php?doctor_schedule_id=<?= $row['doctor_schedule_id']; ?>" 
                                       class="btn btn-warning btn-circle btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    &nbsp;
                                    <a href="?delete_id=<?= $row['doctor_schedule_id']; ?>" 
                                       onclick="return confirm('Are you sure?');" 
                                       class="btn btn-danger btn-circle btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
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
