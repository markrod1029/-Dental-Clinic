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

$id = $_SESSION['patient'];
$query = "SELECT status, COUNT(*) as count FROM appointment_table WHERE YEAR(date) = '$year' AND patient_id = '$id' GROUP BY status";
$result = mysqli_query($conn, $query);

$appointments = [
    'Booked' => 0,
    'Completed' => 0,
    'Canceled' => 0,
    'Pending' => 0
];

while ($row = mysqli_fetch_assoc($result)) {
    $appointments[$row['status']] = $row['count'];
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Dental Clinic Dashboard</h1>
    </section>

    <span id="message"></span>

    <div class="row">
        <!-- Booked Appointments -->
        <div class="col-md-3">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-tooth fa-3x text-primary me-3"></i>
                    <div class="text-center mx-auto">
                        <h5 class="text-primary mb-1">Booked</h5>
                        <h2 class="mb-0"><?= $appointments['Booked']; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Appointments -->
        <div class="col-md-3">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-smile fa-3x text-success me-3"></i>
                    <div class="text-center mx-auto">
                        <h5 class="text-success mb-1">Completed</h5>
                        <h2 class="mb-0"><?= $appointments['Completed']; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canceled Appointments -->
        <div class="col-md-3">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-times-circle fa-3x text-danger me-3"></i>
                    <div class="text-center mx-auto">
                        <h5 class="text-danger mb-1">Canceled</h5>
                        <h2 class="mb-0"><?= $appointments['Canceled']; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Appointments -->
        <div class="col-md-3">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-hourglass-half fa-3x text-warning me-3"></i>
                    <div class="text-center mx-auto">
                        <h5 class="text-warning mb-1">Pending</h5>
                        <h2 class="mb-0"><?= $appointments['Pending']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End of row -->

    <!-- Additional Content Below Cards -->
    <div class="mt-4 text-center">
        <h5 class="text-muted">🦷 Last Updated: <?= date('F j, Y, g:i A'); ?></h5>
        <p class="text-gray">"A healthy smile starts with regular check-ups! Keep your teeth happy!"</p>
    </div>

</div> <!-- End of content-wrapper -->

<?php include 'include/footer.php'; ?>
</div>
