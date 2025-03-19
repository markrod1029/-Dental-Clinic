<?php include('include/session.php'); ?>
<?php
include '../timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
?>

<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>
<?php include('include/menubar.php'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Patient Management</h1>
    </section>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="h3 m-0 font-weight-bold text-success">Patient Update</h6>
        </div>

        <div class="card-body">
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Profile Image</label>
                    <div class="mb-3">
                        <img src="<?php echo (!empty($user['patient_photo']) && file_exists('../images/' . $user['patient_photo'])) ? '../images/' . $user['patient_photo'] : '../images/profile.jpg'; ?>"
                            class="img-circle elevation-2" style="height: 80px; width: 80px; margin-bottom: 10px;">
                    </div>
                    <input type="file" name="patient_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="patient_email" class="form-control" required value="<?php echo htmlspecialchars($user['patient_email_address']); ?>" />
                </div>

                <div class="form-group">
                    <label>New Password (leave blank if not changing)</label>
                    <input type="password" name="patient_password" class="form-control" placeholder="Enter new password if changing" />
                </div>

                <div class="form-group">
                    <label>First Name <span class="text-danger">*</span></label>
                    <input type="text" name="patient_first_name" class="form-control" required value="<?php echo htmlspecialchars($user['patient_first_name']); ?>" />
                </div>
                <div class="form-group">
                    <label>Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="patient_last_name" class="form-control" required value="<?php echo htmlspecialchars($user['patient_last_name']); ?>" />
                </div>

                <div class="form-group">
                    <label>Gender <span class="text-danger">*</span></label>
                    <select name="patient_gender" class="form-control">
                        <option value="Male" <?php echo ($user['patient_gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($user['patient_gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Contact No. <span class="text-danger">*</span></label>
                    <input type="text" name="patient_phone_no" class="form-control" required value="<?php echo htmlspecialchars($user['patient_phone_no']); ?>" />
                </div>

                <div class="form-group">
                    <label>Complete Address <span class="text-danger">*</span></label>
                    <textarea name="patient_address" class="form-control" required><?php echo htmlspecialchars($user['patient_address']); ?></textarea>
                </div>

                <div class="modal-footer">
                    <input type="submit" name="submit" class="btn btn-success" value="Update" />
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    $patient_email = $_POST['patient_email'];
    $patient_first_name = $_POST['patient_first_name'];
    $patient_last_name = $_POST['patient_last_name'];
    $patient_address = $_POST['patient_address'];
    $patient_phone = $_POST['patient_phone_no'];
    $patient_gender = $_POST['patient_gender'];
    $patient_id = $user['id'];

    // Fetch current data
    $sql = "SELECT patient_password, patient_photo FROM patient_table WHERE id = '$patient_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_password = $row['patient_password'];
    $current_image = $row['patient_photo'];

    // Check if new password is provided
    $new_password = !empty($_POST['patient_password']) ? password_hash($_POST['patient_password'], PASSWORD_BCRYPT) : $current_password;

    // Handle image upload
    if (!empty($_FILES['patient_image']['name'])) {
        $target_dir = "../images/";
        $image_file = basename($_FILES["patient_image"]["name"]);
        $image_file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));
        $valid_extensions = ["jpg", "jpeg", "png"];

        if (in_array($image_file_type, $valid_extensions)) {
            $new_image_name = "patient_" . time() . "." . $image_file_type;
            $target_file = $target_dir . $new_image_name;

            if (move_uploaded_file($_FILES["patient_image"]["tmp_name"], $target_file)) {
                if (!empty($current_image) && file_exists($target_dir . $current_image)) {
                    unlink($target_dir . $current_image);
                }
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            header("Location: profile.php");
            exit();
        }
    } else {
        $new_image_name = $current_image;
    }

    // Update the database
    $sql = "UPDATE patient_table SET 
                patient_email_address = '$patient_email',
                patient_password = '$new_password',
                patient_first_name = '$patient_first_name',
                patient_last_name = '$patient_last_name',
                patient_address = '$patient_address',
                patient_phone_no = '$patient_phone',
                patient_gender = '$patient_gender',
                patient_photo = '$new_image_name'
            WHERE id = '$patient_id'";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Patient updated successfully';
        echo '<script>window.location.href = "profile.php";</script>';
    } else {
        $_SESSION['error'] = $conn->error;
    }
}
?>
