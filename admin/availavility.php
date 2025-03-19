<?php 
ob_start(); // Start output buffering

include('include/session.php'); 
include '../timezone.php'; 
include('include/header.php'); 
include('include/sidebar.php'); 
include('include/menubar.php'); 

// Handle Toggle Status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle_status'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']); 
    $current_status = mysqli_real_escape_string($conn, $_POST['status']); 

    $new_status = ($current_status == 'Available') ? 'Unavailable' : 'Available';

    $query = "UPDATE doctor_schedule_table SET doctor_schedule_status = '$new_status' WHERE doctor_schedule_id = '$id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Doctor schedule status updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating record: " . mysqli_error($conn);
    }
    header("Location: availavility.php");
    exit();
}

// Handle Delete Schedule
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_schedule'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM doctor_schedule_table WHERE doctor_schedule_id = '$id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Doctor schedule deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting record: " . mysqli_error($conn);
    }
    header("Location: availavility.php");
    exit();
}

$query = "SELECT ds.*, d.doctor_name FROM doctor_schedule_table ds 
          INNER JOIN doctor_table d ON ds.doctor_id = d.id 
          ORDER BY ds.doctor_schedule_date DESC";

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
            <div class="row">
                <div class="col">
                    <h3 class="m-0 font-weight-bold text-success">Dentist Schedule List</h3>
                </div>
                <div class="col text-right">
                    <a href="add_availavility.php" class="btn btn-success btn-circle btn-sm">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <?php if ($_SESSION['type'] == 'Admin') { ?>
                                <th>Dentist Name</th>
                            <?php } ?>
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
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <?php if ($_SESSION['type'] == 'Admin') { ?>
                                    <td><?php echo htmlspecialchars($row["doctor_name"]); ?></td>
                                <?php } ?>
                                <td><?php echo htmlspecialchars($row["doctor_schedule_date"]); ?></td>
                                <td><?php echo htmlspecialchars($row["doctor_schedule_day"]); ?></td>
                                <td><?php echo htmlspecialchars($row["doctor_schedule_start_time"]); ?></td>
                                <td><?php echo htmlspecialchars($row["doctor_schedule_end_time"]); ?></td>
                                <td><?php echo htmlspecialchars($row["average_consulting_time"]) . " Min"; ?></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['doctor_schedule_id']; ?>">
                                        <input type="hidden" name="status" value="<?php echo $row['doctor_schedule_status']; ?>">
                                        <button type="submit" name="toggle_status" class="btn btn-<?php echo ($row["doctor_schedule_status"] == 'Available') ? 'primary' : 'danger'; ?> btn-sm"
										onclick="return confirm('Are you sure you want to change Status?');">
                                            <?php echo ($row["doctor_schedule_status"] == 'Available') ? 'Available' : 'Unavailable'; ?>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="update_availavility.php?dentist_schedule_id=<?php echo $row['doctor_schedule_id']; ?>" class="btn btn-warning btn-circle btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['doctor_schedule_id']; ?>">
                                        <button type="submit" name="delete_schedule" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Are you sure?');">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>
<?php ob_end_flush(); ?> <!-- End output buffering -->
