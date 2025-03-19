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
        <h1 class="h3 mb-4 text-gray">Dentist Management</h1>
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
            <h6 class="h3 m-0 font-weight-bold text-success">Dentist Update</h6>
        </div>
        <div class="card-body">
            <form class="form-horizontal box-show" method="POST" action="" enctype="multipart/form-data" id="doctor_form">
                <div class="form-group">
                    <label>Profile Image</label>
                    <div class="mb-3">
                        <img src="<?php echo (!empty($user['doctor_profile_image']) && file_exists('../images/' . $user['doctor_profile_image'])) ? '../images/' . $user['doctor_profile_image'] : '../images/profile.jpg'; ?>"
                            class="img-circle elevation-2" style="height: 80px; width: 80px; margin-bottom: 10px;">
                    </div>
                    <input type="file" name="doctor_profile_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Dentist Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="doctor_email_address" class="form-control" required value="<?php echo htmlspecialchars($user['doctor_email_address']); ?>" />
                </div>
                <div class="form-group">
                    <label>New Password (leave blank if not changing)</label>
                    <input type="password" name="doctor_password" class="form-control" placeholder="Enter new password if changing" />
                </div>
                <div class="form-group">
                    <label>Dentist Name <span class="text-danger">*</span></label>
                    <input type="text" name="doctor_name" class="form-control" required value="<?php echo htmlspecialchars($user['doctor_name']); ?>" />
                </div>
                <div class="form-group">
                    <label>Dentist Phone No. <span class="text-danger">*</span></label>
                    <input type="text" name="doctor_phone_no" class="form-control" required value="<?php echo htmlspecialchars($user['doctor_phone_no']); ?>" />
                </div>
                <div class="form-group">
                    <label>Dentist Address</label>
                    <input type="text" name="doctor_address" class="form-control" value="<?php echo htmlspecialchars($user['doctor_address']); ?>" />
                </div>
                <div class="form-group">
                    <label>Dentist Date of Birth</label>
                    <input type="date" name="doctor_date_of_birth" class="form-control" value="<?php echo htmlspecialchars($user['doctor_date_of_birth']); ?>" />
                </div>
                <div class="form-group">
                    <label>Dentist Speciality <span class="text-danger">*</span></label>
                    <input type="text" name="doctor_expert_in" class="form-control" required value="<?php echo htmlspecialchars($user['doctor_expert_in']); ?>" />
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
    $doctor_email_address = $_POST['doctor_email_address'];
    $doctor_name = $_POST['doctor_name'];
    $doctor_phone_no = $_POST['doctor_phone_no'];
    $doctor_address = $_POST['doctor_address'];
    $doctor_date_of_birth = $_POST['doctor_date_of_birth'];
    $doctor_expert_in = $_POST['doctor_expert_in'];
    $ID = $_SESSION['doctor'];

    $sql = "SELECT doctor_password, doctor_profile_image FROM doctor_table WHERE id = '$ID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_password = $row['doctor_password'];
    $current_image = $row['doctor_profile_image'];

    $doctor_password = !empty($_POST['doctor_password']) ? password_hash($_POST['doctor_password'], PASSWORD_BCRYPT) : $current_password;

    if (!empty($_FILES['doctor_profile_image']['name'])) {
        $target_dir = "../images/";
        $new_image_name = "doctor_" . time() . "." . pathinfo($_FILES["doctor_profile_image"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES["doctor_profile_image"]["tmp_name"], $target_file)) {
            if (!empty($current_image) && file_exists($target_dir . $current_image)) {
                unlink($target_dir . $current_image);
            }
        } else {
            $_SESSION['error'] = "File upload failed.";
            header("Location: profile.php");
            exit();
        }
    } else {
        $new_image_name = $current_image;
    }

    $sql = "UPDATE doctor_table SET 
                doctor_email_address = ?, 
                doctor_password = ?, 
                doctor_name = ?, 
                doctor_phone_no = ?, 
                doctor_address = ?, 
                doctor_date_of_birth = ?, 
                doctor_expert_in = ?, 
                doctor_profile_image = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $doctor_email_address, $doctor_password, $doctor_name, $doctor_phone_no, $doctor_address, $doctor_date_of_birth, $doctor_expert_in, $new_image_name, $ID);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Dentist Profile updated successfully';
        echo '<script>window.location.href = "profile.php";</script>';

        exit();
    } else {
        $_SESSION['error'] = $conn->error;
        echo '<script>window.location.href = "profile.php";</script>';
    }

    $stmt->close();
}
?>
