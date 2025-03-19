<?php
include('include/session.php');
include '../timezone.php';
include('include/header.php');
include('include/sidebar.php');
include('include/menubar.php');
include('../database_connection.php'); // Ensure you have a database connection file

$today = date('Y-m-d');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM doctor_schedule_table WHERE doctor_schedule_id = ?";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$id])) {
        $_SESSION['message'] = "Doctor Schedule has been deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete schedule.";
    }
    header("Location: availavility.php");
    exit();
}

// Handle Status Toggle Request
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $current_status = $_GET['status'];
    $new_status = ($current_status == 'Available') ? 'Unavailable' : 'Available';

    $query = "UPDATE doctor_schedule_table SET doctor_schedule_status = ? WHERE doctor_schedule_id = ?";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$new_status, $id])) {
        $_SESSION['message'] = "Doctor Schedule status changed to $new_status.";
    } else {
        $_SESSION['error'] = "Failed to change status.";
    }
    header("Location: availavility.php");
    exit();
}

// Fetch Doctor Schedules
$query = "SELECT doctor_schedule_table.*, doctor_table.doctor_name 
          FROM doctor_schedule_table 
          INNER JOIN doctor_table ON doctor_table.id = doctor_schedule_table.doctor_id 
          ORDER BY doctor_schedule_table.doctor_schedule_id DESC";

$stmt = $pdo->query($query);
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Doctor Schedule Management</h1>
    </section>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h3 class="m-0 font-weight-bold text-success">Doctor Schedule List</h3>
                </div>
                <div class="col" align="right">
                    <a href="add_availavility.php" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <?php if ($_SESSION['type'] == 'Admin') : ?>
                                <th>Doctor Name</th>
                            <?php endif; ?>
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
                        <?php foreach ($schedules as $row) : ?>
                            <tr>
                                <?php if ($_SESSION['type'] == 'Admin') : ?>
                                    <td><?php echo $row["doctor_name"]; ?></td>
                                <?php endif; ?>
                                <td><?php echo $row["doctor_schedule_date"]; ?></td>
                                <td><?php echo $row["doctor_schedule_day"]; ?></td>
                                <td><?php echo $row["doctor_schedule_start_time"]; ?></td>
                                <td><?php echo $row["doctor_schedule_end_time"]; ?></td>
                                <td><?php echo $row["average_consulting_time"] . ' Minute'; ?></td>
                                <td>
                                    <a href="availavility.php?toggle=<?php echo $row['doctor_schedule_id']; ?>&status=<?php echo $row['doctor_schedule_status']; ?>" class="btn btn-<?php echo ($row["doctor_schedule_status"] == 'Available') ? 'primary' : 'danger'; ?> btn-sm">
                                        <?php echo $row["doctor_schedule_status"]; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="update_availavility.php?doctor_schedule_id=<?php echo $row['doctor_schedule_id']; ?>" class="btn btn-warning btn-circle btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="availavility.php?delete=<?php echo $row['doctor_schedule_id']; ?>" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Are you sure you want to delete this?');">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>
