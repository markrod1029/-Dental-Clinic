<?php include('include/session.php'); ?>
<?php
include '../timezone.php';
$today = date('Y-m-d');
$year = date('Y');

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

include('include/header.php');
include('include/sidebar.php');
include('include/menubar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Appointment Management</h1>
    </section>

    <span id="message"></span>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-success">My Appointment List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Appointment No.</th>
                            <th>Doctor Name</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Appointment Day</th>
                            <th>Appointment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id = $user['id'];
                        $sql = "SELECT 
                                    appointment_table.appointment_number, 
                                    doctor_table.doctor_name, 
                                    doctor_schedule_table.doctor_schedule_date AS date, 
                                    doctor_schedule_table.doctor_schedule_start_time, 
                                    doctor_schedule_table.doctor_schedule_end_time, 
                                    doctor_schedule_table.doctor_schedule_day, 
                                    appointment_table.status, 
                                    appointment_table.appointment_id 
                                FROM appointment_table 
                                LEFT JOIN doctor_table 
                                    ON doctor_table.id = appointment_table.doctor_id 
                                LEFT JOIN doctor_schedule_table 
                                    ON doctor_schedule_table.doctor_schedule_id = appointment_table.doctor_schedule_id  
                                WHERE appointment_table.doctor_id = ? AND appointment_table.status = 'Completed'";

                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            // Pag-format ng status badge
                            $status_classes = [
                                'Booked' => 'badge-warning',
                                'In Process' => 'badge-primary',
                                'Completed' => 'badge-success',
                                'Cancel' => 'badge-danger'
                            ];
                            $status = '<span class="badge p-2 ' . $status_classes[$row["status"]] . '">' . htmlspecialchars($row["status"]) . '</span>';
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['appointment_number']); ?></td>
                                <td><?php echo htmlspecialchars($row["doctor_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row["doctor_schedule_start_time"]) . ' - ' . htmlspecialchars($row["doctor_schedule_end_time"]); ?></td>
                                <td><?php echo htmlspecialchars($row['doctor_schedule_day']); ?></td>
                                <td><?php echo $status; ?></td>
                                <
                            </tr>
                        <?php
                        }
                        mysqli_stmt_close($stmt);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>
