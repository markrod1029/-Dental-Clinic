<?php
ob_start();
include('include/session.php');
include '../timezone.php';
include('include/header.php');
include('include/sidebar.php');
include('include/menubar.php');

$today = date('Y-m-d');

// Fetch patient details
$patient_id = $_SESSION['id'];
$patient_query = "SELECT * FROM patient_table WHERE id = '$patient_id'";
$patient_result = mysqli_query($conn, $patient_query);
$patient = mysqli_fetch_assoc($patient_result);

$patient_name = $patient['patient_first_name']. ' '.$patient['patient_last_name'];
$patient_contact = $patient['patient_phone_no'];
$patient_address = $patient['patient_address'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_appointment'])) {
    $doctor_id = $_POST['hidden_doctor_id'];
    $schedule_id = $_POST['hidden_doctor_schedule_id'];
    $reason = mysqli_real_escape_string($conn, $_POST['reason_for_appointment']);

        // Generate unique appointment number
        $datePrefix = date('Ymd'); 
        $randomNumber = mt_rand(10000, 99999); 
        $appointment_number = "APT-$datePrefix-$randomNumber";

        
   $insert_query = "INSERT INTO appointment_table (appointment_number, patient_id, doctor_id, doctor_schedule_id, reason_for_appointment, status, date) 
   VALUES ('$appointment_number', '$patient_id', '$doctor_id', '$schedule_id', '$reason', 'Booked', '$today')";

    if (mysqli_query($conn, $insert_query)) {
        // Update doctor schedule status
        $update_query = "UPDATE doctor_schedule_table SET doctor_schedule_status = 'Unavailable' WHERE doctor_schedule_id = '$schedule_id'";
        mysqli_query($conn, $update_query);

        $_SESSION['success'] = "Appointment booked successfully!";
        header("Location: availavility.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong while booking!";
    }
}

// Fetch available appointment schedules
$query = "SELECT doctor_table.doctor_name,  doctor_table.doctor_expert_in,
                 doctor_schedule_table.doctor_schedule_date, doctor_schedule_table.doctor_schedule_day,
                 doctor_schedule_table.doctor_schedule_start_time, doctor_schedule_table.doctor_schedule_end_time,
                 doctor_schedule_table.doctor_schedule_id, doctor_table.id as doctor_id
          FROM doctor_schedule_table 
          INNER JOIN doctor_table ON doctor_table.id = doctor_schedule_table.doctor_id
          WHERE doctor_schedule_table.doctor_schedule_date >= '$today'
          AND doctor_schedule_table.doctor_schedule_status = 'Available'
          AND doctor_table.doctor_status = 'Available'
          ORDER BY doctor_schedule_table.doctor_schedule_date ASC";
$result = mysqli_query($conn, $query);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Appointment Management</h1>
    </section>

    <?php if(isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-success">Appointment List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table  id="myTable"  class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Doctor Name</th>
                            <th>Speciality</th>
                            <th>Appointment Date</th>
                            <th>Appointment Day</th>
                            <th>Available Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row["doctor_name"]; ?></td>
                                <td><?php echo $row["doctor_expert_in"]; ?></td>
                                <td><?php echo $row["doctor_schedule_date"]; ?></td>
                                <td><?php echo $row["doctor_schedule_day"]; ?></td>
                                <td><?php echo $row["doctor_schedule_start_time"] . " - " . $row["doctor_schedule_end_time"]; ?></td>
                                <td align="center">
                                    <button type="button" class="btn btn-primary btn-sm book-appointment-btn"
                                        data-doctor-id="<?php echo $row['doctor_id']; ?>"
                                        data-schedule-id="<?php echo $row['doctor_schedule_id']; ?>"
                                        data-doctor-name="<?php echo $row['doctor_name']; ?>"
                                        data-doctor-expert-in="<?php echo $row['doctor_expert_in']; ?>"
                                        data-schedule-date="<?php echo $row['doctor_schedule_date']; ?>"
                                        data-schedule-day="<?php echo $row['doctor_schedule_day']; ?>"
                                        data-schedule-time="<?php echo $row['doctor_schedule_start_time'] . ' - ' . $row['doctor_schedule_end_time']; ?>">
                                        Book Appointment
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="appointmentModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Make Appointment</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white text-center">
                            <h5 class="m-0">Doctor Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><td><b>Name:</b></td><td id="doctorName"></td></tr>
                                    <tr><td><b>Specialty:</b></td><td id="doctorExpert"></td></tr>
                                    <tr><td><b>Date:</b></td><td id="scheduleDate"></td></tr>
                                    <tr><td><b>Time:</b></td><td id="scheduleTime"></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="m-0">Patient Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><td><b>Patient Name:</b></td><td><?php echo $patient_name; ?></td></tr>
                                    <tr><td><b>Contact No.:</b></td><td><?php echo $patient_contact; ?></td></tr>
                                    <tr><td><b>Address:</b></td><td><?php echo $patient_address; ?></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><b>Reason for Appointment:</b></label>
                        <textarea name="reason_for_appointment" id="reason_for_appointment" class="form-control" required rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="hidden_doctor_id" id="hiddenDoctorId">
                    <input type="hidden" name="hidden_doctor_schedule_id" id="hiddenScheduleId">
                    <button type="submit" name="book_appointment" class="btn btn-success">Book Appointment</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include('include/footer.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".book-appointment-btn").forEach(button => {
        button.addEventListener("click", function() {
            document.getElementById("hiddenDoctorId").value = this.dataset.doctorId;
            document.getElementById("hiddenScheduleId").value = this.dataset.scheduleId;

            document.getElementById("doctorName").textContent = this.dataset.doctorName;
            document.getElementById("doctorExpert").textContent = this.dataset.doctorExpertIn;
            document.getElementById("scheduleDate").textContent = this.dataset.scheduleDate;
            document.getElementById("scheduleTime").textContent = this.dataset.scheduleTime;

            $("#appointmentModal").modal("show");
        });
    });
});
</script>
